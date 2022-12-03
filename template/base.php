<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $templateParams["title"]; ?></title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="./style/baseStyle.css">
    <?php if (isset($templateParams["style"])) foreach($templateParams["style"] as $stylesheet): ?>
        <link rel="stylesheet" href="./style/<?php echo $stylesheet; ?>">
    <?php endforeach; ?>    
    <?php if(isset($templateParams["script"])): ?>
        <script type="text/javascript" src="script/<?php echo $templateParams["script"]; ?>"></script>
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
    <div class="row">
        <div class="col-12">
            <header>
                <div class="row">
                    <div class="col-6">
                        <p>OnlyFood</p>
                    </div>
                    <div class="col-6">
                        <ul>
                            <li>
                                <input type="button"/>
                            </li><li>
                                <input type="button"/>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>
        </div>
    </div>
    
    <div class="row">
        <!--Main-->
        <div class="col-12 col-md-9">
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
            <footer>
                <div class="row">
                    <ul>
                        <li class="col-3 col-md-12">
                            <input type="button" value="Profile" onclick="window.location.href='profile.php'" class="<?php if($templateParams["nome"] == "profile.php"){echo "input-selected";} ?>"/>
                        </li><li class="col-3 col-md-12">
                            <input type="button" value="Post" onclick="window.location.href='post.php'" class="<?php if($templateParams["nome"] == "post.php"){echo "input-selected";} ?>"/>
                        </li><li class="col-3 col-md-12">
                            <input type="button" value="Home" onclick="window.location.href='home.php'" class="<?php if($templateParams["nome"] == "home.php"){echo "input-selected";} ?>"/>
                        </li><li class="col-3 col-md-12">
                            <input type="button" value="Explore" onclick="window.location.href='explore.php'" class="<?php if($templateParams["nome"] == "explore.php"){echo "input-selected";} ?>"/>
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