'use strict'

window.onload = () => {
	document
		.querySelector('input#search-ingredient')
		.addEventListener('search', clearDropdownElements)
}

/**
 * Searches ingredients and display the output
 * @param {HTLMInputElement} searchInput - The input element where the search is happening
 */
async function search(searchInput) {
	const searchValue = searchInput.value.trim()
	const dropdownBody = document.querySelector('#search-result')

	if (searchValue.length < 3) {
		clearElement(dropdownBody)
		dropdownBody.parentElement.classList.add('d-none')
		return
	}

	const ingredients = await searchIngredient(searchValue)
	dropdownBody.parentElement.classList.remove('d-none')
	displayIngredients(ingredients, dropdownBody)
}

/**
 * Performs an HTTP request to get the ingredients matching the input ingredient
 * @param {string} ingredient - The ingredient to look for
 * @returns {String[]} An array containing the ingredients matched
 */
async function searchIngredient(ingredient) {
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
function displayIngredients(ingredients, container) {
	clearElement(container)
	ingredients.forEach((ingredient) =>
		container.append(createSearchResultOption(ingredient))
	)
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
function createSearchResultOption(ingredient) {
	const container = document.createElement('li')
	container.innerText = ingredient.name
	container.classList.add('px-3')
	container.classList.add('py-2')
	container.setAttribute('onclick', 'addIngredientToList(event)')
	return container
}
