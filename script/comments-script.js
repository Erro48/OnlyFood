window.onload = (event) => {
    //setCommentsHeight();
    setCommentsSectionHeight();
}

window.onresize = (event) => {
    //setCommentsHeight();
    setCommentsSectionHeight();
}

function setCommentsSectionHeight(){

}

function setCommentsHeight(){
    const commentArticles = document.getElementsByClassName("comment-article");
    for(let i = 0; i < commentArticles.length; i++) {
        const img = commentArticles[i].children[0].children[0];
        const usernameP = commentArticles[i].children[1].children[0];
        const dateP = commentArticles[i].children[1].children[1];
        const commentP = commentArticles[i].children[1].children[2];
        const maxHeightP = usernameP.offsetHeight >= dateP.offsetHeight ? usernameP : dateP;
        const height = img.offsetHeight - (maxHeightP.offsetHeight + parseInt(getComputedStyle(maxHeightP).marginBottom));
        commentP.style.maxHeight = "".concat(height, "px");
    }
}