

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
    container.innerHTML = ` <div class="col-3 ps-1">
                                <img class="profile-preview" src="${data.profilePic}" />
                            </div>
                            <div class="col-6 d-flex align-items-center ">
                                <p class="username-label">${data.username}</p>
                            </div>
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