'use strict'

const VH_UNIT = window.innerHeight / 100

/**
 * Adds an ingredient to the list of the chosen ingredients
 * @param {Event} event
 */
async function addIngredientToList(event) {
	// if used on button
	event.preventDefault()
	const listContainer = document.querySelector('div.modal-ingredients-list')
	const inputSearchField = document.querySelector('input#search-ingredient')
	const ingredientName = capitalizeString(event.path[0].innerText)

	let listItems = getIngredientsOfModalList()

	// add new element (if not already present)
	if (listItems.filter((item) => item.name == ingredientName).length == 0) {
		listItems.push({
			name: ingredientName,
			quantity: '1',
		})
	}

	// create HTML tags
	listItems = await Promise.all(
		listItems.map(async (ingredient) => {
			const ingredientId = ingredient.name.toLowerCase().replaceAll(' ', '_')
			let measuresAllowed = await getMeasuresByIngredient(ingredient.name)

			// remove the used measure, if present
			measuresAllowed = measuresAllowed.filter((measure) =>
				ingredient.measure !== undefined
					? measure.name != ingredient.measure.name
					: true
			)

			console.log(ingredient.measure)

			let options =
				ingredient.measure === undefined
					? measuresAllowed
					: [ingredient.measure, ...measuresAllowed]

			options = options.map((measure) => {
				const selected =
					options.indexOf(measure) == 0 ? 'selected="selected"' : ''
				return `<option value="${measure.name}" ${selected}>${measure.acronym}</option>`
			})
			return createIngredientsListItem(ingredient, options)
		})
	)

	// add to container
	listContainer.innerHTML = listItems.join('')
	clearElement(document.querySelector('.search-result'))
	inputSearchField.value = ''
	hideLabel(inputSearchField)
	checkIngredientsListMaxHeight()
}

/**
 * Checks if max height of the ingredients list is greater than a 62vh. If it is
 * it gives the class list-border-bottom to the ingredients list
 */
function checkIngredientsListMaxHeight() {
	const maxHeight = 62 * VH_UNIT
	const modalIngredientsList = document.querySelector('.modal-ingredients-list')
	const scrollHeight = modalIngredientsList.scrollHeight

	if (scrollHeight > maxHeight) {
		modalIngredientsList.classList.add('list-border-bottom')
	}
}

async function getMeasuresByIngredient(ingredient) {
	let measures = []
	await axios
		.get(`./request/request.php?measures=${ingredient}`)
		.then((result) => {
			measures = result.data
		})
		.catch((err) => console.error(err))
	return measures
}

function addIngredients() {
	const ingredientsContainer = document.querySelector('.ingredients-list')
	let ingredients = getIngredientsOfModalList()

	ingredients = ingredients.map(
		(ingredient) => `
            <li data-quantity="${ingredient.quantity}" data-measure="${ingredient.measure.name}">
                <span>${ingredient.name}</span>
                <span>X</span>
            </li>`
	)

	ingredientsContainer.innerHTML = ingredients.join('')
}

/**
 * Returns the list of the ingredients present in the ingredients list
 * @returns an array containg the ingredients
 */
function getIngredientsOfModalList() {
	const listContainer = document.querySelector('div.modal-ingredients-list')
	return Array.from(listContainer.children).map((item) => {
		const [name, quantity, measure] = item.children
		const select = measure.querySelector('select')
		return {
			name: name.innerText,
			quantity: quantity.querySelector('input').value,
			measure: {
				name: select.value,
				acronym: select.options[select.selectedIndex].text,
			},
		}
	})
}

/**
 * Removes the specified element from the ingredients list
 * @param {*} element - The element to remove
 */
function removeElementFromList(element) {
	const ingredientsList = document.querySelector('.modal-ingredients-list')
	element = element.parentElement.parentElement

	ingredientsList.innerHTML = ingredientsList.innerHTML.replace(
		element.outerHTML,
		''
	)
}

/**
 * Returns the html of an ingredient list item
 * @param {*} ingredient - The ingredient to create the row of
 * @param {*} options  - The options for the measures dropdown
 * @returns the html of the list item
 */
function createIngredientsListItem(ingredient, options) {
	return `<div class="row m-auto align-items-center" id="${ingredient.name
		.toLowerCase()
		.replaceAll(' ', '_')}-row">
				<div class="col-5 ingredient-name">${ingredient.name}</div>
				<div class="col-3">
					<input type="number" value="${ingredient.quantity}">
				</div>
				<div class="col-3">
					<select name="measures" id="measures">
						${options}
					</select>
				</div>
				<div class="col-1 text-end p-0">
					<img src="./imgs/icons/minus.svg" alt="Remove element ${
						ingredient.name
					}" onclick="removeElementFromList(this)">
				</div>
			</div>`
}
