<div class="col-12 posts-container">
    <?php if(count($templateParams["posts"]) > 0): ?>
        <?php foreach($templateParams["posts"] as $post): ?>
            <div class="col-12 single-post-container">
                <article id="article-<?php echo $post["postId"];?>" class="row post-article">
                    <h3 class="d-none">Post</h3>
                    <section class="col-12 recipe-section">
                        
                        <h4 class="d-none">Recipe</h4>
                        <section class="ingredients-container">
                            <h5 class="d-none">Ingredients</h5>
                            <?php $i = 0; foreach($dbh->getIngredientByPost($post["postId"]) as $ingredient): ?>
                                <div class="ingredient-div" style="outline-color: #<?php echo $ingredient["color"]; ?>">
                                    <div class="ingredient-name-div">
                                        <?php echo $ingredient["name"]; ?>
                                    </div>
                                    <div class="ingredient-quantity-div" style="outline-color: #<?php echo $ingredient["color"]; ?>">
                                        <?php echo $ingredient["quantity"]." ".$ingredient["acronym"]; ?>
                                    </div>
                                </div>
                            <?php $i++; endforeach; ?>
                        </section>
                        <p class="howto-p">How To</p>
                        <section class="howto-section">
                            <h5 class="d-none">How To</h5>
                            <p><?php echo $post["howTo"]; ?></p>
                        </section>
                    </section>
                    <img class="col-12" src="<?php echo $POST_PIC_DIR.$post["preview"]; ?>" alt="<?php echo $post["description"]; ?>" />
                    <div class="row info-container">
                        <div class="col-2">
                            <a href="./profile.php?user=<?= $post["username"]; ?>">
                                <img src="<?php echo $PROFILE_PIC_DIR.$post["profilePic"]; ?>" alt="Propic of <?php echo $post["username"]; ?>" />
                            </a>
                        </div>
                        <div class="col-6 p-1">
                            <p>
                                <a href="./profile.php?user=<?= $post["username"]; ?>">    
                                    <?php echo $post["owner"]; ?>
                                </a>
                            </p>
                            <p><?php echo $post["description"]; ?></p>
                        </div>
                        <div class="col-2 p-0">
                            <div class="row w-100 justify-content-center m-0">
                                <button class="action-button like-button <?php if($dbh->postAlreadyLikedByUser($_SESSION["username"], $post["postId"])){echo "liked";}else{echo "not-liked";}?>" onclick="like(<?php echo $post['postId'];?>)">
                                    <img src="imgs/icons/like-button.svg" alt="like button icon" />
                                </button>
                            </div>
                            <div class="row w-100 justify-content-center m-0">
                                <p class="likes-comments-p like-number-p">
                                    <?php
                                        $likes = $dbh->getLikesByPost($post["postId"])[0]["likes"];
                                        echo printApproximateNumber($likes);
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-2 p-0">
                            <div class="row w-100 justify-content-center m-0">
                                <button class="action-button comments-button" onclick="window.open('comments.php?post=<?php echo $post["postId"]; ?>', '_blank')">
                                    <img src="imgs/icons/comments-button.svg" alt="comments button icon" />
                                </button>
                            </div>
                            <div class="row w-100 justify-content-center m-0">
                                <p class="likes-comments-p">
                                    <?php
                                        $comments = $dbh->getCommentsCountByPost($post["postId"])[0]["comments"];
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
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if(count($templateParams["posts"]) == 0): ?>
        <p class="w-100 text-center p-3">Nothing to see here...</p>
    <?php endif; ?>
</div>