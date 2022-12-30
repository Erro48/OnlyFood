'use strict'

window.onload = () => {
	deleteCookie('ingredients')
}

/**
 * @enum ModalsType
 * The types of modal used.
 */
const ModalsType = {
	INGREDIENTS: 'ingredients',
	TAGS: 'tags',
}

/* CONSTANTS */
const VH_UNIT = window.innerHeight / 100
const QUANTITY_DEFAULT = 1

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
 * Checks if max height of the modal list is greater than a 62vh. If it is
 * it gives the class list-border-bottom to the ingredients list
 * @param {ModalsType} modalType - The type of the modal
 */
function checkModalListMaxHeight(modalType) {
	const maxHeight = 62 * VH_UNIT
	const modalTagsList = document.querySelector(`#modal-${modalType}-list`)
	const scrollHeight = modalTagsList.scrollHeight

	if (scrollHeight > maxHeight) {
		modalTagsList.classList.add('list-border-bottom')
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
 * Removes the specified element from the modal list
 * @param {*} element - The element to remove
 * @param {ModalsType} modalType - The type of the modal
 */
function removeElementFromModalList(element, modalType) {
	const list = document.querySelector(`#modal-${modalType}-list`)
	element = element.parentElement.parentElement

	list.innerHTML = list.innerHTML.replace(element.outerHTML, '')
}

/**
 * Removes all the elements in the modal list and adds the elements from the result list
 */
async function loadModal(modalType, callback) {
	const modalList = document.querySelector(`#modal-${modalType}-list`)
	const list = document.querySelector(`#${modalType}-list`)
	let resultLiItems = Array.from(list.querySelectorAll('li'))

	clearElement(modalList)

	resultLiItems = await Promise.all(
		resultLiItems.map(async (resultItem) => await callback(resultItem))
	)

	resultLiItems.forEach(
		(resultItem) =>
			(modalList.innerHTML += createModalListItem(modalType, resultItem))
	)
}

/**
 * Adds an ingredient to the list of the chosen ingredients
 * @param {Event} event
 */
async function addItemToList(event, modalType) {
	event.preventDefault()
	const listContainer = document.querySelector(`div#modal-${modalType}-list`)
	const inputSearchField = document.querySelector(`input#search-${modalType}`)
	const itemName = capitalizeString(event.path[0].innerText)

	let listItems = await getItemsOfModalList(modalType)

	// add new element (if not already present)
	if (listItems.filter((item) => item.name == itemName).length == 0) {
		const obj = await getObjectFromItem(itemName, modalType)
		listItems.push(obj)
	}

	// create HTML tags
	listItems = listItems.map((item) => createModalListItem(modalType, item))

	// // add to container
	listContainer.innerHTML = listItems.join('')
	clearElement(document.querySelector(`#search-${modalType}-result`))
	inputSearchField.value = ''
	hideLabel(inputSearchField)
	checkModalListMaxHeight(modalType)
}

/**
 * Returns the html of an item of the modal list, based on the type of modal
 * @param {ModalsType} modalType - The type of the modal
 * @param {*} item - The item to create the html of
 * @returns the html of the given element
 */
function createModalListItem(modalType, item) {
	switch (modalType) {
		case ModalsType.INGREDIENTS:
			return createIngredientsListItem(item)
		case ModalsType.TAGS:
			return createTagsListItem(item)
	}
}

/**
 * Returns the items of the modal list, based on the type of modal
 * @param {ModalsType} modalType - The type of the modal
 * @returns the html of the given element
 */
function getItemsOfModalList(modalType) {
	switch (modalType) {
		case ModalsType.INGREDIENTS:
			return getIngredientsOfModalList()
		case ModalsType.TAGS:
			return getTagsOfModalList()
	}
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

/* INGREDIENTS LIST */
/**
 * Callback used when the modal is loaded, to convert the elements in the result list in objects
 * @param {HTMLLIElement} ingredient - li element representing an ingredient
 * @returns {Object} containing an ingredient and the associated unit of measurement
 * @returns {Object} ingredient - Object representing the ingredient of one row
 * @returns {String} ingredient.name - Name of the ingredient
 * @returns {Number} ingredient.quantity - Quantity of the ingredient
 * @returns {Object} ingredient.measures - Current unit of measurement used by the ingredient
 * @returns {String} ingredient.measures.name - Name of the unit of measurement
 * @returns {String} ingredient.measures.acronym - Acronym of the unit of measurement
 * @returns {Array} measures - List of all the unit of measurement accepted by the ingredient
 */
function ingredientsCallback(ingredient) {
	const ingredientObj = {
		name: ingredient.querySelector('span').innerText,
		quantity: ingredient.dataset.quantity,
		measure: {
			name: ingredient.dataset.measureName,
			acronym: ingredient.dataset.measureAcronym,
		},
	}
	const options = readAllowedMeasuresFromCookie(ingredientObj.name)

	return { ingredient: ingredientObj, measures: options }
}

/**
 * Returns the measures allowed of a given ingredient
 * @param {Object} ingredient - The ingredient to know the measures of
 * @returns an array with the measures allowed for the ingredient
 */
async function getAllowedMeasures(ingredient) {
	let measuresAllowed = await getMeasuresByIngredient(ingredient.name)

	// remove the used measure, if present
	measuresAllowed = measuresAllowed.filter((measure) =>
		ingredient.measure !== undefined
			? measure.name != ingredient.measure.name
			: true
	)

	let options =
		ingredient.measure === undefined
			? measuresAllowed
			: [ingredient.measure, ...measuresAllowed]

	return options.map((measure) =>
		createMeasuresOption(measure, options.indexOf(measure) == 0)
	)
}

/**
 * Creates the option element of the unit of measurement dropdown menu
 * @param {*} measure - The unit of measurement to create the option element of
 * @param {Boolean} selected - Flag which indicates if the measures is the one selected
 */
function createMeasuresOption(measure, selected) {
	return `<option value="${measure.name}" ${
		selected ? 'selected="selected"' : ''
	}>${measure.acronym}</option>`
}

/**
 * Adds the ingredients of the modal list to the ingredients list
 */
async function addIngredients() {
	const ingredientsContainer = document.querySelector('#ingredients-list')
	let ingredients = await getIngredientsOfModalList()

	ingredients = ingredients.map((ingredient) => {
		ingredient = ingredient.ingredient
		return `
		<div class="col-6 col-md-3">
			<li class="row" data-quantity="${
				// if the quantity is not valid use the default value
				ingredient.quantity > 0 ? ingredient.quantity : QUANTITY_DEFAULT
			}" data-measure-name="${ingredient.measure.name}" data-measure-acronym="${
			ingredient.measure.acronym
		}">
				<span class="col-9">${ingredient.name}</span>
				<span class="col-3 p-0">
					<img class="icon" src="./imgs/icons/minus.svg" alt="Remove element ${
						ingredient.name
					}" onclick="removeElementFromResultList(this, ModalsType.INGREDIENTS)" />
				</span>
			</li>
		</div>`
	})

	ingredientsContainer.innerHTML = ingredients.join('')
}

/**
 * Returns an array of objects, each with a field ingredient and a field with the unit of measurement accepted for that ingredient
 * @returns {Array} list of ingredients of the ingredient modal
 * @returns {Object} containing an ingredient and the associated unit of measurement
 * @returns {Object} ingredient - Object representing the ingredient of one row
 * @returns {String} ingredient.name - Name of the ingredient
 * @returns {Number} ingredient.quantity - Quantity of the ingredient
 * @returns {Object} ingredient.measures - Current unit of measurement used by the ingredient
 * @returns {String} ingredient.measures.name - Name of the unit of measurement
 * @returns {String} ingredient.measures.acronym - Acronym of the unit of measurement
 * @returns {Array} measures - List of all the unit of measurement accepted by the ingredient
 */
function getIngredientsOfModalList() {
	const listContainer = document.querySelector('div#modal-ingredients-list')
	return Array.from(listContainer.children).map((item) => {
		const [name, quantity, measure] = item.children
		const select = measure.querySelector('select')

		const ingredient = {
			name: name.innerText,
			quantity: quantity.querySelector('input').value,
			measure: {
				name: select.value,
				acronym: select.options[select.selectedIndex].text,
			},
		}

		return {
			ingredient,
			measures: readAllowedMeasuresFromCookie(ingredient.name),
		}
	})
}

/**
 * Returns the html of an ingredient list item
 * @param {*} ingredient - The ingredient to create the row of
 * @param {*} options  - The options for the measures dropdown
 * @returns the html of the list item
 */
function createIngredientsListItem({ ingredient, measures }) {
	if (typeof measures[0] != 'string') {
		measures = measures.map((measure) =>
			createMeasuresOption(measure, measure.name == ingredient.measure.name)
		)
	}
	const ingredientId = ingredient.name.toLowerCase().replaceAll(' ', '_')

	return `<div class="row m-auto align-items-center" id="${ingredientId}-row">
				<div class="col-5 ingredient-name">${ingredient.name}</div>
				<div class="col-3">
					<label>
						<input type="number" value="${
							ingredient.quantity
						}" min="0" id="quantity-${ingredientId}"
						onkeyup="checkQuantityValidity(this)">
						<span class="invisible">Quantity</span>
						</label>
						
						</div>
						<div class="col-3">
					<label>
						<select name="measures" id="${ingredientId}-measures">
							${measures.join('')}
						</select>
						<span class="invisible">Unit of measurement</span>
					</label>
				</div>
				<div class="col-1 text-end p-0">
					<img class="icon" src="./imgs/icons/minus.svg" alt="Remove element ${
						ingredient.name
					}" onclick="removeElementFromModalList(this, ModalsType.INGREDIENTS)" />
				</div>
			</div>`
}

/* TAGS LIST */
/**
 * Callback used when the modal is loaded, to convert the elements in the result list in objects
 * @param {HTMLLIElement} tag - li element representing an ingredient
 * @returns {Object} containing the name of the tag
 * @returns {String} tag.name - The name of the tag
 */
function tagsCallback(tag) {
	const tagObj = {
		name: tag.querySelector('span').innerText,
	}
	return tagObj
}

/**
 * Returns an array of objects, each one representing a tag
 * @returns {Array} list of tags of the tag modal
 * @returns {Object} containing the name of the tag
 * @returns {String} tag.name - Name of the tag
 */
function getTagsOfModalList() {
	const listContainer = document.querySelector('div#modal-tags-list')
	return Array.from(listContainer.children).map((item) => {
		const [name] = item.children
		return {
			name: name.innerText,
		}
	})
}

/**
 * Returns the html of a tag list item
 * @param {*} tag - The tag to create the row of
 * @returns the html of the list item
 */
function createTagsListItem(tag) {
	const tagId = tag.name.toLowerCase().replaceAll(' ', '_')

	return `<div class="row m-auto align-items-center" id="${tagId}-row">
				<div class="col-11 tag-name">${tag.name}</div>
				<div class="col-1 text-end p-0">
					<img class="icon" src="./imgs/icons/minus.svg" alt="Remove element ${tag.name}" onclick="removeElementFromModalList(this, ModalsType.TAGS)" />
				</div>
			</div>`
}

/**
 * Adds the ingredients of the modal list to the ingredients list
 */
function addTags() {
	const tagsContainer = document.querySelector('#tags-list')
	let tags = getTagsOfModalList()

	tags = tags.map((tag) => {
		return `
		<div class="col-6 col-md-3">
			<li class="row">
				<span class="col-9">${tag.name}</span>
				<span class="col-3 p-0">
					<img class="icon" src="./imgs/icons/minus.svg" alt="Remove element ${tag.name}" onclick="removeElementFromResultList(this, ModalsType.TAGS)" />
				</span>
			</li>
		</div>`
	})

	tagsContainer.innerHTML = tags.join('')
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
