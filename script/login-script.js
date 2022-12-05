function profilePicPreview() {
	const inputImage = document.querySelector('#user-pic')
	const preview = document.querySelector('#user-pic ~ p')
	const fReader = new FileReader()

	fReader.readAsDataURL(inputImage.files[0])
	fReader.onloadend = function (event) {
		preview.querySelector('img').src = event.target.result
	}
}
