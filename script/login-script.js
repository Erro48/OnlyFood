'use strict'

let alertTimerHandle = 0

window.onload = () => {
	const inputSearchField = document.querySelector('input#search-ingredient')
	if (inputSearchField != null) {
		inputSearchField.addEventListener('search', clearDropdownElements)
	}
}

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
 * @param {HTMLInputElement} [preview=input.parentNode.querySelector(`#${input.id} ~ span`)] - The HTML element to loead the image into
 */
function profilePicPreview(
	input,
	preview = input.parentNode.querySelector(`#${input.id} ~ span`)
) {
	const fReader = new FileReader()

	fReader.readAsDataURL(input.files[0])
	fReader.onloadend = function (event) {
		preview.querySelector('img').src = event.target.result
	}
}

function addItemToList(event, modalType) {
	addIngredientToList(event)
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
		const element = event.target
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

		return `<label for="ingr-${ingredientId}" class="col-6 col-lg-4 d-flex align-items-center">
			<input type="checkbox" name="intolerances[]" class="col-1" id="ingr-${ingredientId}" 
			${ingredient.checked ? 'checked' : ''} value="${ingredientId}">
			<span class="dotted-word col-11">${ingredientName}</span>
		</label>`
	})

	// add to container
	listContainer.innerHTML = listItems.join('')
	clearElement(document.querySelector('.search-result'))
	inputSearchField.value = ''
	hideLabel(inputSearchField)
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
	errorLog.children[0].innerText = ''
	errorLog.classList.add('d-none')
	errorLog.classList.remove('fade-out')
}

/**
 * Set the error messages in the alert
 * @param {string[]} messages - The messages to be displayed in the alert
 */
function setErrorMessage(messages) {
	const errorLog = document.querySelector('.alert')
	if (messages !== undefined) {
		errorLog.children[0].innerText = messages
			.map((message) => message)
			.join('\n')
		errorLog.classList.remove('d-none')
		errorLog.classList.add('fade-out')
		alertTimerHandle = setTimeout(() => {
			errorLog.classList.add('d-none')
		}, 5100)
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
