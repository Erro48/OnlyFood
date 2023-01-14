
const InteractionType = {
	FOLLOWER: 'follower',
	FOLLOWING: 'following',
}


addLoadEventOnload(setPostsContainerHeight)
addLoadEventOnresize(setPostsContainerHeight)

/**
 * Logout from the current session
 */
function logout() {
	axios
		.get(`./request/request.php?logout`)
		.then((result) => {
			if (result.data == 1) {
				window.location.href = 'login.php'
			}
		})
		.catch((err) => console.error(err))
}

/**
 * Switch follow/unfollow button
 */
function switchButton(button) {
	if (button.id == 'follow-button' || button.id == 'unfollow-button') {
		const followButton = document.querySelector('#follow-button').parentNode
		const unfollowButton = document.querySelector('#unfollow-button').parentNode
		if (followButton.classList.contains('d-none')) {
			unfollowButton.classList.add('d-none')
			followButton.classList.remove('d-none')
		} else {
			unfollowButton.classList.remove('d-none')
			followButton.classList.add('d-none')
		}
	}

	if (button.id == 'modal-follow-button') {
		button.classList.toggle('button-primary')
		button.classList.toggle('button-secondary')

		if (button.dataset.follow == 'true') {
			button.innerText = 'Unfollow'
			button.setAttribute(
				'onclick',
				`unfollow('${button.dataset.user}',this,InteractionType.FOLLOWING)`
			)
		} else {
			button.innerText = 'Follow'
			button.setAttribute(
				'onclick',
				`follow('${button.dataset.user}',this,InteractionType.FOLLOWING)`
			)
		}

		button.dataset.follow = !(button.dataset.follow == 'true')
	}
}

/**
 * Follow an user
 * @param {String} user
 */
function follow(user, button, type = InteractionType.FOLLOWER) {
	axios
		.get(`./request/request.php?follow=` + user)
		.then((result) => {
			if (result.data == 1) {
				if (button.dataset.currentPage == 'true') {
					let currentCount = document.querySelector(`#num-${type}`).innerHTML
					document.querySelector(`#num-${type}`).innerHTML =
						Number(currentCount) + 1
				}
				switchButton(button)
			}
		})
		.catch((err) => console.error(err))
}

/**
 * Unfollow an user
 * @param {String} user
 * @param {HTMLButtonElement} button - The button who calls the unfollow function
 * @param {InteractionType} type - Specifies se bisogna ridurre il numero di followe o di following
 */
function unfollow(user, button, type = InteractionType.FOLLOWER) {
	axios
		.get(`./request/request.php?unfollow=` + user)
		.then((result) => {
			if (result.data == 1) {
				if (button.dataset.currentPage == 'true') {
					let currentCount = document.querySelector(`#num-${type}`).innerHTML
					document.querySelector(`#num-${type}`).innerHTML =
						Number(currentCount) - 1
				}
				switchButton(button)
			}
		})
		.catch((err) => console.error(err))
}

function setPostsContainerHeight() {
	const main = document.querySelector('main')
	const profileSection = document.querySelector('section.profile-section')
	const postsContainerDiv = document.querySelector('#posts-container-div')
	const height = main.offsetHeight - profileSection.offsetHeight
	postsContainerDiv.style.height = ''.concat(height - 1, 'px')
}

async function loadFollowModal(user, loggedUser, type) {
	const data = await (type == InteractionType.FOLLOWER
		? getFollowers(user)
		: getFollowings(user))

	const modalTitle = document.querySelector('#followModal header *:first-child')
	modalTitle.innerText = capitalizeString(type) + 's'
	const modalListContainer = document
		.querySelector(`#followModal`)
		.querySelector('.modal-list')

	modalListContainer.innerHTML = data
		.map((modalUser) =>
			createFollowModalListItem(
				{
					username: modalUser.username,
					isCurrentPage: loggedUser == user,
					followsBack: modalUser.follows_back,
					...modalUser,
				},
				type
			)
		)
		.join('')
}

async function getFollowings(username) {
	let followings = []
	await axios
		.get(`./request/follow.php?followings_of=${username}`)
		.then((result) => {
			followings = result.data
		})
		.catch((err) => console.error(err))
	return followings
}

async function getFollowers(username) {
	let followers = []
	await axios
		.get(`./request/follow.php?followers_of=${username}`)
		.then((result) => {
			followers = result.data
		})
		.catch((err) => console.error(err))
	return followers
}

function createFollowModalListItem(userData, type) {
	const followButton = createModalFollowButton(userData, type)
	return `
		<div class="row g-0 m-auto align-items-center" id="${userData.username}-row">
			<div class="col-2">
				<img class="profile-pic" src="imgs/propics/${userData.profilePic}" alt="${
		userData.username
	} profile picture">
			</div>
			<div class="col-7">
				<a class="user-username dotted-word px-3 px-md-4 py-2" href="./profile.php?user=${
					userData.username
				}">
					${userData.username}
				</a>
			</div>
			<div class="col-3 ps-lg-4">
				${userData.current == undefined ? followButton : ''}
			</div>
		</div>`
}

function createModalFollowButton(
	{ username, isCurrentPage, followsBack },
	type
) {
	if ((type == InteractionType.FOLLOWING && isCurrentPage) || followsBack) {
		return `
		<button id="modal-follow-button" class="follow-button button-primary" data-current-page="${isCurrentPage}" onclick="unfollow('${username}', this, InteractionType.FOLLOWING)" data-follow="false" data-user="${username}">
			Unfollow
		</button>`
	}

	return `
		<button id="modal-follow-button" class="follow-button button-secondary" data-current-page="${isCurrentPage}" onclick="follow('${username}', this, InteractionType.FOLLOWING)" data-follow="true" data-user="${username}">
			Follow
		</button>`
}
