<div class="col-12 posts-container">
    <?php foreach($templateParams["posts"] as $post): ?>
        <div class="col-12 single-post-container">
            <article class="row post-article article-<?php echo $post["postId"];?>">
                <section class="col-12 recipe-section">
                    
                    <section class="ingredients-container">
                        <?php $i = 0; foreach($dbh->getIngredientByPost($post["postId"]) as $ingredient): ?>
                            <div class="ingredient-div" style="outline: 3.5px solid #<?php echo $ingredient["color"]; ?>">
                                <div class="ingredient-name-div">
                                    <p><?php echo $ingredient["name"]; ?></p>
                                </div>
                                <div class="ingredient-quantity-div" style="outline: 3.5px solid #<?php echo $ingredient["color"]; ?>">
                                    <p><?php echo $ingredient["quantity"]." ".$ingredient["acronym"]; ?></p>
                                </div>
                            </div>
                        <?php $i++; endforeach; ?>
                    </section>
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
                    <div class="col-6 p-1">
                        <p><?php echo $post["owner"]; ?></p>
                        <p><?php echo $post["description"]; ?></p>
                    </div>
                    <div class="col-2 p-0">
                        <div class="row w-100 justify-content-center m-0">
                            <button class="action-button like-button <?php if($dbh->postAlreadyLikedByUser("carlo61", $post["postId"])){echo "liked";}else{echo "not-liked";}?>" onclick="like(<?php echo $post['postId'];?>)">
                                <img src="imgs/icons/like-button.svg" alt="like button icon" />
                            </button>
                        </div>
                        <div class="row w-100 justify-content-center m-0">
                            <p class="likes-comments-p" id="like-number-p">
                                <?php
                                    $likes = $dbh->getLikesByPost($post["postId"])[0]["likes"];
                                    echo printApproximateNumber($likes);
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-2 p-0">
                        <div class="row w-100 justify-content-center m-0">
                            <button class="action-button comments-button">
                                <img src="imgs/icons/comments-button.svg" alt="comments button icon" />
                            </button>
                        </div>
                        <div class="row w-100 justify-content-center m-0">
                            <p class="likes-comments-p">
                                <?php
                                    $comments = $dbh->getCommentsByPost($post["postId"])[0]["comments"];
                                    echo printApproximateNumber($comments);
                                ?>
                            </p>
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