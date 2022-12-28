'use strict'

/**
 * Sets in cookies the given value
 * @param {String} name - The name of the cookie
 * @param {String} value - The value of the cookie
 * @param {Number} [expirationDays=1] - The duration (in days) of the cookie
 */
function setCookie(name, value, expirationDays = 1) {
	const d = new Date()
	d.setTime(d.getTime() + expirationDays * 24 * 60 * 60 * 1000)
	let expires = 'expires=' + d.toUTCString()
	document.cookie = `${name}=${value};${expires};path=/`
}

/**
 * Returns the values of the cookie specified
 * @param {String} name - The name of the cookie
 * @returns {String} a string representing the value of the cookie
 */
function getCookie(name) {
	name = name + '='
	let cookies = document.cookie.split(';')
	for (let i = 0; i < cookies.length; i++) {
		let c = cookies[i]
		while (c.charAt(0) == ' ') {
			c = c.substring(1)
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length)
		}
	}
	return ''
}
