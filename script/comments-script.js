window.onload = (event) => {
    //setCommentsHeight();
    setCommentsSectionHeight();
}

window.onresize = (event) => {
    //setCommentsHeight();
    setCommentsSectionHeight();
}

function setCommentsSectionHeight(){
    const commentsSection = document.querySelector("section#comments-section");
    const postInfoSection = document.querySelector("section#post-info-section");
    const writeCommentSection = document.querySelector("section#write-comment-section");
    const main = document.querySelector("main");
    const height = main.offsetHeight - (postInfoSection.offsetHeight + writeCommentSection.offsetHeight);
    commentsSection.style.height = "".concat(height, "px");
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