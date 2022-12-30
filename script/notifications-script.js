

window.onload = () => {
    let outputContainer = document.querySelector("#output");
    /*
        for (let i=0; i<20; i++)
            outputContainer.append(createNotification("a"));
    */
}    




function createNotification(data) {
    const container = document.createElement('article');
    container.innerHTML = ` <a class="row reset-a" href="profile.php?user=">
                                <div class="col-3 ps-1">
                                    <img class="profile-preview" src="imgs/propics/default.png" />
                                </div>
                                <div class="col-6 d-flex flex-column align-items-center">
                                    <p class="notification-label m-2"> Notification Text </p>
                                </div>
                            </a>
    `;
    container.classList.add('row');
    container.classList.add('p-1');
    container.classList.add('notification');
    container.classList.add('mt-2');
    return container;
}