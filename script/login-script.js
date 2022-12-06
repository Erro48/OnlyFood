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
	const searchValue = document.querySelector('#search-ingredient').value
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

function addIngredientToList(element) {
	const listContainer = document.querySelector('div.ingredients-list')
	const elementId = element.innerText.replaceAll(' ', '_').toLowerCase()
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
	if (listItems.filter((item) => item.name == element.innerText).length == 0) {
		listItems.push({
			name: element.innerText,
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

function createSearchResultOption(ingredient) {
	const container = document.createElement('li')
	container.innerText = ingredient.name
	container.classList.add('px-3')
	container.classList.add('py-2')
	container.setAttribute('onclick', 'addIngredientToList(this)')
	return container
}
