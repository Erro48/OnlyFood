function showPicture(id){
    const div = document.querySelector("article.article-".concat(id, " > section.recipe-section"));
    const img = document.querySelector("article.article-".concat(id, " > img"));
    const pictureInput = document.querySelector("article.article-".concat(id, " > footer > ul > li:first-child > input"));
    const recipeInput = document.querySelector("article.article-".concat(id, " > footer > ul > li:nth-child(2) > input"));
    recipeInput.classList.remove("preview-selected-right");
    pictureInput.classList.add("preview-selected-left");
    div.style.display = "none";
    img.style.display = "inline-block";
}

function showRecipe(id){
    const div = document.querySelector("article.article-".concat(id, " > section.recipe-section"));
    const img = document.querySelector("article.article-".concat(id, " > img"));
    const pictureInput = document.querySelector("article.article-".concat(id, " > footer > ul > li:first-child > input"));
    const recipeInput = document.querySelector("article.article-".concat(id, " > footer > ul > li:nth-child(2) > input"));
    pictureInput.classList.remove("preview-selected-left");
    recipeInput.classList.add("preview-selected-right");
    img.style.display = "none";
    div.style.display = "inline-block";
}