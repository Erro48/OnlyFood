addLoadEventOnload(setPostsHeight)
addLoadEventOnresize(setPostsHeight)

function setPostsHeight() {
	const postsContainer = document.querySelector('div.posts-container')
	if(postsContainer){
		const posts = postsContainer.children
		for (let i = 0; i < posts.length; i++) {
			if(posts[i].children.length > 0){
				calculateRecipeSectionHeight(posts[i].children[0])
			}
		}
	}
}

function calculateRecipeSectionHeight(article) {
	const img = new Image()
	img.src = article.querySelector('img').src
	const ratio = img.width / img.height
	const height = article.offsetWidth / ratio
	if (height > 350) {
		article.querySelector('section.recipe-section').style.height = ''.concat(
			height,
			'px'
		)
	} else {
		article.querySelector('section.recipe-section').style.height = '350px'
	}
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
	calculateRecipeSectionHeight(
		document.querySelector('article#article-'.concat(id))
	)
	img.style.display = 'none'
	div.style.display = 'flex'
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
