<div class="col-12 col-md-9">
    <?php foreach($templateParams["posts"] as $post): ?>
        <section>
            <img src="<?php echo $post["preview"]; ?>" alt="<?php echo $post["preview"]; ?>" />
            <p><?php echo $post["owner"]; ?></p>
            <p><?php echo $post["date"]; ?></p>
            <p><?php echo $post["description"]; ?></p>
            <p><?php echo $post["howTo"]; ?></p>
            <footer>
                <ul>
                    <li class="col-6">
                        <button>Picture</button>
                    </li><li class="col-6">
                        <button>Recipe</button>
                    </li>
                </ul>
            </footer>
        </section>
    <?php endforeach ?>
</div>