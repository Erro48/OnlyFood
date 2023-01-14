/*addLoadEventOnload(setTagListContainerHeight);
addLoadEventOnresize(setTagListContainerHeight);

function setTagListContainerHeight(){
    const height = document.querySelector(".tags-container").offsetHeight - (document.querySelector(".tag-h2-container").offsetHeight + document.querySelector(".search-bar-container").offsetHeight + parseInt(getComputedStyle(document.querySelector(".search-bar-container")).marginBottom));
    document.querySelector(".tag-list-container").style.maxHeight = "".concat(height, "px");
}*/

function searchTag(elem){
    const searchValue = elem.value;
    const tagListContainer = document.querySelector(".tag-list-container");

    axios.get(`request/searchTag.php?tag=${searchValue}`)
    .then((data) => {
        clearElement(tagListContainer);

        for (tag of data.data) {
            tagListContainer.append(createTagRow(tag));
         }
    })
    .catch((err) => console.error(err));
}

function createTagRow(tagData){
    const container = document.createElement("div");
    container.classList.add("col-12");
    container.classList.add("col-md-6");
    container.innerHTML = `<label>
                                <input type="checkbox" onclick="handleClick()">
                                ${tagData.name}
                            </label>`;
    return container;
}

function handleClick() {
let tags = "[";
const tagListContainer = document.querySelector(".tag-list-container");
for (let i = 1; i < tagListContainer.children.length; i++) {
    const label = tagListContainer.children[i].children[0];
    if(label.children[0].checked){
        tags = tags.concat("\"", label.innerText.replace(" ", ""), "\",");
    }
}
tags = tags.substring(0, tags.length - 1);
tags = tags.concat("]");
const postsContainer = document.querySelector(".posts-container");

axios.get(`request/postTags.php?tag=${tags}`)
.then((data) => {
    clearElement(postsContainer);
    if(data.data.length > 0){
        for(post of data.data){
            postsContainer.append(createPost(post));
        }
    } else {
        postsContainer.innerHTML = "<p class=\"ps-1\">There is no post to see.</p>";
    }
})
.catch((err) => console.error(err));
}

function createPost(postData){
    const container = document.createElement("div");
    container.classList.add("col-12");
    container.classList.add("single-post-container");
    let containerContent = `<article id="article-${postData.postId}" class="row post-article">
                                <h3 class="d-none">Post</h3>
                                <section class="col-12 recipe-section">
                                    <h4 class="d-none">Recipe</h4>
                                    <section class="ingredients-container">
                                        <h5 class="d-none">Ingredients</h5>`;
    let i = 0;
    postData.ingredients.forEach(ingredient => {
        containerContent += `<div class="ingredient-div" style="outline: 3.5px solid #${ingredient.color};">
                                <div class="ingredient-name-div">
                                    ${ingredient.name}
                                </div>
                                <div class="ingredient-quantity-div" style="outline: 3.5px solid #${ingredient.color};">
                                    ${ingredient.quantity} ${ingredient.acronym}
                                </div>
                            </div>`;
    });
    containerContent += `</section>
                        <p class="howto-p">How To</p>
                        <section class="howto-section">
                            <h5 class="d-none">How To</h5>
                            <p>${postData.howTo}</p>
                        </section>
                    </section>
                    <img src="imgs/posts/${postData.preview}" alt="${postData.description}" />
                    <div class="row info-container">
                        <div class="col-2">
                            <a href="./profile.php?user=${postData.owner}">
                                <img src="imgs/propics/${postData.profilePic}" alt="Propic of ${postData.owner}" />
                            </a>
                        </div>
                        <div class="col-6 p-1">
                            <p>
                                <a href="./profile.php?user=${postData.owner}">${postData.owner}
                                </a>
                            </p>
                            <p>${postData.description}</p>
                        </div>
                        <div class="col-2 p-0">
                            <div class="row w-100 justify-content-center m-0">
                                <button class="action-button like-button ${postData.likeButtonClass}" onclick="like(${postData.postId})">
                                    <img src="imgs/icons/like-button.svg" alt="like button icon" />
                                </button>
                            </div>
                            <div class="row w-100 justify-content-center m-0">
                                <p class="likes-comments-p like-number-p">
                                    ${postData.likes}
                                </p>
                            </div>
                        </div>
                        <div class="col-2 p-0">
                            <div class="row w-100 justify-content-center m-0">
                                <button class="action-button comments-button" onclick="window.open('comments.php?post=${postData.postId}', '_blank')">
                                    <img src="imgs/icons/comments-button.svg" alt="comments button icon" />
                                </button>
                            </div>
                            <div class="row w-100 justify-content-center m-0">
                                <p class="likes-comments-p">
                                    ${postData.comments}
                                </p>
                            </div>
                        </div>
                    </div>
                    <footer class="row">
                        <div class="col-2"></div>
                        <ul class="col-8 double-selector">
                            <li class="col-6">
                                <input type="button" value="Picture" class="preview-selected-left" onclick="showPicture(${postData.postId})">
                            </li><li class="col-6">
                                <input type="button" value="Recipe" onclick="showRecipe(${postData.postId})">
                            </li>
                        </ul>
                        <div class="col-2"></div>
                    </footer>
                    </article>`;
    container.innerHTML = containerContent;
    return container;
}