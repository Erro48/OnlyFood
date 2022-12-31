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

window.onload = () => {
	let obj = document.getElementById('main-container')
	//obj.addEventListener('scroll', onScroll)
	setPostsContainerHeight()
}

window.onresize = () => {
	setPostsContainerHeight()
}

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

function setPostsContainerHeight() {
	const main = document.querySelector("main");
	const profileSection = document.querySelector("section.profile-section");
	const h2 = document.querySelector("section.posts-section > h2");
	const postsContainerDiv = document.querySelector("#posts-container-div");
	console.log(main.offsetHeight);
	console.log(profileSection.offsetHeight + h2.offsetHeight + parseInt(getComputedStyle(h2).marginTop) + parseInt(getComputedStyle(h2).marginBottom));
	const height = main.offsetHeight - (profileSection.offsetHeight + h2.offsetHeight + parseInt(getComputedStyle(h2).marginTop) + parseInt(getComputedStyle(h2).marginBottom));
	postsContainerDiv.style.height = "".concat(height - 1, "px");
	console.log(postsContainerDiv.offsetHeight);
	console.log(getComputedStyle(h2).marginBottom);
}