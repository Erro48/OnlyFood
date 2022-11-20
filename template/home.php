<div class="col-12 col-md-9">
    <?php foreach($templateParams["posts"] as $post): ?>
        <section>
            <img src="<?php echo $post["preview"]; ?>" alt="<?php echo $post["preview"]; ?>" />
            <div class="row">
                <div class="col-2">
                    <img src="<?php echo $post["profilePic"]; ?>" alt="Propic of <?php echo $post["username"]; ?>" />
                </div>
                <div class="col-7">
                    <p><?php echo $post["owner"]; ?></p>
                    <p><?php echo $post["description"]; ?></p>
                </div>
                <div class="col-1">
                    <input type="button" value="L"/>
                </div>
                <div class="col-1">
                    <input type="button" value="C"/>
                </div>
                <div class="col-1"></div>
            </div>
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