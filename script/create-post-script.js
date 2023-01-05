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

/**
 * Removes the specified element from the result list
 * @param {*} element - The element to remove
 * @param ModalsType modalType - The type of the modal
 */
function removeElementFromResultList(element, modalType) {
	const list = document.querySelector(`#${modalType}-list`)
	element = element.parentElement.parentElement.parentElement

	list.innerHTML = list.innerHTML.replace(element.outerHTML, '')
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

/**
 * Converts an item of a modal list to the corresponding object, based on the type of the modal
 * @param {String} itemName - The name of the item
 * @param {ModalsType} modalType - The type of the modal
 * @returns {Object} an object where the structure depends on the type of modal
 */
async function getObjectFromItem(itemName, modalType) {
	let obj = { name: itemName }

	if (modalType == ModalsType.INGREDIENTS) {
		const ingredient = { ...obj, quantity: QUANTITY_DEFAULT }
		const allowedMeasures = await getAllowedMeasures(ingredient)
		saveAllowedMeasuresInCookie({
			ingredientName: itemName,
			measures: allowedMeasures,
		})
		obj = {
			ingredient,
			measures: allowedMeasures,
		}
	}

	return obj
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
