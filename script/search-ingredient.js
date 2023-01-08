'use strict'

window.onload = () => {

	try {
		document
		.querySelector('input#search-ingredients')
		.addEventListener('search', clearDropdownElements)
	} catch(exception) {

	}

	try {
		document
		.querySelector('input#search-simple-ingredients')
		.addEventListener('search', clearDropdownElements)
	} catch(exception) {

	}
}

/**
 * Searches ingredients and display the output
 * @param {HTLMInputElement} searchInput - The input element where the search is happening
 */
async function search(searchInput, modal = false) {
	const searchValue = searchInput.value.trim()
	const dropdownBody = document.querySelector('#search-ingredients-result')

	if (searchValue.length < 3) {
		clearElement(dropdownBody)
		dropdownBody.parentElement.classList.add('d-none')
		return
	}

	const ingredients = await searchForIngredient(searchValue)
	dropdownBody.parentElement.classList.remove('d-none')
	displayIngredients(ingredients, dropdownBody, modal)
}

/**
 * Performs an HTTP request to get the ingredients matching the input ingredient
 * @param {string} ingredient - The ingredient to look for
 * @returns {String[]} An array containing the ingredients matched
 */
async function searchForIngredient(ingredient) {
	const ingredients = []
	await axios
		.get(`./request/request.php?ingredient=${ingredient}`)
		.then((result) => {
			for (let ingredient of result.data) {
				ingredients.push(ingredient)
			}
		})
		.catch((err) => console.error(err))
	return ingredients
}

/**
 * Given a list of ingredients, it displays them in the container
 * @param {String[]} ingredients - A list of ingredients
 * @param {Element} container - The container where to put the formatted ingredients
 */
function displayIngredients(ingredients, container, modal) {
	clearElement(container)
	ingredients.forEach((ingredient) =>
		container.append(createSearchIngredientResultOption(ingredient, modal))
	)
}

/**
 * Given a list of ingredients, it displays them in the container
 * @param {String[]} ingredients - A list of ingredients
 * @param {Element} container - The container where to put the formatted tags
 */
function displaySimpleIngredients(ingredients, container) {
	clearElement(container)
	ingredients.forEach((ingredient) => container.append(createSearchSimpleIngredientResultOption(ingredient)))
}

/**
 * Remove all the option of a dropdown menu
 */
async function clearDropdownElements() {
	const dropdown = document.querySelector('ul.search-result')
	clearElement(dropdown)
}

/**
 * Create a list item representing an option of the dropdown menu
 * @param {string} ingredient - The ingredient to be displayed in the option
 * @returns {HTMLLIElement} the HTML li element
 */
function createSearchIngredientResultOption(ingredient, modal) {
	const container = document.createElement('li')
	container.innerText = ingredient.name
	container.classList.add('px-3')
	container.classList.add('py-2')
	if (modal) {
		container.setAttribute(
			'onclick',
			'addItemToList(event, ModalsType.INGREDIENTS)'
		)
	} else {
		container.setAttribute('onclick', 'addIngredientToList(event)')
	}
	return container
}

/**
 * Create a list item representing an option of the dropdown menu
 * @param {string} ingredient - The ingredient to be displayed in the option
 * @returns {HTMLLIElement} the HTML li element
 */
function createSearchSimpleIngredientResultOption(ingredient) {
	const container = document.createElement('li')
	container.innerText = ingredient.name
	container.classList.add('px-3')
	container.classList.add('py-2')
	container.setAttribute('onclick', 'addItemToList(event, ModalsType.SIMPLE_INGREDIENTS)')
	return container
}

/**
 * Adds an ingredient to the list of the chosen ingredients
 * @param {Event} event
 */
async function addItemToList(event, modalType) {
	event.preventDefault()

	const item = (
		event.path[0] instanceof HTMLLIElement
			? event.path[0].innerText
			: document.querySelector('input#search-tags').value
	).trim()

	if (item == '') return

	const listContainer = document.querySelector(`div#modal-${modalType}-list`)
	const inputSearchField = document.querySelector(`input#search-${modalType}`)
	const itemName = capitalizeString(item)

	let listItems = await getItemsOfModalList(modalType)

	// add new element (if not already present)
	if (
		listItems.filter((item) => {
			return modalType == ModalsType.INGREDIENTS
				? item.ingredient.name == itemName
				: item.name == itemName
		}).length == 0
	) {
		const obj = await getObjectFromItem(itemName, modalType)
		listItems.push(obj)
	}

	// create HTML tags
	listItems = listItems.map((item) => createModalListItem(modalType, item))

	// // add to container
	listContainer.innerHTML = listItems.join('')
	clearElement(document.querySelector(`#search-${modalType}-result`))
	inputSearchField.value = ''
	// hideLabel(inputSearchField)
	checkModalListMaxHeight(modalType)
}


