<?php $profile = $templateParams["profile"]; ?>
<section class="profile-section m-0 pt-3 pb-3 sticky-top"> <!-- profile container -->
    <div class="row mb-4"> <!-- propic-name-followers -->
        <div class="col-1"></div>
        <div class="col-3">
            <img class="profile-pic" src="<?php echo $profile["profilePic"]; ?>" alt="Propic of iginio"/>
        </div>
        <div class="col">
            <div class="row">
                <div class="col-8 mini-box">
                    <p class="username-text m-0"><?php echo $profile["username"]; ?></p>
                </div>
                <div class="col-2 mini-box">
                    <button class="p-2 icon-button">
                        <img src="imgs/icons/settings.png" alt="Settings"/>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col mini-box">
                    <p class="mb-3 name-text"><?php echo $profile["name"]." ".$profile["surname"]; ?></p>
                </div>
                <div class="col-1 mini-box">
                </div>
            </div>
            <div class="row">
                <div class="col-4 mini-box">
                    <div class="follow-container justify-content-center">                    
                        <p class="m-0">Following</p>
                        <p class="m-0"><?php echo $profile["numFollowing"] ?></p>
                    </div>
                </div>
                <div class="col-4 mini-box">
                    <div class="follow-container justify-content-center">                    
                        <p class="m-0">Followers</p>
                        <p class="m-0"><?php echo $profile["numFollower"] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4 justify-content-center">
        <div class="col-11">
            <section class="mx-2 gy-2 row justify-content-center favourite-ingredients-section">  <!-- favourite ingredients -->
                <div class="col-11 ingredients-title-container">
                    <p class="mb-1 ingredients-title"> Favourite ingredients </p>
                </div>
                <?php if (empty($templateParams["favouriteIngredients"])): ?>
                    <p class="mb-0 ms-3"> User has not posted any recipe yet </p>
                <?php else: ?>
                    <?php foreach($templateParams["favouriteIngredients"] as $ingredient): ?>

                        <div class="col-12 ms-3">
                            <div class="row">
                                <div class="col-1 ms-2 ingredient-marker" style="background-color: #<?php echo $ingredient["color"]?> "></div>
                                <div class="col-1"></div>
                                <div class="col-8 ingredient">
                                    <p class="m-2"> <?php echo ucfirst($ingredient["name"]); ?> </p>
                                </div>
                            </div>
                        </div>

                        <?php endforeach ?>
                    <?php endif ?>
            </section>
        </div>
    </div>
</section>

<div class="posts-container">
    <?php
        /* Users posts */
        require_once("template/home.php");
    ?>
</div>
