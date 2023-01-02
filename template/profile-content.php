<?php $profile = $templateParams["profile"]; ?>
<div class="row">
    <div class="col-md-1"></div>
    <section class="profile-section m-0 col col-md-10 pt-3 pb-3 profile-position"> <!-- profile container -->
        <div class="row mb-4"> <!-- propic-name-followers -->
            <div class="col-1"></div>
            <div class="col-3 col-md-2">
                <img class="profile-pic" src="<?php echo $PROFILE_PIC_DIR.$profile["profilePic"]; ?>" alt="Propic of <?php echo $profile["username"]; ?>"/>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col-10 col-md-8 mini-box">
                        <p class="username-text m-0"><?php echo $profile["username"]; ?></p>
                    </div>
                    <?php if (!isset($_GET["user"])): ?>
                    <div class="col-2 mini-box d-flex justify-content-end">
                        <button class="p-2 icon-button hideable" onclick="logout()">
                            <img src="imgs/icons/logout.svg" alt="Logout" />
                        </button>
                    </div>
                    <?php elseif (!$templateParams["followed"]): ?>
                    <div id="follow-button" class="col-2 mini-box d-flex justify-content-end">
                        <button class="p-2 icon-button hideable" onclick="follow('<?php echo $_GET['user']?>')">
                            <img src="imgs/icons/user-follow.svg" alt="Follow <?php echo $_GET['user'] ?>" />
                        </button>
                    </div>
                    <div id="unfollow-button" class="col-2 mini-box d-flex justify-content-end d-none">
                        <button class="p-2 icon-button hideable" onclick="unfollow('<?php echo $_GET['user']?>')">
                            <img src="imgs/icons/user-unfollow.svg" alt="Unfollow <?php echo $_GET['user'] ?>" />
                        </button>
                    </div>
                    <?php else: ?>
                    <div id="follow-button" class="col-2 mini-box d-flex justify-content-end d-none">
                        <button class="p-2 icon-button hideable" onclick="follow('<?php echo $_GET['user']?>')">
                            <img src="imgs/icons/user-follow.svg" alt="Follow <?php echo $_GET['user'] ?>" />
                        </button>
                    </div>
                    <div id="unfollow-button" class="col-2 mini-box d-flex justify-content-end">
                        <button class="p-2 icon-button hideable" onclick="unfollow('<?php echo $_GET['user']?>')">
                            <img src="imgs/icons/user-unfollow.svg" alt="Unfollow <?php echo $_GET['user'] ?>" />
                        </button>
                    </div>
                    <?php endif ?>
                    <div class="col-md-2"></div>
                </div>
                <div class="row">
                    <div class="col mini-box">
                        <p class="mb-3 name-text"><?php echo $profile["name"]." ".$profile["surname"]; ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-md-4 mini-box">
                        <div class="follow-container justify-content-center hideable">                    
                            <p class="m-0">Following</p>
                            <p class="m-0"><?php echo $profile["numFollowing"] ?></p>
                        </div>
                    </div>
                    <div class="col-md-2 d-none d-md-block"></div>
                    <div class="col-6 col-md-4 mini-box">
                        <div class="follow-container justify-content-center hideable">                    
                            <p class="m-0">Followers</p>
                            <p id="num-follower" class="m-0"><?php echo $profile["numFollower"] ?></p>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
            <div class="col-1"></div>
        </div>
        <div class="row mt-4 justify-content-center">
            <div class="col-11">
                <section class="mx-2 gy-2 row justify-content-center favourite-ingredients-section hideable">  <!-- favourite ingredients -->
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
                                    <div class="col-10 ms-1 ingredient">
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
    <div class="col-md-1"></div>
</div>
<section class="row posts-section"> <!-- posts container -->
    <h2 class="mt-1">Posts</h2>
    <div id="posts-container-div" class="p-0">
        <?php
            /* Users posts */
            require_once("template/posts.php");
        ?>
    </div>
</section>