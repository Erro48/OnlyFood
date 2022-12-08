
const SCROLL_OFFSET_TRIGGER = 200;

function onScroll(event) {
    let scrollDelta = event.srcElement.scrollTop;
    let element = document.getElementsByClassName("profile-section")[0];
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
    let obj = document.getElementById("main-container");
    obj.addEventListener('scroll', onScroll);
}    

