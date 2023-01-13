<div class="row">
    <div class="col-12 search-sections-container">
        
        <!-- Toggle mode -->
        <section class="toggle">
            <div class="row init-row">
                <div class="col-3 col-md-4"></div>
                <div class="col col-md-4">
                    <ul class="row selector">
                        <li class="col-6">
                            <button id="users-button" class="selected" onclick="switchSearchMode()">
                                Users
                            </button>
                        </li>
                        <li class="col-6">
                            <button id="recipes-button" onclick="switchSearchMode()">
                                Recipes
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="col-3 col-md-4"></div>
            </div>
        </section>
    
        <!-- Recipes search -->
        <section id="recipe-search" class="search hidden">
            <div class="row">
                <div class="col-1 col-md-3"></div>
                <div class="col">
                    <input class="ps-3 pe-2" type="search" onkeyup="searchData(this)" placeholder="Search recipe here..." />
                </div>
                <div class="col-1 col-md-3"></div>
            </div>
            
            <!--
            <div id="simple-ingredients-list">
            </div>

            <button class="button-primary w-100" data-bs-toggle="modal" data-bs-target="#add-ingredient-modal" onclick="loadModal(ModalsType.SIMPLE_INGREDIENTS, simpleIngredientsCallback)">
                Add ingredient
            </button>
            -->
            
            <section class="modal fade" id="add-ingredient-modal" tabindex="-1" aria-labelledby="add-ingredient-modal-label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <header class="modal-header">
                            <h4 class="modal-title" id="add-ingredient-modal-label">Choose the ingredients</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </header>

                        <section class="modal-body">
                            <div class="row">
                                <label for="search-simple-ingredients" class="h-auto">
                                    <input 
                                        type="search"
                                        name="search-simple-ingredient"
                                        id="search-simple-ingredients"
                                        class="search-modal"
                                        onkeyup="searchModal(this)"
                                        aria-label="Search an ingredient"
                                        placeholder="Search an ingredient...">
                                    <span class="d-none">Search an ingredient</span>
                                </label>
                            </div>

                            <!-- Dropdown menu -->
                            <div class="search-result-container p-0 col-12">
                                <ul class="search-result p-0" id="search-simple-ingredients-result">
                                </ul>
                            </div>
                            <div class="modal-list row w-100 m-auto mt-4 scrollable" id="modal-simple-ingredients-list">
                            </div>
                        </section>
                        <footer class="modal-footer">
                            <button type="button" class="button-primary w-100" data-bs-dismiss="modal" onclick="addSimpleIngredients()">Add ingredient</button>
                        </footer>
                    </div>
                </div>
            </section>
        </section>

        <!-- Users search -->
        <section id="users-search" class="search" >
            <div class="row">
                <div class="col-1 col-md-3"></div>
                <div class="col">
                    <input class="ps-3 pe-2" type="search" onkeyup="searchData(this)" placeholder="Search here..." />
                </div>
                <div class="col-1 col-md-3"></div>
            </div>
        </section>

        <!-- Search output -->
        <section class="output">
            <div class="row">
                <div class="col-1 col-md-3"></div>
                <div id="output-list" class="col col-md-6">
                </div>
                <div class="col-1"></div>
            </div>
        </section>
    </div>
</div>
