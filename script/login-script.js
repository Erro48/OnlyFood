'use strict'
const ALERT_POPUP_TIME = 5 * 1000

function profilePicPreview() {
	const inputImage = document.querySelector('#user-pic')
	const preview = document.querySelector('#user-pic ~ p')
	const fReader = new FileReader()

	fReader.readAsDataURL(inputImage.files[0])
	fReader.onloadend = function (event) {
		preview.querySelector('img').src = event.target.result
	}
}

function searchIngredient(e) {
	const searchValue = document.querySelector('#search-ingredient').value.trim()
	const dropdownBody = document.querySelector('#search-result')

	if (searchValue.length < 3) {
		clearDropdown(dropdownBody)
		dropdownBody.parentElement.classList.add('d-none')
		return
	}

	axios
		.get(`./request/request.php?ingredient=${searchValue}`)
		.then((data) => {
			dropdownBody.parentElement.classList.remove('d-none')
			clearDropdown(dropdownBody)

			for (ingredient of data.data) {
				dropdownBody.append(createSearchResultOption(ingredient))
			}
		})
		.catch((err) => console.error(err))
}

function clearDropdown(dropdown = document.querySelector('.search-result')) {
	while (dropdown.firstChild) {
		dropdown.removeChild(dropdown.lastChild)
	}
}

function addIngredientToList(event) {
	event.preventDefault()
	const listContainer = document.querySelector('div.ingredients-list')
	let ingredientName

	if (event.target.type == 'submit') {
		const element = document.querySelector('input#search-ingredient')
		ingredientName = element.value
	} else {
		const element = event.path[0]
		ingredientName = element.innerText
	}

	ingredientName = ingredientName
		.split(' ')
		.map((word) => word[0].toUpperCase() + word.substr(1))
		.join(' ')

	let listItems = Array.from(listContainer.children).map((item) => {
		return {
			name: item.children[1].innerText,
			checked: item.children[0].checked,
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
			<input type="checkbox" name="ingredient-chk" id="ingr-${ingredientId}" 
			${ingredient.checked ? 'checked' : ''}>
			<span class="ingredient-pill">${ingredientName}</span>
		</label>`
	})

	// add to container
	listContainer.innerHTML = listItems.join('')
	clearDropdown()
	document.querySelector('#search-ingredient').value = ''
}

function hideLabel(element) {
	const sibling = element.nextElementSibling

	element.value.trim() != ''
		? sibling.classList.add('d-none')
		: sibling.classList.remove('d-none')
}

function changePage(event, pageNumber) {
	const errors = verifyInputs(getCurrentPageNumber(event.target))
	resetErrors()

	if (
		pageNumber < getCurrentPageNumber(event.target) || // pressed 'Back' button
		errors.length == 0
	) {
		loadPage(pageNumber)
	} else {
		setErrorClass(errors.map((error) => error.id))
		if (errors.length > 0) {
			setErrorMessage(errors.map((error) => error.msg))
			document.querySelector('.alert').classList.add('fade-out')
		}
	}
}

function loadPage(pageNumber) {
	// remove display none from next / previous page
	const elements = document.querySelectorAll(`.page-${pageNumber}`)
	elements.forEach((element) => element.classList.remove('d-none'))

	// add display none to other pages
	const otherNumbers = [0, 1, 2].filter((el) => el != pageNumber)
	const classes = otherNumbers.map((el) => `.page-${el}`).join(',')
	const otherElements = document.querySelectorAll(classes)
	otherElements.forEach((element) => element.classList.add('d-none'))
}

function getCurrentPageNumber(element) {
	return [...element.parentNode.classList]
		.filter((className) => className.includes('page-'))[0]
		.substr(5)
}

function verifyInputs(pageNumber) {
	let errors = []

	if (pageNumber == 0) errors = verifyFirstPageInputs()
	else if (pageNumber == 1) errors = verifySecondPageInputs()

	return errors
}

function resetErrors() {
	const elements = document.querySelectorAll('.input-error')
	const errorLog = document.querySelector('.alert')

	elements.forEach((element) => element.classList.remove('input-error'))
	errorLog.innerText = ''
	errorLog.classList.add('d-none')
	errorLog.classList.remove('fade-out')
}

function setErrorClass(inputErrorsId) {
	inputErrorsId.forEach((id) => {
		document.querySelector(`#${id}`).classList.add('input-error')
	})
}

function setErrorMessage(messages) {
	const errorLog = document.querySelector('.alert')
	if (messages !== undefined) {
		errorLog.innerText = messages.map((message) => message).join('\n')
		errorLog.classList.remove('d-none')
	}
}

function verifyFirstPageInputs() {
	const inputs = [...document.querySelectorAll('.page-0 input')]
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

function verifySecondPageInputs() {
	const inputs = [...document.querySelectorAll('.page-1 input')]
	const results = []

	// Check if username is correct
	const username = inputs.filter((input) => input.id == 'user-username')[0]
		.value
	results.push(...verifyUsername(username, 'user-username'))

	// Check if email is correct
	const email = inputs.filter((input) => input.id == 'user-email')[0].value
	results.push(...verifyEmail(email, 'user-email'))

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

// function verifyLoginInputs() {
// 	return [{ id: 'user-input', msg: 'ciao a tutti' }]
// }

function createSearchResultOption(ingredient) {
	const container = document.createElement('li')
	container.innerText = ingredient.name
	container.classList.add('px-3')
	container.classList.add('py-2')
	container.setAttribute('onclick', 'addIngredientToList(event)')
	return container
}
