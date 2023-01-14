window.onload = (event) => {
    setCommentsSectionHeight();
}

window.onresize = (event) => {
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

function sendComment(id, text){
    if(text.replaceAll(/\s/g, "") != "") {
        axios.post(`request/insertComment.php`, {
            postId: id,
            text: text
        })
        .then((data) => {
            location.reload();
        })
        .catch((err) => console.error(err));
    }
}
