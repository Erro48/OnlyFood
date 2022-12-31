<?php if($templateParams["postId"] != -1): ?>
    <section id="post-info-section">
        <article id="recipe-article" class="row">
            <div class="col-3 p-0 d-flex align-items-center">
                <img src="<?php echo $templateParams["postDetails"][0]["preview"]; ?>" alt="Recipe image"/>
            </div>
            <div class="col-9 row ms-2 align-items-center">
                <p id="owner-username"><?php echo $templateParams["postDetails"][0]["owner"]; ?></p>
                <p><?php echo $templateParams["postDetails"][0]["description"]; ?></p>
            </div>
        </article>
    </section>
    <section id="comments-section">
        <?php foreach($templateParams["comments"] as $comment): ?>
            <div class="single-comment-container">
                <article id="comment-<?php echo $comment["commentId"] ?>" class="row comment-article">
                    <div class="col-3 p-0 propic-container">
                        <img src="<?php echo $PROFILE_PIC_DIR.$comment["profilePic"]; ?>" alt="Propic of <?php echo $comment["user"]; ?>" />
                    </div>
                    <div class="col-9 row p-0 ms-2 align-items-center">
                        <div class="col-12 row pt-2">
                            <p class="col-6"><?php echo $comment["user"]; ?></p>
                            <p class="col-6 d-flex justify-content-end"><?php echo datetimeToString($comment["date"]); ?></p>
                        </div>
                        <p class="col-12"><?php echo $comment["content"]; ?></p>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>
    </section>
    <section id="write-comment-section" class="row">
        <div id="comment-input-container" class="col-11">
            <label for="comment-input">
                <input id="comment-input" type="text" name="comment-text" placeholder="Write a comment..." />
                <span class="d-none">Write a comment</span>
            </label>
        </div>
        <div class="col-1 p-0 d-flex align-items-center">
            <input id="post-comment-input" class="col-2" type="submit" value="" onclick="sendComment(<?php echo $templateParams['postId'] ?>, document.querySelector('input#comment-input').value)" />
        </div>
    </section>
<?php endif; if($templateParams["postId"] == -1): ?>
    <p>Errore</p>
<?php endif; ?>