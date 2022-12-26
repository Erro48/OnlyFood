<?php if($templateParams["postId"] != -1): ?>
    <section class="row">
        <div class="col-1"></div>
        <div id="recipe-div" class="col-10 row">
            <div class="col-4 p-0">
                <img src="<?php echo $templateParams["postDetails"][0]["preview"]; ?>" alt="Recipe image"/>
            </div>
            <div class="col-8 row ms-2 align-items-center">
                <p><?php echo $templateParams["postDetails"][0]["owner"]; ?></p>
                <p><?php echo $templateParams["postDetails"][0]["description"]; ?></p>
            </div>
        </div>
        <div class="col-1"></div>
    </section>
    <section id="comments-section" class="row p-0 m-0">
        <?php foreach($templateParams["comments"] as $comment): ?>
            <div class="col-2"></div>
            <article class="col-8 row comment-article">
                <div class="col-4 p-0 propic-container">
                    <img src="<?php echo $PROFILE_PIC_DIR.$comment["profilePic"];; ?>" alt="Recipe image" />
                </div>
                <div class="col-8 row ms-2 align-items-center">
                    <p class="col-6"><?php echo $comment["user"] ?></p>
                    <p class="col-6"><?php echo $comment["date"] ?></p>
                    <p class="col-12"><?php echo $comment["content"] ?></p>
                </div>
            </article>
            <div class="col-2"></div>
        <?php endforeach; ?>
    </section>
    <section id="write-comment-section" class="row">
        <form action="" method="POST">
            <label class="col-10">
                <input type="text" name="comment-text" placeholder="Write a comment..." />
            </label>
            <input class="col-2" type="submit" value="" />
        </form>
    </section>
    <?php endif; if($templateParams["postId"] == -1): ?>
    <p>Errore</p>
<?php endif; ?>