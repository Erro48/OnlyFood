<section class="row filter-section">
    <div class="col-1"></div>
    <div class="col-10 tags-container">
        <div class="row tag-h2-container">
            <h2>Tags</h2>
        </div>
        <div class="row search-bar-container">
            <input type="text" placeholder="Search a tag"/>
        </div>
        <section class="row tag-list-container">
            <?php foreach($templateParams["tags"] as $tag): ?>
                <div class="col-12">
                    <label>
                        <input type="checkbox" onclick="handleClick()"/>
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