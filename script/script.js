'use strict'

/*  Table Of Contents:
    - Elements
    - Typography
	- Arrays
*/

/* ELEMENTS */

/**
 * Removes every children of the given element
 * @param {Element} element - Element to be cleared
 */
function clearElement(element) {
	while (element.firstChild) {
		element.removeChild(element.lastChild)
	}
}

/**
 * Hides the label of the element's sibling
 * @param {HTMLInputElement} element - Input element to hide the label
 */
function hideLabel(element) {
	const sibling = element.nextElementSibling

	element.value.trim() != ''
		? sibling.classList.add('d-none')
		: sibling.classList.remove('d-none')
}

/* TYPOGRAPHY */

/**
 * Return the string with each word capitalized
 * @param {String} string - String to be capitalized
 * @returns {String} the capitalized string
 */
function capitalizeString(text) {
	return text
		.split(' ')
		.map((word) => word[0].toUpperCase() + word.substr(1))
		.join(' ')
}

/* ARRAYS */
/**
 * Move an array element in the array
 * @param {*} arr - The array in which to move the elements
 * @param {*} fromIndex - The starting index of the element to move
 * @param {*} toIndex  - The index of the position where to place the element
 */
function arraymove(arr, fromIndex, toIndex) {
	var element = arr[fromIndex]
	arr.splice(fromIndex, 1)
	arr.splice(toIndex, 0, element)
}
