<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $templateParams["title"]; ?></title>

    <script src="./script/login-script.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="./style/baseStyle.css">
    <link rel="stylesheet" href="./style/login-style.css">
</head>
<body>

 <div class="container overflow-hidden p-0">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10 col-md-10">
            <main class="vh-100 d-flex justify-content-center align-content-center flex-column  p-0">
                <?php
                    if(isset($templateParams["name"])){
                        require($templateParams["name"]);
                    }
                    ?>
            </main>
        </div>
        <div class="col-1"></div>
    </div>
    
 </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>