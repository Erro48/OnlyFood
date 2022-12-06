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

function createSearchResultOption(ingredient) {
	const container = document.createElement('li')
	container.innerText = ingredient.name
	container.classList.add('px-3')
	container.classList.add('py-2')
	return container
}
