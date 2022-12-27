<?php if($templateParams["postId"] != -1): ?>
    <section id="post-info-section">
        <article id="recipe-article" class="row">
            <div class="col-4 p-0 d-flex align-items-center">
                <img src="<?php echo $templateParams["postDetails"][0]["preview"]; ?>" alt="Recipe image"/>
            </div>
            <div class="col-8 row ms-2 align-items-center">
                <p><?php echo $templateParams["postDetails"][0]["owner"]; ?></p>
                <p><?php echo $templateParams["postDetails"][0]["description"]; ?></p>
            </div>
        </article>
    </section>
    <section id="comments-section">
        <?php foreach($templateParams["comments"] as $comment): ?>
            <div class="single-comment-container">
                <article class="row comment-article">
                    <div class="col-4 p-0 propic-container">
                        <img src="<?php echo $PROFILE_PIC_DIR.$comment["profilePic"];; ?>" alt="Recipe image" />
                    </div>
                    <div class="col-8 row ms-2 align-items-center">
                        <p class="col-6"><?php echo $comment["user"] ?></p>
                        <p class="col-6"><?php echo $comment["date"] ?></p>
                        <p class="col-12"><?php echo $comment["content"] ?></p>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>
    </section>
    <section id="write-comment-section" class="row">
        <form class="col-12 row" action="" method="POST">
            <div class="col-10">
                <label for="comment-input">
                    <input id="comment-input" type="text" name="comment-text" placeholder="Write a comment..." />
                </label>
            </div>
            <input class="col-2" type="submit" value="" />
        </form>
    </section>
<?php endif; if($templateParams["postId"] == -1): ?>
    <p>Errore</p>
<?php endif; ?>