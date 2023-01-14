<?php $profile = $templateParams["profile"]; ?>
<div class="row">
    <div class="col-md-1"></div>
    <section class="profile-section m-0 col col-md-10 pt-3 pb-2 profile-position"> 
        <h2 class="d-none">Profile info</h2>
        <div class="row"> <!-- propic-name-followers -->
            <div class="col-1"></div>
            <div class="col-3 col-md-2">
                <img class="profile-pic" src="<?php echo $PROFILE_PIC_DIR.$profile["profilePic"]; ?>" alt="Propic of <?php echo $profile["username"]; ?>"/>
            </div>
            <div class="col-7 col-md-8">
                <div class="row">
                    <div class="col-10 col-md-8 mini-box">
                        <p class="username-text m-0 text-truncate"><?php echo $profile["username"]; ?></p>
                    </div>
                    <?php if (!isset($_GET["user"])): ?>
                    <div class="col-2 p-0 mini-box d-flex justify-content-end">
                        <button class="p-2 icon-button" onclick="logout()">
                            <img src="imgs/icons/logout.svg" alt="Logout" />
                        </button>
                    </div>
                    <?php elseif (!$templateParams["followed"]): ?>
                    <div class="col-2 p-0 mini-box d-flex justify-content-end">
                        <button id="follow-button" class="p-2 icon-button hideable" data-current-page="true" onclick="follow('<?php echo $_GET['user']?>', this)">
                            <img src="imgs/icons/user-follow.svg" alt="Follow <?php echo $_GET['user'] ?>" />
                        </button>
                    </div>
                    <div class="col-2 p-0 mini-box d-flex justify-content-end d-none">
                        <button id="unfollow-button" class="p-2 icon-button hideable" data-current-page="true" onclick="unfollow('<?php echo $_GET['user']?>', this)">
                            <img src="imgs/icons/user-unfollow.svg" alt="Unfollow <?php echo $_GET['user'] ?>" />
                        </button>
                    </div>
                    <?php else: ?>
                    <div class="col-2 p-0 mini-box d-flex justify-content-end d-none">
                        <button id="follow-button" class="p-2 icon-button hideable" data-current-page="true" onclick="follow('<?php echo $_GET['user']?>', this)">
                            <img src="imgs/icons/user-follow.svg" alt="Follow <?php echo $_GET['user'] ?>" />
                        </button>
                    </div>
                    <div class="col-2 p-0 mini-box d-flex justify-content-end">
                        <button id="unfollow-button" class="p-2 icon-button hideable" data-current-page="true" onclick="unfollow('<?php echo $_GET['user']?>', this)">
                            <img src="imgs/icons/user-unfollow.svg" alt="Unfollow <?php echo $_GET['user'] ?>" />
                        </button>
                    </div>
                    <?php endif ?>
                    <div class="col-md-2"></div>
                </div>

                <!-- Followed / Follower -->
                <section class="modal fade" id="followModal" tabindex="-1" aria-labelledby="followModal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <header class="modal-header">
                                <h1 class="modal-title fs-5" id="followModalTitle">Following</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </header>
                            <section class="modal-body">
                                <div class="modal-list row w-100 m-auto mt-4 scrollable" id="modal-ingredients-list">
                                    
                                </div>
                            </section>
                        </div>
                    </div>
                </section>

                <div class="row">
                    <div class="col mini-box">
                        <p class="mb-3 text-truncate name-text"><?php echo $profile["name"]." ".$profile["surname"]; ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-md-4 mini-box">
                        <button type="button"
                            class="follow-container justify-content-center hideable"
                            data-bs-toggle="modal" data-bs-target="#followModal"
                            onclick="loadFollowModal(
                                '<?= isset($_GET['user']) ? $_GET['user'] : $_SESSION['username'] ?>',
                                '<?= $_SESSION['username'] ?>',
                                InteractionType.FOLLOWING)
                            ">

                            <span class="m-0">Following</span>
                            <span class="m-0" id="num-following"><?php echo $profile["numFollowing"] ?></span>
                        </button>
                    </div>
                    <div class="col-md-2 d-none d-md-block"></div>
                    <div class="col-6 col-md-4 mini-box">
                        <button type="button"
                            class="follow-container justify-content-center hideable"
                            data-bs-toggle="modal" data-bs-target="#followModal"
                            onclick="loadFollowModal(
                                '<?= isset($_GET['user']) ? $_GET['user'] : $_SESSION['username'] ?>',
                                '<?= $_SESSION['username'] ?>',
                                InteractionType.FOLLOWER)
                            ">

                            <span class="m-0">Followers</span>
                            <span class="m-0" id="num-follower"><?php echo $profile["numFollower"] ?></span>
                        </button>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
            <div class="col-1"></div>
        </div>
        <div class="row mt-4 justify-content-center hideable">
            <div class="col-11">
                <section class="mx-2 mb-2 gy-2 row justify-content-center favourite-ingredients-section hideable">  <!-- favourite ingredients -->
                    <div class="col-11 ingredients-title-container">
                        <p class="mb-1 ingredients-title"> Favourite ingredient<?php echo $NUM_FAVOURITE_INGREDIENTS > 1 ? "s" : "" ?></p>
                    </div>
                    <?php if (empty($templateParams["favouriteIngredients"])): ?>
                        <?php for ($i=0; $i<$NUM_FAVOURITE_INGREDIENTS; $i++): ?>
                            <div class="col-12 row mt-2">
                                <div class="col-1 p-0 ingredient-marker empty"></div>
                                <div class="col-11 ingredient">
                                    <p class="m-2 text-truncate"> No ingredient yet </p>
                                </div>
                            </div>
                        <?php endfor ?>
                    <?php else: ?>
                        <?php foreach($templateParams["favouriteIngredients"] as $ingredient): ?>
                            <div class="col-12 row mt-2">
                                <div class="col-1 p-0 ingredient-marker" style="background-color: #<?php echo $ingredient["color"]?> "></div>
                                <div class="col-11 ingredient">
                                    <p class="m-2 text-truncate"> <?php echo ucfirst($ingredient["name"]); ?> </p>
                                </div>
                            </div>
                            <?php endforeach ?>
                            <?php if (count($templateParams["favouriteIngredients"]) != $NUM_FAVOURITE_INGREDIENTS):
                                    for ($i=0; $i<$NUM_FAVOURITE_INGREDIENTS - count($templateParams["favouriteIngredients"]); $i++):
                                         ?>
                                        <div class="col-12 row mt-2">
                                            <div class="col-1 p-0 ingredient-marker empty"></div>
                                            <div class="col-11 ingredient">
                                                <p class="m-2 text-truncate"> No ingredient yet </p>
                                            </div>
                                        </div>
                                <?php endfor;
                                endif; ?>
                        <?php endif ?>
                </section>
            </div>
        </div>
    </section>
    <div class="col-md-1"></div>
</div>
<section class="row posts-section"> <!-- posts container -->
    <h2 class="d-none">User posts</h2>
    <div id="posts-container-div" class="p-0">
        <?php
            /* Users posts */
            require_once("template/posts.php");
        ?>
    </div>
</section>