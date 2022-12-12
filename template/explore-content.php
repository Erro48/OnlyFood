<section class="row filter-section">
    <div class="col-1"></div>
    <div class="col-10">
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
                        <input type="checkbox" onclick="handleClick(this)"/>
                        <?php echo $tag["name"]; ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </section>
    </div>
    <div class="col-1"></div>
</section>
<div class="row">
    <div class="col-12 posts-container">
        <?php foreach($templateParams["posts"] as $post): ?>
            <div class="col-12 single-post-container">
                <article class="post-article article-<?php echo $post["postId"];?>">
                    <section class="recipe-section">
                        <?php $i = 0; foreach($dbh->getIngredientByPost($post["postId"]) as $ingredient): ?>
                            <?php if($i == 0): ?>
                                <div class="row">
                            <?php endif; ?>
                            <?php if($i % 2 == 0 && $i != 0): ?>
                                </div>
                                <div class="row">
                            <?php endif; ?>
                            <div class="col-6">
                                <div class="ingredient-div row" style="border: 3.5px solid #<?php echo $ingredient["color"]; ?>">
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
                    <img src="<?php echo $post["preview"]; ?>" alt="<?php echo $post["description"]; ?>" />
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
                            <p><?php echo $dbh->getLikesByPost($post["postId"])[0]["likes"]; ?></p>
                        </div>
                        <div class="col-1">
                            <input type="button" value="C"/>
                            <p><?php echo $dbh->getCommentsByPost($post["postId"])[0]["comments"]; ?></p>
                        </div>
                        <div class="col-1"></div>
                    </div>
                    <footer>
                        <ul>
                            <li class="col-6">
                                <input type="button" value="Picture" class="preview-selected-left" onclick="showPicture(<?php echo $post['postId'];?>)"/>
                            </li><li class="col-6">
                                <input type="button" value="Recipe" onclick="showRecipe(<?php echo $post['postId'];?>)"/>
                            </li>
                        </ul>
                    </footer>
                </article>
            </div>
        <?php endforeach ?>
    </div>
</div>