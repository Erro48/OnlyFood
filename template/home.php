<?php foreach($templateParams["posts"] as $post): ?>
    <section class="section-<?php echo $post["postId"];?>">
        <div>
            <?php $i = 0; foreach($dbh->getIngredientByPost($post["postId"]) as $ingredient): ?>
                <?php if($i == 0): ?>
                    <div class="row">
                <?php endif; ?>
                <?php if($i % 3 == 0 && $i != 0): ?>
                    </div>
                    <div class="row">
                <?php endif; ?>
                <div class="col-4" style="background-color: #<?php echo $ingredient["color"]; ?>">
                    <p>
                        <?php echo $ingredient["name"]; ?>
                    </p><p>
                        <?php echo $ingredient["quantity"]." ".$ingredient["acronym"]; ?>
                    </p>
                </div>
            <?php $i++; endforeach; ?>
            </div>
            <p>How To</p>
            <p><?php echo $post["howTo"]; ?></p>
        </div>
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
                    <input type="button" value="Picture" class="preview-selected" onclick="showPicture(<?php echo $post['postId'];?>)"/>
                </li><li class="col-6">
                    <input type="button" value="Recipe" onclick="showRecipe(<?php echo $post['postId'];?>)"/>
                </li>
            </ul>
        </footer>
    </section>
<?php endforeach ?>