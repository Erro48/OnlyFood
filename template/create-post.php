<div class="row">
    <div class="col-1"></div>
    <div class="col-10">
        <form action="">
            <fieldset>
                <legend><h2>General Info</h2></legend>

                <label for="recipe-name">
                    <input type="text" name="recipe-name" id="recipe-name">
                    <p class="ps-3 m-0">Recipe Description</p>
                </label>

                <label for="recipe-procedure">
                    <textarea name="recipe-procedure" id="recipe-procedure" rows="10"></textarea>
                </label>
            </fieldset>

            <fieldset>
                <legend><h2>Ingredients</h2></legend>

                <div class="list-container-secondary ingredients-container p-0 col-12">
                    <h3>Ingredients:</h3>
                    <ul class="ingredients-list p-0" id="ingredients-list">
                        <li class="pill ingredient-pill">Rice</li>
                    </ul>
                </div>

                <input type="button" value="Add ingredient" class="button-secondary w-100">
            </fieldset>

            <fieldset>
                <legend><h2>Tags</h2></legend>

                <div class="list-container-secondary tags-container p-0 col-12">
                    <h3>Tags:</h3>
                    <ul class="tags-list p-0" id="tags-list">
                        <li class="pill tag-pill">
                            <span class="pill tag-pill">Launch</span>
                            <button class="icon delete-icon">-</button>
                        </li>

                        <li class="pill tag-pill">
                            <span class="pill tag-pill">Vegan</span>
                            <button class="icon delete-icon">-</button>
                        </li>
                    </ul>
                </div>

                <input type="button" value="Add tag" class="button-secondary w-100">
            </fieldset>

            <fieldset>
                <legend><h2>Images</h2></legend>
                <label for="post-preview">
                    <input type="file" name="post-preview" id="post-preview">
                    <p>Ciao</p>
                </label>

            </fieldset>

            <input type="submit" value="Publish Post" class="button-secondary w-100">
        </form>
    </div>
    <div class="col-1"></div>
</div>