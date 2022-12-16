'use strict'

const REQUIRED_FIELD_MSG = 'is not optional.'
const USERNAME_MSG = "can only contain letters, numbers and '_' character."
const EMAIL_MSG = 'has an invalid format.'
const ALREADY_USED_MESSAGE = 'already in use.'

const NAME_REGEX = /^[a-zA-Z]*$/
const SURNAME_REGEX = /^[a-zA-Z]*$/
const USERNAME_REGEX = /^[^\W_]+$/
const EMAIL_REGEX = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/

const USERNAME_MAX_LENGTH = 20
const USERNAME_MIN_LENGTH = 3

const EMAIL_MAX_LENGTH = 50
const EMAIL_MIN_LENGTH = 3

const PASSWORD_MIN_LENGTH = 7

function isEmpty(value) {
	return value.trim() == 0
}

function lengthBetween(value, min = 0, max = Infinity) {
	return value >= min && value < max
}

function checkPassword(password) {
	if (!password.match(/[a-z]/)) return 'lower case letter'
	if (!password.match(/[A-Z]/)) return 'upper case letter'
	if (!password.match(/[0-9]/)) return 'number'
	if (!password.match(/[_!$@#^&]/)) return 'special char (_ ! $ @ # ^ &)'
	return true
}

function verifyName(name, id) {
	const results = []

	if (isEmpty(name)) {
		results.push({
			id,
			msg: `First name ${REQUIRED_FIELD_MSG}`,
		})
	} else if (!name.match(NAME_REGEX)) {
		results.push({
			id,
			msg: 'First name can only contain letters.',
		})
	}

	return results
}

function verifySurname(surname, id) {
	const results = []
	if (isEmpty(surname)) {
		results.push({
			id,
			msg: `Last name ${REQUIRED_FIELD_MSG}`,
		})
	} else if (!surname.match(SURNAME_REGEX)) {
		results.push({
			id,
			msg: 'Last name can only contain letters.',
		})
	}
	return results
}

async function verifyUsername(username, id) {
	const results = []
	const userInDb = await getUserInfo(username)

	if (isEmpty(username)) {
		results.push({
			id,
			msg: `Username ${REQUIRED_FIELD_MSG}`,
		})
	} else if (
		!lengthBetween(username.length, USERNAME_MIN_LENGTH, USERNAME_MAX_LENGTH)
	) {
		results.push({
			id,
			msg: `Username length must be between ${USERNAME_MIN_LENGTH} and ${USERNAME_MAX_LENGTH}`,
		})
	} else if (!username.match(USERNAME_REGEX)) {
		results.push({
			id,
			msg: `Username ${USERNAME_MSG}`,
		})
	} else if (userInDb.length > 0) {
		results.push({
			id,
			msg: `Username ${ALREADY_USED_MESSAGE}`,
		})
	}
	return results
}

async function verifyEmail(email, id) {
	const results = []
	const usersInDb = await getUserByEmail(email)

	if (isEmpty(email)) {
		results.push({
			id,
			msg: `Email ${REQUIRED_FIELD_MSG}`,
		})
	} else if (!lengthBetween(email.length, EMAIL_MIN_LENGTH, EMAIL_MAX_LENGTH)) {
		results.push({
			id,
			msg: `Email length must be between ${EMAIL_MIN_LENGTH} and ${EMAIL_MAX_LENGTH}`,
		})
	} else if (!email.match(EMAIL_REGEX)) {
		results.push({
			id,
			msg: `Email ${EMAIL_MSG}`,
		})
	} else if (usersInDb.length > 0) {
		results.push({
			id,
			msg: `Email ${ALREADY_USED_MESSAGE}`,
		})
	}

	return results
}

function verifyPassword(password, cpassword, ids) {
	const results = []

	if (isEmpty(password)) {
		results.push({
			id: ids.password,
			msg: `Password ${REQUIRED_FIELD_MSG}`,
		})
	} else if (!lengthBetween(password.length, PASSWORD_MIN_LENGTH)) {
		results.push({
			id: ids.password,
			msg: `Password length must be greater than ${PASSWORD_MIN_LENGTH}.`,
		})
	} else if (checkPassword(password) !== true) {
		const missing = checkPassword(password)
		results.push({
			id: ids.password,
			msg: `Password must have at least one ${missing}`,
		})
	} else if (password != cpassword) {
		results.push({
			id: ids.cpassword,
			msg: `Passwords doesn't match.`,
		})
	}

	return results
}

async function getUserInfo(username) {
	let users
	await axios
		.get(`./request/request.php?username=${username}`)
		.then((result) => (users = result.data))
		.catch((err) => console.error(err))
	return users
}
async function getUserByEmail(email) {
	let user
	await axios
		.get(`./request/request.php?email=${email}`)
		.then((result) => (user = result.data))
		.catch((err) => console.error(err))
	return user
}
