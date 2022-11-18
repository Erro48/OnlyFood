<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="./style/baseStyle.css">
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
                        <p class="mb-0 p-2 text-light fw-semibold fs-2">OnlyFood</p>
                    </div>
                    <div class="col-6 d-flex justify-content-end align-items-center">
                        <ul class="nav">
                            <li class="nav-item"><input type="button" value="search"></li>
                            <li class="nav-item"><input type="button" value="notifications"></li>
                        </ul>
                    </div>
                </div>
                
                
            </header>
        </div>
    </div>
    
    <div class="row">
        <!--Main-->
        <div class="col-12 col-md-9">
            <section  class="bg-warning text-center mx-5 rounded-2 mt-2">
                <img src="" alt="" />
                <p>AAAAA</p>
                <footer>
                    <ul class="nav mx-4">
                        <li class="nav-item col-6">
                            <button class="btn btn-light">Picture</button>
                        </li>
                        <li class="nav-item col-6">
                            <button class="btn btn-light">Recipe</button>
                        </li>
                    </ul>
                </footer>
            </section>
            <section  class="bg-warning text-center mx-5 rounded-2 mt-2">
                <img src="" alt="" />
                <p>AAAAA</p>
                <footer>
                    <ul class="nav mx-4 bg-light">
                        <li class="nav-item col-6">
                            <p>Picture</p>
                        </li>
                        <li class="nav-item col-6">
                            <p>Recipe</p>
                        </li>
                    </ul>
                </footer>
            </section>
        </div>

        <!-- Footer -->
        <div class="col-12 col-md-3 mt-2">
            <footer>
                <div class="row">
                    <ul class="nav">
                        <li class="col-3 col-md-12 nav-item text-center">PR</li>
                        <li class="col-3 col-md-12 nav-item text-center">PO</li>
                        <li class="col-3 col-md-12 nav-item text-center">HO</li>
                        <li class="col-3 col-md-12 nav-item text-center">EX</li>
                    </ul>
                </div>
            </footer>
        </div>
    </div>
    
 </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>