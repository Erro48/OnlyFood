<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php echo $templateParams["title"]; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous"/>
    <link rel="stylesheet" href="./style/base-style.css"/>
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
            <div class="row align-content-center">
                    <div class="col-6">
                        <input type="button">
                    </div>
                    <div class="col-6">
                        <input type="button">
                    </div>
                </ul>
            </div>
        </div>
    </header>
    
    <div class="row">
        <!--Main-->
        <div id="main-container" class="col-12 col-md-9">
            <main>
                <?php
                    if(isset($templateParams["nome"])){
                        require($templateParams["nome"]);
                    }
                ?>
            </main>
        </div>

        <!-- Footer -->
        <div class="col-12 col-md-3">
            <footer class="page-footer">
                <div class="row">
                    <ul>
                        <li class="col-3 col-md-12">
                            <input type="button" value="Profile" onclick="window.location.href='profile.php'" class="<?php if($templateParams["nome"] == "profile-content.php"){echo "input-selected";} ?>"/>
                        </li><li class="col-3 col-md-12">
                            <input type="button" value="Post" onclick="window.location.href='post.php'" class="<?php if($templateParams["nome"] == "post.php"){echo "input-selected";} ?>"/>
                        </li><li class="col-3 col-md-12">
                            <input type="button" value="Home" onclick="window.location.href='index.php'" class="<?php if($templateParams["nome"] == "home.php"){echo "input-selected";} ?>"/>
                        </li><li class="col-3 col-md-12">
                            <input type="button" value="Explore" onclick="window.location.href='explore.php'" class="<?php if($templateParams["nome"] == "explore-content.php"){echo "input-selected";} ?>"/>
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