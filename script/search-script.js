
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
    } else {
        /* Show users */
        users.classList.remove("hidden");
        recipe.classList.add("hidden");
        usersButton.classList.add("selected");
        recipesButton.classList.remove("selected");
    }
}


function search(elem) {
    const searchValue = elem.value;
    const output = document.querySelector('#output-list');
    
    if (searchValue.length < 3) {
        clearItems(output);
        return;
    }
    
    axios
        .get(`./request/request.php?user=${searchValue}`)
        .then((data) => {
            clearItems(output);
            
             for (user of data.data) {
                output.append(createUserSearchResult(user))
             }
        })
        .catch((err) => console.error(err))
}


function createUserSearchResult(data) {
    const container = document.createElement('article');
    container.innerHTML = ` <a class="row reset-a" href="profile.php?user=${data.username}">
                                <div class="col-3 ps-1">
                                    <img class="profile-preview" src="${data.profilePic}" />
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

function clearItems(container) {
    while (container.firstChild) {
        container.removeChild(container.lastChild)
    }
}