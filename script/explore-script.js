window.onload = (event) => {
    setTagListContainerHeight();
}

window.onresize = (event) => {
    setTagListContainerHeight();
}

function setTagListContainerHeight(){
    const height = document.querySelector(".tags-container").offsetHeight - (document.querySelector(".tag-h2-container").offsetHeight + document.querySelector(".search-bar-container").offsetHeight + parseInt(getComputedStyle(document.querySelector(".search-bar-container")).marginBottom));
    document.querySelector(".tag-list-container").style.height = "".concat(height, "px");
}

function handleClick(cb) {
    console.log("Clicked, new value = " + cb.checked);

    let tags = "[";
    const tagListContainer = document.querySelector(".tag-list-container");
    for (let i = 0; i < tagListContainer.children.length; i++) {
        const label = tagListContainer.children[i].children[0];
        if(label.children[0].checked){
            tags = tags.concat("\"", label.innerText.replace(" ", ""), "\",");
        }
    }
    tags = tags.substring(0, tags.length - 1);
    tags = tags.concat("]");
    console.log(tags);
    //const tags = "[\"breakfast\",\"launch\",\"dinner\"]";
    const postsContainer = document.querySelector(".posts-container");

    axios.get(`request/postTags.php?tag=${tags}`)
    .then((data) => {
      clearItems(postsContainer);
      for(post of data.data){
            postsContainer.append(createPost(post));
        }
    });
    }

    function clearItems(container){
    while (container.firstChild) {
        container.removeChild(container.lastChild)
    }
    }

    function createPost(postData){
    console.log(postData);

    const container = document.createElement("div");
    container.classList.add("col-12");
    container.classList.add("single-post-container");
    let containerContent = ` <article class="row post-article article-${postData.postId}">
                                <section class="col-12 recipe-section">`;
    containerContent += "INGREDIENTI";       //TODO mettere ingredienti
    containerContent += `<h2>How To</h2>
                        <section class="howto-section">
                            <p>${postData.howTo}</p>
                        </section>
                    </section>
                    <img src="${postData.preview}" alt="${postData.description}" />
                    <div class="row info-container">
                        <div class="col-2">
                            <img src="${postData.profilePic}" alt="Propic of ${postData.owner}" />
                        </div>
                        <div class="col-7">
                            <p>${postData.owner}</p>
                            <p>${postData.description}</p>
                        </div>
                        BOTTONI
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