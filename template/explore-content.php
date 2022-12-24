<section class="row filter-section">
    <div class="col-1"></div>
    <div class="col-10 tags-container">
        <div class="row tag-h2-container">
            <h2>Tags</h2>
        </div>
        <div class="row search-bar-container">
            <label for="search-a-tag-input">
                <span class="d-none">Search a tag</span>
                <input id="search-a-tag-input" type="text" onkeyup="searchTag(this)" placeholder="Search a tag..."/>
            </label>
        </div>
        <section class="row tag-list-container">
            <?php foreach($templateParams["tags"] as $tag): ?>
                <div class="col-12 col-md-6">
                    <label for="<?php echo $tag["name"]; ?>">
                        <input id="<?php echo $tag["name"]; ?>" type="checkbox" onclick="handleClick()"/>
                        <?php echo $tag["name"]; ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </section>
    </div>
    <div class="col-1"></div>
</section>
<section class="row posts-section">
    <?php require('template/posts.php'); ?>
</section>