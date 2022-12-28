'use strict'

window.onload = () => {
	document
		.querySelector('input#search-tag')
		.addEventListener('search', clearDropdownElements)
}

/**
 * Searches tags and display the output
 * @param {HTLMInputElement} searchInput - The input element where the search is happening
 */
async function searchTag(searchInput) {
	const searchValue = searchInput.value.trim()
	const dropdownBody = document.querySelector('#search-tag-result')

	if (searchValue.length < 3) {
		clearElement(dropdownBody)
		dropdownBody.parentElement.classList.add('d-none')
		return
	}

	const tags = await searchForTag(searchValue)
	dropdownBody.parentElement.classList.remove('d-none')
	displayTags(tags, dropdownBody)
}

/**
 * Performs an HTTP request to get the tag matching the input tag
 * @param {string} tag - The tag to look for
 * @returns {String[]} An array containing the tags matched
 */
async function searchForTag(tag) {
	const tags = []
	await axios
		.get(`./request/request.php?tag=${tag}`)
		.then((result) => {
			for (let tag of result.data) {
				tags.push(tag)
			}
		})
		.catch((err) => console.error(err))
	return tags
}

/**
 * Given a list of tags, it displays them in the container
 * @param {String[]} tags - A list of tags
 * @param {Element} container - The container where to put the formatted tags
 */
function displayTags(tags, container) {
	clearElement(container)
	tags.forEach((tag) => container.append(createSearchTagResultOption(tag)))
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
function createSearchTagResultOption(ingredient) {
	const container = document.createElement('li')
	container.innerText = ingredient.name
	container.classList.add('px-3')
	container.classList.add('py-2')
	container.setAttribute('onclick', 'addTagToList(event)')
	return container
}
