'use strict'

/*  Table Of Contents:
	- Onload and onresize
    - Elements
    - Typography
	- Arrays
*/

/* ONLOAD AND ONRESIZE */

/**
 * Adds a function to do in window.onload
 * @param {*} func - Function to do on windows.onload
 */
function addLoadEventOnload(func) {
	var oldonload = window.onload
	if (typeof window.onload != 'function') {
		window.onload = func
	} else {
		window.onload = function () {
			if (oldonload) {
				oldonload()
			}
			func()
		}
	}
}

/**
 * Adds a function to do in window.onresize
 * @param {*} func - Function to do on windows.onresize
 */
function addLoadEventOnresize(func) {
	var oldonresize = window.onresize
	if (typeof window.onresize != 'function') {
		window.onresize = func
	} else {
		window.onresize = function () {
			if (oldonresize) {
				oldonresize()
			}
			func()
		}
	}
}

/**
 * Adds a function to do in window.onscroll
 * @param {*} func - Function to do on windows.onscroll
 */
function addLoadEventOnscroll(func) {
	var oldonscroll = window.onscroll
	if (typeof window.onscroll != 'function') {
		window.onscroll = func
	} else {
		window.onscroll = function () {
			if (oldonscroll) {
				oldonscroll()
			}
			func()
		}
	}
}

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

/**
 * Hides and remove from DOM the given alert
 * @param {*} alert
 */
function forceCloseAlert(alert, handler = null) {
	alert.classList.add('d-none')
	if (handler != null) {
		clearTimeout(handler)
	}
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
		.catch((err) => err)
}, NOTIFICATION_POLLING_RATE)
