<<<<<<< HEAD
addLoadEventOnload(setPostsHeight);
addLoadEventOnresize(setPostsHeight);
=======
window.onload = (event) => {
	setPostsHeight()
}

window.onresize = (event) => {
	setPostsHeight()
}
>>>>>>> create-post

function setPostsHeight() {
	const posts = document.querySelector('div.posts-container').children
	for (let i = 0; i < posts.length; i++) {
		calculateRecipeSectionHeight(posts[i].children[0])
	}
}

function calculateRecipeSectionHeight(article) {
<<<<<<< HEAD
    const img = new Image();
    img.src = article.querySelector("img").src;
    const ratio = img.width / img.height;
    const height = article.offsetWidth / ratio;
    if(height > 350){
        article.querySelector("section.recipe-section").style.height = "".concat(height, "px");
    } else {
        article.querySelector("section.recipe-section").style.height = "350px";
    }
=======
	const img = new Image()
	img.src = article.querySelector('img').src
	const ratio = img.width / img.height
	const height = article.offsetWidth / ratio
	if (height > 300) {
		article.querySelector('section.recipe-section').style.height = ''.concat(
			height,
			'px'
		)
	} else {
		article.querySelector('section.recipe-section').style.height = '300px'
	}
>>>>>>> create-post
}

function showPicture(id) {
	const div = document.querySelector(
		'article#article-'.concat(id, ' > section.recipe-section')
	)
	const img = document.querySelector('article#article-'.concat(id, ' > img'))
	const pictureInput = document.querySelector(
		'article#article-'.concat(id, ' > footer > ul > li:first-child > input')
	)
	const recipeInput = document.querySelector(
		'article#article-'.concat(id, ' > footer > ul > li:nth-child(2) > input')
	)
	recipeInput.classList.remove('preview-selected-right')
	pictureInput.classList.add('preview-selected-left')
	div.style.display = 'none'
	img.style.display = 'inline-block'
}

<<<<<<< HEAD
function showRecipe(id){
    const div = document.querySelector("article#article-".concat(id, " > section.recipe-section"));
    const img = document.querySelector("article#article-".concat(id, " > img"));
    const pictureInput = document.querySelector("article#article-".concat(id, " > footer > ul > li:first-child > input"));
    const recipeInput = document.querySelector("article#article-".concat(id, " > footer > ul > li:nth-child(2) > input"));
    pictureInput.classList.remove("preview-selected-left");
    recipeInput.classList.add("preview-selected-right");
    calculateRecipeSectionHeight(document.querySelector("article#article-".concat(id)));
    img.style.display = "none";
    div.style.display = "flex";
=======
function showRecipe(id) {
	const div = document.querySelector(
		'article#article-'.concat(id, ' > section.recipe-section')
	)
	const img = document.querySelector('article#article-'.concat(id, ' > img'))
	const pictureInput = document.querySelector(
		'article#article-'.concat(id, ' > footer > ul > li:first-child > input')
	)
	const recipeInput = document.querySelector(
		'article#article-'.concat(id, ' > footer > ul > li:nth-child(2) > input')
	)
	pictureInput.classList.remove('preview-selected-left')
	recipeInput.classList.add('preview-selected-right')
	img.style.display = 'none'
	div.style.display = 'flex'
>>>>>>> create-post
}

function like(id) {
	axios
		.get(`request/like.php?postId=${id}`)
		.then((data) => {
			document.querySelector(
				'article#article-'.concat(id, ' button.like-button')
			).className = 'action-button like-button '.concat(data.data.class)
			document.querySelector(
				'article#article-'.concat(id, ' p.like-number-p')
			).innerHTML = data.data.likeNumber
		})
		.catch((err) => console.error(err))
}
