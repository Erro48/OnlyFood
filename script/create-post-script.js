'use strict'

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
			const ingredientName = ingredient.name
			const ingredientId = ingredientName.toLowerCase().replaceAll(' ', '_')
			let measuresAllowed = await getMeasuresByIngredient(ingredientName)

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
			return `
                <div class="row m-auto align-items-center">
                    <div class="col-6 ingredient-name">${ingredientName}</div>
                    <div class="col-3">
                        <input type="number" value="${ingredient.quantity}">
                    </div>
                    <div class="col-2">
                        <select name="measures" id="measures">
                            ${options}
                        </select>
                    </div>
                    <div class="col-1">X</div>
                </div>`
		})
	)

	// add to container
	listContainer.innerHTML = listItems.join('')
	clearElement(document.querySelector('.search-result'))
	inputSearchField.value = ''
	hideLabel(inputSearchField)
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
