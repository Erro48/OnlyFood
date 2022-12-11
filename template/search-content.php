<!-- Switch search mode -->
<section>
    <div class="row mt-4">
        <div class="col-3 col-md-4"></div>
        <div class="col col-md-4">
            <ul class="row selector">
                <li class="col-6">
                    <button class="selected">
                        Users
                    </button>
                </li>
                <li class="col-6">
                    <button>
                        Recipes
                    </button>
                </li>
            </ul>
        </div>
        <div class="col-3 col-md-4"></div>
    </div>
    <div class="row mb-4 mt-2">
        <div class="col-1 col-md-3"></div>
        <div class="col">
            <input class="ps-3 pe-2" type="search" onkeyup="search(this)" placeholder="Search here..." />
        </div>
        <div class="col-1 col-md-3"></div>
    </div>
</section>

<!-- Search output -->
<section class="output mt-5">
    <div class="row">
        <div class="col-1 col-md-3"></div>
        <div id="output-list" class="col col-md-6">
        </div>
        <div class="col-1"></div>
    </div>
</section>