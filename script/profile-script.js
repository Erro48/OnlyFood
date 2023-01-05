const SCROLL_OFFSET_TRIGGER = 200

/**
 * @enum Status
 */
const Status = {
	REDUCED: 1,
	NOT_REDUCED: 0
}

let currentStatus = Status.NOT_REDUCED;

function onScroll(event) {
	let scrollDelta = event.srcElement.scrollTop
	let element = document.getElementsByClassName('profile-section')[0]
	
    if (scrollDelta >= SCROLL_OFFSET_TRIGGER && currentStatus == Status.NOT_REDUCED) {
		element.classList.add("reduced")
		currentStatus = Status.REDUCED;
		Array.from(document.getElementsByClassName("hideable")).forEach(elem => {
            elem.classList.add("hidden");
        });
		setPostsContainerHeight();
	}

    if (scrollDelta < SCROLL_OFFSET_TRIGGER && currentStatus == Status.REDUCED) {
		element.classList.remove("reduced")
		currentStatus = Status.NOT_REDUCED;
		Array.from(document.getElementsByClassName("hideable")).forEach(elem => {
            elem.classList.remove("hidden");
        });
		setPostsContainerHeight();
	}
}

addLoadEventOnload(setScrollBehaviour);
addLoadEventOnload(setPostsContainerHeight);
addLoadEventOnresize(setPostsContainerHeight);

function setScrollBehaviour() {
	document
		.querySelector("#posts-container-div")
		.children[0].addEventListener('scroll', onScroll);
}

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
function switchButton() {
	const followButton = document.querySelector("#follow-button");
	const unfollowButton = document.querySelector("#unfollow-button");
	if (followButton.classList.contains("d-none")) {
		unfollowButton.classList.add("d-none");
		followButton.classList.remove("d-none");
	} else {
		unfollowButton.classList.remove("d-none");
		followButton.classList.add("d-none");
	}
}


/**
 * Follow an user
 * @param {String} user 
 */
function follow(user) {
	axios
		.get(`./request/request.php?follow=` + user)
		.then((result) => {
			if (result.data == 1) {
				let currentCount = document.querySelector("#num-follower")
											.innerHTML;
				document.querySelector("#num-follower")
						.innerHTML = Number(currentCount) + 1;
				switchButton();
			}
		})
		.catch((err) => console.error(err))
}

/**
 * Unfollow an user
 * @param {String} user 
 */
function unfollow(user) {
	axios
		.get(`./request/request.php?unfollow=` + user)
		.then((result) => {
			if (result.data == 1) {
				let currentCount = document.querySelector("#num-follower")
											.innerHTML;
				document.querySelector("#num-follower")
						.innerHTML = Number(currentCount) - 1; 
				switchButton();
			}
		})
		.catch((err) => console.error(err))
}

function setPostsContainerHeight() {
	const main = document.querySelector("main");
	const profileSection = document.querySelector("section.profile-section");
	const h2 = document.querySelector("section.posts-section > h2");
	const postsContainerDiv = document.querySelector("#posts-container-div");
	const height = main.offsetHeight - (profileSection.offsetHeight + h2.offsetHeight + parseInt(getComputedStyle(h2).marginTop) + parseInt(getComputedStyle(h2).marginBottom));
	console.log("set height ", height);
	postsContainerDiv.style.height = "".concat(height - 1, "px");
}