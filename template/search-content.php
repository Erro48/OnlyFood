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
                    <input class="ps-3 pe-2" type="search" onkeyup="search(this)" placeholder="Search recipe here..." />
                </div>
                <div class="col-1 col-md-3"></div>
            </div>
        </section>

        <!-- Users search -->
        <section id="users-search" class="search" >
            <div class="row">
                <div class="col-1 col-md-3"></div>
                <div class="col">
                    <input class="ps-3 pe-2" type="search" onkeyup="search(this)" placeholder="Search here..." />
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
