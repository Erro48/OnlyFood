'use strict'

window.onload = () => {
	deleteCookie('ingredients')
}

/* COMMON */
/**
 * Gets all the allowed unit of measure of a given ingredient
 * @param {*} ingredient - The ingredient to know the units of measure of
 * @returns an array wit the allowed unit of measures
 */
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

/**
 * Controls if the inserted quantity for an ingredient is valid
 * @param {*} inputElement - The element to check the quantity
 */
function checkQuantityValidity(inputElement) {
	if (inputElement.value <= 0 && inputElement.value != '') {
		setErrorClass([inputElement.id])
	} else {
		resetErrorClass([inputElement.id])
	}
}

/* COOKIES */
/**
 * Saves the given ingredient in the cookies, with the relatives unit of measurements. The ingredient is parsed to a string
 * @param {Object} ingredient - Ingredient with a name and a list of allowed unit of measurements
 * @param {String} ingredient.ingredientName - The name of the ingredient
 * @param {Array} ingredient.measures - An array with the accepted unit of measurement for the ingredient
 */
function saveAllowedMeasuresInCookie({ ingredientName, measures }) {
	measures = measures.map((measure) => {
		let measureOption = document.createElement('option')
		measureOption.innerHTML = measure
		measureOption = measureOption.children[0]

		return { name: measureOption.value, acronym: measureOption.innerText }
	})
	const obj = {
		ingredient: ingredientName,
		measures,
	}

	const ingredientsInCookie =
		getCookie('ingredients') != '' ? JSON.parse(getCookie('ingredients')) : []

	// update cookie if it is already present
	ingredientsInCookie
		.filter((cookie) => cookie.ingredient == obj.ingredient)
		.filter(
			(cookie) =>
				JSON.stringify(cookie.measures) != JSON.stringify(obj.measures)
		)
		.map((cookie) => (cookie.measures = obj.measures))

	// add cookie if not present
	if (
		ingredientsInCookie.filter((cookie) => cookie.ingredient == obj.ingredient)
			.length == 0
	) {
		ingredientsInCookie.push(obj)
	}

	setCookie('ingredients', JSON.stringify(ingredientsInCookie))
}

/**
 * Reads the ingredient, and the relative unit of measurements, from the cookies
 * @param {String} ingredientName - The name of the ingredient to read
 * @returns {Object} ingredient with a name and a list of allowed unit of measurements
 * @returns {String} ingredient.ingredientName The name of the ingredient
 * @returns {Array} ingredient.measures An array with the accepted unit of measurement for the ingredient
 */
function readAllowedMeasuresFromCookie(ingredientName) {
	const cookies = getCookie('ingredients')
	if (cookies == '') return []

	const ingredients = JSON.parse(cookies)
	return ingredients.filter(
		(ingredient) => ingredient.ingredient == ingredientName
	)[0].measures
}

/* IMAGE */
/**
 * Displays a loaded image into a preview <img>
 * @param {HTMLInputElement} input - The input element to load the image from
 * @param {HTMLInputElement} [preview=input.parentNode.querySelector(`#${input.id} ~ span`)] - The HTML element to loead the image into
 */
function profilePicPreview(
	input,
	preview = input.parentNode.parentNode.querySelector(`div`)
) {
	const fReader = new FileReader()
	const fileNameSpan = input.parentNode.querySelector('span.image-name')

	fReader.readAsDataURL(input.files[0])
	fReader.onloadend = function (event) {
		preview.querySelector('img').src = event.target.result
		preview.classList.remove('d-none')
		fileNameSpan.innerText = input.files[0].name
	}
}
