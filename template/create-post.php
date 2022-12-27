<div class="row">
    <div class="col-1"></div>
    <div class="col-10">
        <form action="">
            <fieldset>
                <legend><h2>General Info</h2></legend>

                <label for="recipe-name">
                    <input type="text" name="recipe-name" id="recipe-name" required>
                    <span>Recipe Description</span>
                </label>

                <label for="recipe-procedure">
                    
                    <textarea name="recipe-procedure" id="recipe-procedure" rows="10"></textarea>
                </label>
            </fieldset>

            <fieldset>
                <legend class="d-none"><h2>Ingredients</h2></legend>
                
                <div class="list-container-secondary ingredients-container p-0 col-12">
                    <h3>Ingredients:</h3>
                    <ul class="ingredients-list p-0" id="ingredients-list">
                        
                    </ul>
                </div>

                <input type="button" value="Add ingredient" class="button-secondary w-100" data-bs-toggle="modal" data-bs-target="#add-ingredient-modal">

                <!-- Add Ingredient Modal -->
                <section class="modal fade" id="add-ingredient-modal" tabindex="-1" aria-labelledby="add-ingredient-modal-label" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <header class="modal-header">
                                <h4 class="modal-title" id="add-ingredient-modal-label">Choose the ingredients</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </header>

                            <section class="modal-body">
                                <input type="search" name="search-ingredient" id="search-ingredient"
                                    onkeyup="search(this)"
                                    aria-label="Search an ingredient"
                                    placeholder="Search an ingredient...">

                                <!-- Dropdown menu -->
                                <div class="search-result-container p-0 col-12">
                                    <ul class="search-result p-0" id="search-result">
                        
                                    </ul>
                                </div>

                                <div class="modal-ingredients-list row w-100 m-auto mt-4 scrollable">

                                </div>
                            </section>

                            <footer class="modal-footer">
                                <button type="button" class="button-primary w-100" data-bs-dismiss="modal" onclick="addIngredients()">Add ingredient</button>
                            </footer>
                        </div>
                    </div>
                </section>
            </fieldset>

            <fieldset>
                <legend class="d-none"><h2>Tags</h2></legend>
                
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
                </label>

            </fieldset>

            <input type="submit" value="Publish Post" class="button-secondary w-100">
        </form>
    </div>
    <div class="col-1"></div>
</div>