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

/**
 * Set the error class to the input specified by the inputErrorId
 * @param {number} inputErrorsId - The id of the input with a wrong value
 */
function setErrorClass(inputErrorsId) {
	inputErrorsId.forEach((id) => {
		document.querySelector(`#${id}`).classList.add('input-error')
	})
}

/**
 * Reset the error class to the input specified by the inputErrorId
 * @param {number} inputErrorsId - The id of the input with a wrong value
 */
function resetErrorClass(inputErrorsId) {
	inputErrorsId.forEach((id) => {
		document.querySelector(`#${id}`).classList.remove('input-error')
	})
}

/* TYPOGRAPHY */

/**
 * Return the string with each word capitalized
 * @param {String} string - String to be capitalized
 * @returns {String} the capitalized string
 */
function capitalizeString(text) {
	return text
		.toLowerCase()
		.split(' ')
		.map((word) => word[0].toUpperCase() + word.substr(1))
		.join(' ')
}

const NOTIFICATION_POLLING_RATE = 5000

/**
 * Polling for unread notifications count
 */
setInterval(() => {
	const NOTIFICATION_COUNTER = document.querySelector('#notification-counter')

	axios
		.get(`./request/notification.php`)
		.then((count) => {
			let numNotifications = count.data
			if (numNotifications > 0) {
				NOTIFICATION_COUNTER.innerHTML = numNotifications
				NOTIFICATION_COUNTER.classList.remove('invisible')
			} else {
				NOTIFICATION_COUNTER.innerHTML = ''
				NOTIFICATION_COUNTER.classList.add('invisible')
			}
		})
		.catch((err) => console.error(err))
}, NOTIFICATION_POLLING_RATE)
