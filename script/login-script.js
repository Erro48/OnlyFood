'use strict'

/**
 * @enum RegistrationFieldset
 * Fieldsets in the registration page.
 */
const RegistrationFieldset = {
	PERSONAL_INFORMATIONS: 0,
	ACCOUNT_INFORMATIONS: 1,
	INTOLERANCES_INFORMATIONS: 2,
}

/**
 * Displays a loaded image into a preview <img>
 * @param {HTMLInputElement} input - The input element to load the image from
 * @param {HTMLInputElement} [preview=input.parentNode.querySelector(`#${input.id} ~ p`)] - The HTML element to loead the image into
 */
function profilePicPreview(
	input,
	preview = input.parentNode.querySelector(`#${input.id} ~ p`)
) {
	const fReader = new FileReader()
	// const file = input.files
	// const formData = new FormData()

	fReader.readAsDataURL(input.files[0])
	fReader.onloadend = function (event) {
		preview.querySelector('img').src = event.target.result
	}
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
 * Removes every children of the given element
 * @param {Element} [element=document.querySelector('.search-result')] - Element to be cleared
 */
function clearElement(element = document.querySelector('.search-result')) {
	while (element.firstChild) {
		element.removeChild(element.lastChild)
	}
}

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

/**
 * Adds an ingredient to the list of the chosen ingredients
 * @param {Event} event
 */
function addIngredientToList(event) {
	// if used on button
	event.preventDefault()
	const listContainer = document.querySelector('div.ingredients-list')
	const inputSearchField = document.querySelector('input#search-ingredient')
	let ingredientName

	// get element's value
	if (event.target.type == 'submit') {
		ingredientName = inputSearchField.value
	} else {
		const element = event.path[0]
		ingredientName = element.innerText
	}

	// capitalize ingredient name
	ingredientName = capitalizeString(ingredientName)

	let listItems = Array.from(listContainer.children).map((item) => {
		const [checkbox, name, other] = item.children
		return {
			name: name.innerText,
			checked: checkbox.checked,
		}
	})

	// if it's first element, remove the already present (in not checked)
	if (listContainer.dataset.server == 'true') {
		listItems = listItems.filter((ingredient) => ingredient.checked)
		listContainer.dataset.server = false
	}

	// add new element (if not already present)
	if (listItems.filter((item) => item.name == ingredientName).length == 0) {
		listItems.push({
			name: ingredientName,
			checked: true,
		})
	}

	// create HTML tags
	listItems = listItems.map((ingredient) => {
		const ingredientName = ingredient.name
		const ingredientId = ingredientName.toLowerCase().replaceAll(' ', '_')

		return `<label for="ingr-${ingredientId}" class="col-6 col-md-4">
			<input type="checkbox" name="intolerances[]" id="ingr-${ingredientId}" 
			${ingredient.checked ? 'checked' : ''} value="${ingredientId}">
			<span class="ingredient-pill">${ingredientName}</span>
		</label>`
	})

	// add to container
	listContainer.innerHTML = listItems.join('')
	clearElement()
	inputSearchField.value = ''
	hideLabel(inputSearchField)
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
 * Switch fieldset and sets errors, if present
 * @param {Event} event
 * @param {RegistrationFieldset} fieldset
 */
async function changeFieldset(event, fieldset) {
	const errors = await verifyInputs(getCurrentFieldset(event.target))
	resetErrors()

	if (
		fieldset < getCurrentFieldset(event.target) || // pressed 'Back' button
		errors.length == 0
	) {
		loadFieldset(fieldset)
	} else {
		setErrorClass(errors.map((error) => error.id))
		if (errors.length > 0) {
			setErrorMessage(errors.map((error) => error.msg))
			document.querySelector('.alert').classList.add('fade-out')
		}
	}
}

/**
 * Makes visible the selected fieldset and hides the others
 * @param {RegistrationFieldset} fieldset - The fieldset to display
 */
function loadFieldset(fieldset) {
	// remove display none from next / previous fieldset
	const elements = document.querySelectorAll(`.fieldset-${fieldset}`)
	elements.forEach((element) => element.classList.remove('d-none'))

	// add display none to other pages
	const otherNumbers = Object.values(RegistrationFieldset).filter(
		(el) => el != fieldset
	)
	const classes = otherNumbers.map((el) => `.fieldset-${el}`).join(',')
	const otherElements = document.querySelectorAll(classes)
	otherElements.forEach((element) => element.classList.add('d-none'))
}

/**
 * Returns the fieldset of the current page
 * @param {Element} element
 * @returns {RegistrationFieldset} the current fieldset number
 */
function getCurrentFieldset(element) {
	const classIdentifier = 'fieldset-'
	return [...element.parentNode.classList]
		.filter((className) => className.includes(classIdentifier))[0]
		.substr(classIdentifier.length)
}

/**
 * Reset alert message and input style
 */
function resetErrors() {
	const elements = document.querySelectorAll('.input-error')
	const errorLog = document.querySelector('.alert')

	elements.forEach((element) => element.classList.remove('input-error'))
	errorLog.innerText = ''
	errorLog.classList.add('d-none')
	errorLog.classList.remove('fade-out')
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
 * Set the error messages in the alert
 * @param {string[]} messages - The messages to be displayed in the alert
 */
function setErrorMessage(messages) {
	const errorLog = document.querySelector('.alert')
	if (messages !== undefined) {
		errorLog.innerText = messages.map((message) => message).join('\n')
		errorLog.classList.remove('d-none')
	}
}

/**
 * @typedef {Object} InputError
 * @property {number} id - the id to the corresponding input element
 * @property {string} msg - the error message
 */

/**
 * Given the fieldset use the correct function to verify inputs
 * @param {RegistrationFieldset} fieldset
 * @returns {InputError[]} array of errors
 */
async function verifyInputs(fieldset) {
	let errors = []

	if (fieldset == RegistrationFieldset.PERSONAL_INFORMATIONS)
		errors = verifyPersonalInformations()
	else if (fieldset == RegistrationFieldset.ACCOUNT_INFORMATIONS)
		errors = await verifyAccountInformations()

	return errors
}

/**
 * Verifies that inputs of the personal informations fieldset are correct
 * @returns {InputError[]} array of errors
 */
function verifyPersonalInformations() {
	const inputs = [...document.querySelectorAll('.fieldset-0 input')]
	const results = []

	// Check profile pic

	// Check if name is correct
	const name = inputs.filter((input) => input.id == 'user-name')[0].value
	results.push(...verifyName(name, 'user-name'))

	// Check if surname is correct
	const surname = inputs.filter((input) => input.id == 'user-surname')[0].value
	results.push(...verifySurname(surname, 'user-surname'))

	return results
}

/**
 * Verifies that inputs of the account informations fieldset are correct
 * @returns {InputError[]} array of errors
 */
async function verifyAccountInformations() {
	const inputs = [...document.querySelectorAll('.fieldset-1 input')]
	const results = []

	// Check if username is correct
	const username = inputs.filter((input) => input.id == 'user-username')[0]
		.value
	results.push(...(await verifyUsername(username, 'user-username')))

	// Check if email is correct
	const email = inputs.filter((input) => input.id == 'user-email')[0].value
	results.push(...(await verifyEmail(email, 'user-email')))

	const password = inputs.filter((input) => input.id == 'user-password')[0]
		.value
	const cpassword = inputs.filter((input) => input.id == 'user-cpassword')[0]
		.value
	results.push(
		...verifyPassword(password, cpassword, {
			password: 'user-password',
			cpassword: 'user-cpassword',
		})
	)

	return results
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
