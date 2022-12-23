<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php echo $templateParams["title"]; ?></title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous"/>
    <link rel="stylesheet" href="./style/base-style.css"/>
    
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="./script/script.js"></script>

    <?php if(isset($templateParams["style"])): ?>
        <?php foreach($templateParams["style"] as $style): ?>
            <link rel="stylesheet" href="./style/<?php echo $style; ?>"/>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <?php if(isset($templateParams["script"])): ?>
        <?php foreach($templateParams["script"] as $script): ?>
            <script type="text/javascript" src="script/<?php echo $script; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>

<!-- 

header [nome btn btn -> ]
main
footer (nav bar)
 -->

 <div class="container-fluid overflow-hidden p-0">
    <!-- Header -->
    <header class="page-header row align-content-center">
        <div class="col-6">
            <h1>OnlyFood</h1>
        </div>
        <div class="col-6">
            <div class="row align-content-center buttons-container">
                    <div class="col-6">
                        <button onclick="window.location.href='search.php'">
                            <img src="imgs/icons/search.svg" alt="search icon" />
                        </button>
                    </div>
                    <div class="col-6">
                        <button>
                            <img src="imgs/icons/notification.svg" alt="notifications icon" />
                        </button>
                    </div>
                </ul>
            </div>
        </div>
    </header>
    
    <div class="row m-0">
        <!--Main-->
        <div class="col-12 col-md-9 main-container">
            <main>
                <?php
                    if(isset($templateParams["name"])){
                        require($templateParams["name"]);
                    }
                ?>
            </main>
        </div>

        <!-- Footer -->
        <div class="col-12 col-md-3 p-0 footer-container">
            <footer class="page-footer">
                <div class="row">
                    <ul>
                        <li class="col-3 col-md-12">
                            <button onclick="window.location.href='profile.php'" class="<?php if($templateParams["name"] == "profile-content.php"){echo "button-selected";} ?>">
                                <div class="row ps-1 h-100">
                                    <div class="col-12 col-md-4">
                                        <img src="imgs/icons/profile.svg" alt="profile page" />
                                    </div>
                                    <div class="col-md-8">
                                        <p class="<?php if($templateParams["name"] == "profile-content.php"){echo "p-selected";} ?>">Profile</p>
                                    </div>
                                </div>
                            </button>
                        </li><li class="col-3 col-md-12">
                            <button onclick="window.location.href='post.php'" class="<?php if($templateParams["name"] == "create-post.php"){echo "button-selected";} ?>">
                                <div class="row ps-1 h-100">
                                    <div class="col-12 col-md-4">
                                        <img src="imgs/icons/post.svg" alt="post page" />
                                    </div>
                                    <div class="col-md-8">
                                        <p class="<?php if($templateParams["name"] == "create-post.php"){echo "p-selected";} ?>">Post</p>
                                    </div>
                                </div>
                            </button>
                        </li><li class="col-3 col-md-12">
                            <button onclick="window.location.href='index.php'" class="<?php if($templateParams["name"] == "home.php"){echo "button-selected";} ?>">
                                <div class="row ps-1 h-100">
                                    <div class="col-12 col-md-4">
                                        <img src="imgs/icons/home.svg" alt="home page" />
                                    </div>
                                    <div class="col-md-8">
                                        <p class="<?php if($templateParams["name"] == "home.php"){echo "p-selected";} ?>">Home</p>
                                    </div>
                                </div>
                            </button>
                        </li><li class="col-3 col-md-12">
                            <button onclick="window.location.href='explore.php'" class="<?php if($templateParams["name"] == "explore-content.php"){echo "button-selected";} ?>">
                                <div class="row ps-1 h-100">
                                    <div class="col-12 col-md-4">
                                        <img src="imgs/icons/explore.svg" alt="explore page" />
                                    </div>
                                    <div class="col-md-8">
                                        <p class="<?php if($templateParams["name"] == "explore-content.php"){echo "p-selected";} ?>">Explore</p>
                                    </div>
                                </div>
                            </button>
                        </li>
                    </ul>
                </div>
            </footer>
        </div>
    </div>
    
 </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>