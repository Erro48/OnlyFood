<div class="row">
    <div class="col-1"></div>
    <div class="col-10">
        <form action="" class="row gy-2 gy-md-5">

            <div class="col-12 col-md-6">
                <fieldset id="info-fieldset">
                    <legend class="d-none"><h2>General Info</h2></legend>

                    <label for="recipe-name">
                        <input type="text" name="recipe-name" id="recipe-name" required>
                        <span>Recipe Name</span>
                    </label>

                    <label for="recipe-procedure">
                        
                        <textarea name="recipe-procedure" id="recipe-procedure" rows="8" placeholder="How to..."></textarea>
                    </label>
                </fieldset>

                <fieldset id="ingredients-fieldset">
                    <legend class="d-none"><h2>Ingredients</h2></legend>
                    
                    <div class="list-container-secondary ingredients-container col-12">
                        <h3>Ingredients</h3>
                        <ul class="result-list p-0 row m-0" id="ingredients-list">
                            
                        </ul>
                    </div>

                    <input type="button" value="Add ingredient" class="button-secondary w-100" data-bs-toggle="modal" data-bs-target="#add-ingredient-modal" onclick="loadModal(ModalsType.INGREDIENTS, ingredientsCallback)">

                    <!-- Add Ingredient Modal -->
                    <section class="modal fade" id="add-ingredient-modal" tabindex="-1" aria-labelledby="add-ingredient-modal-label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <header class="modal-header">
                                    <h4 class="modal-title" id="add-ingredient-modal-label">Choose the ingredients</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </header>

                                <section class="modal-body">
                                    <input type="search" name="search-ingredient" id="search-ingredients"
                                        onkeyup="search(this)"
                                        aria-label="Search an ingredient"
                                        placeholder="Search an ingredient...">

                                    <!-- Dropdown menu -->
                                    <div class="search-result-container p-0 col-12">
                                        <ul class="search-result p-0" id="search-ingredients-result">
                            
                                        </ul>
                                    </div>

                                    <div class="modal-list row w-100 m-auto mt-4 scrollable" id="modal-ingredients-list">

                                    </div>
                                </section>

                                <footer class="modal-footer">
                                    <button type="button" class="button-primary w-100" data-bs-dismiss="modal" onclick="addIngredients()">Add ingredient</button>
                                </footer>
                            </div>
                        </div>
                    </section>
                </fieldset>

                <fieldset id="tags-fieldset">
                    <legend class="d-none"><h2>Tags</h2></legend>
                    
                    <div class="list-container-secondary tags-container col-12">
                        <h3>Tags</h3>
                        <ul class="result-list p-0 row m-0" id="tags-list">
                            
                        </ul>
                    </div>

                    <input type="button" value="Add tag" class="button-secondary w-100" data-bs-toggle="modal" data-bs-target="#add-tag-modal" onclick="loadModal(ModalsType.TAGS, tagsCallback)">

                    <!-- Add Tags Modal -->
                    <section class="modal fade" id="add-tag-modal" tabindex="-1" aria-labelledby="add-tag-modal-label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <header class="modal-header">
                                    <h4 class="modal-title" id="add-tag-modal-label">Choose the tags</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </header>

                                <section class="modal-body">
                                    <input type="search" name="search-tag" id="search-tags"
                                        onkeyup="searchTag(this)"
                                        aria-label="Search a tag"
                                        placeholder="Search a tag...">

                                    <!-- Dropdown menu -->
                                    <div class="search-result-container p-0 col-12">
                                        <ul class="search-result p-0" id="search-tags-result">
                            
                                        </ul>
                                    </div>

                                    <div class="modal-list row w-100 m-auto mt-4 scrollable" id="modal-tags-list">

                                    </div>
                                </section>

                                <footer class="modal-footer">
                                    <button type="button" class="button-primary w-100" data-bs-dismiss="modal" onclick="addTags()">Add tag</button>
                                </footer>
                            </div>
                        </div>
                    </section>
                </fieldset>
            </div>
            <div class="col-12 col-md-6">
                <fieldset id="image-fieldset" class="d-flex flex-column align-items-center">
                    <legend class="d-none"><h2>Recipe Preview</h2></legend>
                    <label for="post-preview" class="row w-100">
                        <input type="file" class="d-none" name="post-preview" id="post-preview" onchange="profilePicPreview(this)">
                        <span class="col-12 p-0">
                            <span class="row m-0 align-items-center">
                                <span class="col-3 col-md-2 p-0">
                                    <img class="add-icon" src="./imgs/icons/plus.svg" alt="Add image" />
                                </span>
                                <span class="col-9 col-md-10 image-name">No preview image</span>
                            </span>
                        </span>
                    </label>

                    <div class="d-none mt-3 mt-md-4" id="preview-container">
                        <img src="./imgs/propics/default.png" alt="Recipe preview">
                    </div>

                </fieldset>
            </div>

            <input type="submit" value="Publish Post" class="button-primary w-100 col-12 my-3">
        </form>
    </div>
    <div class="col-1"></div>
</div>