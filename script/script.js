'use strict'

/*  Table Of Contents:
    - Elements
    - Typography
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
