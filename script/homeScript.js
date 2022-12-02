function showPicture(id){
    const div = document.querySelector("section.section-".concat(id, " > div"));
    const img = document.querySelector("section.section-".concat(id, " > img"));
    const pictureInput = document.querySelector("section.section-".concat(id, " > footer > ul > li:first-child > input"));
    const recipeInput = document.querySelector("section.section-".concat(id, " > footer > ul > li:nth-child(2) > input"));
    recipeInput.classList.remove("preview-selected");
    pictureInput.classList.add("preview-selected");
    div.style.display = "none";
    img.style.display = "inline-block";
}

function showRecipe(id){
    const div = document.querySelector("section.section-".concat(id, " > div"));
    const img = document.querySelector("section.section-".concat(id, " > img"));
    const pictureInput = document.querySelector("section.section-".concat(id, " > footer > ul > li:first-child > input"));
    const recipeInput = document.querySelector("section.section-".concat(id, " > footer > ul > li:nth-child(2) > input"));
    pictureInput.classList.remove("preview-selected");
    recipeInput.classList.add("preview-selected");
    img.style.display = "none";
    div.style.display = "inline-block";
}