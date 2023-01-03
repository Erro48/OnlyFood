const SCROLL_OFFSET_TRIGGER = 200

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

addLoadEventOnload(setPostsContainerHeight);
addLoadEventOnresize(setPostsContainerHeight);

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
	postsContainerDiv.style.height = "".concat(height - 1, "px");
}