const SCROLL_OFFSET_TRIGGER = 200

const InteractionType = {
	FOLLOWER: 'follower',
	FOLLOWING: 'following',
}

function onScroll(event) {
	let scrollDelta = event.srcElement.scrollTop
	let element = document.getElementsByClassName('profile-section')[0]
	/*
    if (scrollDelta >= SCROLL_OFFSET_TRIGGER) {
        element.classList.add("reduced");
        Array.from(document.getElementsByClassName("hideable")).forEach(elem => {
            elem.classList.add("hidden");
        });
        
    }

    if (scrollDelta < SCROLL_OFFSET_TRIGGER) {
        element.classList.remove("reduced");
        Array.from(document.getElementsByClassName("hideable")).forEach(elem => {
            elem.classList.remove("hidden");
        });
    }
	*/
}

/*window.onload = () => {
	let obj = document.getElementById('main-container')
	//obj.addEventListener('scroll', onScroll)
	setPostsContainerHeight()
}*/

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
				let currentCount = document.querySelector(`#num-${type}`).innerHTML
				document.querySelector(`#num-${type}`).innerHTML =
					Number(currentCount) + 1
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
				let currentCount = document.querySelector(`#num-${type}`).innerHTML
				document.querySelector(`#num-${type}`).innerHTML =
					Number(currentCount) - 1
				switchButton(button)
			}
		})
		.catch((err) => console.error(err))
}

function setPostsContainerHeight() {
	const main = document.querySelector('main')
	const profileSection = document.querySelector('section.profile-section')
	const h2 = document.querySelector('section.posts-section > h2')
	const postsContainerDiv = document.querySelector('#posts-container-div')
	const height =
		main.offsetHeight -
		(profileSection.offsetHeight +
			h2.offsetHeight +
			parseInt(getComputedStyle(h2).marginTop) +
			parseInt(getComputedStyle(h2).marginBottom))
	postsContainerDiv.style.height = ''.concat(height - 1, 'px')
}

async function loadFollowModal(user, type) {
	const data = await (type == InteractionType.FOLLOWER
		? getFollowers(user)
		: getFollowings(user))

	const modalTitle = document.querySelector('#followModal header *:first-child')
	modalTitle.innerText = capitalizeString(type) + 's'
	const modalListContainer = document
		.querySelector(`#followModal`)
		.querySelector('.modal-list')

	modalListContainer.innerHTML = data
		.map((user) => createFollowModalListItem(user, type))
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

function createFollowModalListItem(user, type) {
	const followButton = createModalFollowButton(user, type)
	return `
		<div class="row m-auto align-items-center" id="${user.username}-row">
			<div class="col-2">
				<img src="imgs/propics/${user.profilePic}" alt="">
			</div>
			<a class="col-7 user-username" href="./profile.php?user=${user.username}">
				${user.username}
			</a>
			<div class="col-3">
				${followButton}
			</div>
		</div>`
}

function createModalFollowButton({ username, follows_back }, type) {
	if (type == InteractionType.FOLLOWING || follows_back) {
		return `
		<button id="modal-follow-button" class="button-primary" onclick="unfollow('${username}', this, InteractionType.FOLLOWING)" data-follow="false" data-user="${username}">
			Unfollow
		</button>`
	}

	return `
		<button id="modal-follow-button" class="button-secondary" onclick="follow('${username}', this, InteractionType.FOLLOWING)" data-follow="true" data-user="${username}">
			Follow
		</button>`
}
