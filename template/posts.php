<div class="col-12 posts-container">
    <?php foreach($templateParams["posts"] as $post): ?>
        <div class="col-12 single-post-container">
            <article class="row post-article article-<?php echo $post["postId"];?>">
                <section class="col-12 recipe-section">
                    <?php $i = 0; foreach($dbh->getIngredientByPost($post["postId"]) as $ingredient): ?>
                        <?php if($i == 0): ?>
                            <div class="row">
                        <?php endif; ?>
                        <?php if($i % 2 == 0 && $i != 0): ?>
                            </div>
                            <div class="row">
                        <?php endif; ?>
                        <div class="col-6">
                            <div class="row ingredient-div" style="border: 3.5px solid #<?php echo $ingredient["color"]; ?>">
                                <div class="col-8">
                                    <p><?php echo $ingredient["name"]; ?></p>
                                </div>
                                <div class="col-4" style="border-left: 3.5px solid #<?php echo $ingredient["color"]; ?>; border-top: 3.5px solid #<?php echo $ingredient["color"]; ?>; border-bottom: 3.5px solid #<?php echo $ingredient["color"]; ?>">
                                    <p><?php echo $ingredient["quantity"]." ".$ingredient["acronym"]; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php $i++; endforeach; ?>
                    </div>
                    <h2>How To</h2>
                    <section class="howto-section">
                        <p><?php echo $post["howTo"]; ?></p>
                    </section>
                </section>
                <img class="col-12" src="<?php echo $post["preview"]; ?>" alt="<?php echo $post["description"]; ?>" />
                <div class="row info-container">
                    <div class="col-2">
                        <img src="<?php echo $post["profilePic"]; ?>" alt="Propic of <?php echo $post["username"]; ?>" />
                    </div>
                    <div class="col-8">
                        <p><?php echo $post["owner"]; ?></p>
                        <p><?php echo $post["description"]; ?></p>
                    </div>
                    <div class="col-1 p-0">
                        <div class="row w-100">
                            <button class="action-button like-button" onclick="like(<?php echo $post['postId'];?>)" <?php if($dbh->postAlreadyLikedByUser("carlo61", $post["postId"])){echo "style=\"background-color: var(--primary);\"";} ?>>
                                <img src="imgs/icons/like-button.png" alt="like button icon" />
                            </button>
                        </div>
                        <div class="row w-100">
                            <p class="likes-comments-p" id="like-number-p"><?php
                                $likes = $dbh->getLikesByPost($post["postId"])[0]["likes"] + 999999999;
                                echo printApproximateNumber($likes);
                            ?></p>
                        </div>
                    </div>
                    <div class="col-1 p-0">
                        <div class="row w-100">
                            <button class="action-button comments-button">
                                <img src="imgs/icons/comments-button.png" alt="comments button icon" />
                            </button>
                        </div>
                        <div class="row w-100">
                            <p class="likes-comments-p"><?php
                                $comments = $dbh->getCommentsByPost($post["postId"])[0]["comments"];
                                echo printApproximateNumber($comments); ?></p>
                        </div>
                    </div>
                </div>
                <footer class="row">
                    <div class="col-2"></div>
                    <ul class="col-8 double-selector">
                        <li class="col-6">
                            <input type="button" value="Picture" class="preview-selected-left" onclick="showPicture(<?php echo $post['postId'];?>)"/>
                        </li><li class="col-6">
                            <input type="button" value="Recipe" onclick="showRecipe(<?php echo $post['postId'];?>)"/>
                        </li>
                    </ul>
                    <div class="col-2"></div>
                </footer>
            </article>
        </div>
    <?php endforeach ?>
</div>