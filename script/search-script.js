
/**
 * @enum
 */
const SearchMode = {
    USERS: 0,
    POSTS: 1
}

var currentMode = SearchMode.USERS;

/**
 * Switch the search mode from users to posts or viceversa
 */
function switchSearchMode() {
    const recipe = document.querySelector("#recipe-search");
    const users = document.querySelector("#users-search");

    const usersButton = document.querySelector("#users-button");
    const recipesButton = document.querySelector("#recipes-button");

    if (recipe.classList.contains("hidden")) {
        /* Show recipe */
        recipe.classList.remove("hidden");
        users.classList.add("hidden");
        recipesButton.classList.add("selected");
        usersButton.classList.remove("selected");
        currentMode = SearchMode.POSTS;
    } else {
        /* Show users */
        users.classList.remove("hidden");
        recipe.classList.add("hidden");
        usersButton.classList.add("selected");
        recipesButton.classList.remove("selected");
        currentMode = SearchMode.USERS;
    }
}

/**
 * Updates asynchronously the search list depending on the search keywork in the 
 * given input element
 * @param {HTMLInputElement} elem, the element that provides the search words 
 * @returns 
 */
function searchData(elem) {
    const searchValue = elem.value;
    const output = document.querySelector('#output-list');
    
    if (searchValue.length < 3) {
        clearItems(output);
        return;
    }
    
    switch(currentMode) {
        case SearchMode.POSTS:
            axios
            .get(`./request/searchPost.php?title=${searchValue}`)
            .then((data) => {
                clearItems(output);
                console.log(data)
                for (post of data.data) {
                    output.append(createPostSearchResult(post))
                }
            })
            .catch((err) => console.error(err))
        break;
        case SearchMode.USERS:      
            axios
            .get(`./request/searchUser.php?user=${searchValue}`)
            .then((data) => {
                clearItems(output);

                for (user of data.data) {
                    output.append(createUserSearchResult(user))
                }
            })
            .catch((err) => console.error(err))
        break;
    }
}

/**
 * 
 * @param {*} elem 
 * @returns 
 */
async function searchModal(searchInput) {
    const searchValue = searchInput.value.trim()
	const dropdownBody = document.querySelector('#search-simple-ingredients-result')

	if (searchValue.length < 3) {
		clearElement(dropdownBody)
		dropdownBody.parentElement.classList.add('d-none')
		return
	}

	const ingredients = await searchForIngredient(searchValue)
	dropdownBody.parentElement.classList.remove('d-none')
	displaySimpleIngredients(ingredients, dropdownBody)
}

/**
 * Creates the element that represents the clickable banner of a profile in the
 * output list
 * @param {QueryResult} data, ajax query data for a profile 
 * @returns 
 */
function createUserSearchResult(data) {
    const container = document.createElement('article');
    container.innerHTML = ` <a class="row reset-a" href="profile.php?user=${data.username}">
                                <div class="col-3 ps-1 d-flex align-items-center">
                                    <img class="profile-preview" src="${data.profilePic}" alt="Propic of ${data.username}" />
                                </div>
                                <div class="col-6 d-flex flex-column align-items-center">
                                    <p class="username-label m-2"> ${data.username} </p>
                                    <p class="name-surname-label m-0"> ${data.name} ${data.surname} </p>
                                </div>
                            </a>
    `;
    container.classList.add('row');
    container.classList.add('p-1');
    container.classList.add('user-search');
    container.classList.add('mt-2');
    return container;
}


/*
<section class="ingredients-container">
    <div class="ingredient-div" style="outline: 3.5px solid #e3e3e3">
        <div class="ingredient-name-div">
            salt                                    
        </div>
        <div class="ingredient-quantity-div" style="outline: 3.5px solid #e3e3e3">
            4 tbsp                                    
        </div>
    </div>
        <div class="ingredient-div" style="outline: 3.5px solid #d1d1d1">
        <div class="ingredient-name-div">
            sugar                                    
        </div>
        <div class="ingredient-quantity-div" style="outline: 3.5px solid #d1d1d1">
            25 gr
        </div>
    </div>
</section>
*/


function createIngredientResult(data) {
    const ingredientContainer = document.createElement('div');
    ingredientContainer.classList.add('ingredient-div')
    ingredientContainer.style.outlineColor="#" + data.color;
    ingredientContainer.innerHTML = `
        <div class="ingredient-name-div">
            ${data.name}        
        </div>
        <div class="ingredient-quantity-div" style="outline-color: #${data.color}">
            ${data.quantity} ${data.acronym}                                    
        </div>
    `;
    return ingredientContainer;
}


/**
 * Creates the posts appended in the output
 * @param {QueryResult} data, ajax query data for a post 
 */
function createPostSearchResult(data) {
    const container = document.createElement('div');
    container.classList.add('col-12');
    container.classList.add('single-post-container');

    let ingredientContainers = data.ingredients
                        .map(ingredient => createIngredientResult(ingredient).outerHTML)
                        .join('');

    const post = document.createElement('article');
    post.innerHTML = `
            <section class="col-12 recipe-section">
                <section class="ingredients-container">
                    ${ingredientContainers}
                </section>    
                <h2>How To</h2>
                <section class="howto-section">
                    <p>${data.howTo}</p>
                </section>
            </section>
            <img class="col-12" src="${data.preview}" alt="${data.description}">
            <div class="row info-container">
                <div class="col-2">
                    <img src="${data.profilePic}" alt="Propic of ${data.username}">
                </div>
                <div class="col-6 p-1">
                    <p>${data.username}</p>
                    <p>${data.description}</p>
                </div>
                <div class="col-2 p-0">
                    <div class="row w-100 justify-content-center m-0">
                        <button class="action-button like-button ${data.liked ? "liked" : "" }" onclick="like(${data.postId})">
                            <img src="imgs/icons/like-button.svg" alt="like button icon">
                        </button>
                    </div>
                    <div class="row w-100 justify-content-center m-0">
                        <p class="likes-comments-p like-number-p">
                            ${data.likes}
                        </p>
                    </div>
                </div>
                <div class="col-2 p-0">
                    <div class="row w-100 justify-content-center m-0">
                        <button class="action-button comments-button" onclick="window.location.href='comments.php?post=${data.postId}'">
                            <img src="imgs/icons/comments-button.svg" alt="comments button icon">
                        </button>
                    </div>
                    <div class="row w-100 justify-content-center m-0">
                        <p class="likes-comments-p">
                            ${data.comments}
                        </p>
                    </div>
                </div>
            </div>
            <footer class="row">
                <div class="col-2"></div>
                <ul class="col-8 double-selector">
                    <li class="col-6">
                        <input type="button" value="Picture" class="preview-selected-left" onclick="showPicture(${data.postId})">
                    </li><li class="col-6">
                        <input type="button" value="Recipe" onclick="showRecipe(${data.postId})">
                    </li>
                </ul>
                <div class="col-2"></div>
            </footer>
    `;
    post.id = `article-${data.postId}`;
    post.classList.add("row");
    post.classList.add("post-article");
    container.appendChild(post);
    return container;
}

/**
 * Clears all the children of an element
 * @param {HTMLElement} container 
 */
function clearItems(container) {
    while (container.firstChild) {
        container.removeChild(container.lastChild)
    }
}

