<?php
require_once './bootstrap.php';

if (isset($_POST['user']) && isset($_POST['password'])) {
    $user = $_POST['user'];
    $password = $_POST['password'];
    if ($dbh->userAlreadyRegistered($user) && verifyUserPassword($user, $password)) {
        $_SESSION['username'] = $user;
        header('Location: ./index.php');
    } else {
        $error = "Username or password incorrect.";
    }
}

function verifyUserPassword($user, $password) {
    global $dbh;
    $password_hash = $dbh->getUserPassword($user);
    return password_verify($password, $password_hash);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>OnlyFood - Login</title>

        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <script src="./script/script.js"></script>
        <script src="./script/login-script.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link rel="stylesheet" href="./style/base-style.css">
        <link rel="stylesheet" href="./style/login-style.css">
    </head>
    <body>
        <div class="container-fluid overflow-hidden p-0">
            <div class="row">
                <div class="col-1 d-md-none"></div>
                <div class="col-10 col-md-6 row vh-100 align-content-center justify-content-center mx-0">
                    <header class="row text-center mb-5">
                        <h1>Welcome back Chef</h1>
                    </header>
                
                    <main class="d-flex justify-content-center align-content-center flex-column p-0 p-md-5 login-main">
                        <section class="row login-section">
                            <h2 class="d-none">Login</h2>
                            <div class="d-none d-md-block col-md-2"></div>
                        
                            <div class="col-12 col-md-8">
                                <?php if (isset($error)): ?>
                                    <div class="row alert error-alert fade-out login-alert" role="alert">
                                        <div class="col-11">
                                            <?php
                                                if (isset($error)) {
                                                    echo $error;
                                                }
                                            ?>
                                        </div>
                                        <div class="col-1">
                                            <button type="button" class="btn-close" aria-label="Close" onclick="forceCloseAlert(this.parentNode.parentNode)"></button>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <form action="./login.php" method="post" class="m-0 mt-4 d-flex flex-column justify-content-center">

                                    <fieldset class="p-0 m-0 col-12">
                                        <legend class="text-center mt-4 mb-1">Sign in to continue</legend>

                                        <label for="user-input" class="p-0 mb-2">
                                            <input type="text" name="user" id="user-input" required>
                                            <span>Username</span>
                                        </label>
                                    
                                        <label for="user-password" class="p-0">
                                            <input type="password" name="password" id="user-password" required>
                                            <span>Password</span>
                                        </label>

                                    </fieldset>

                                    <input type="submit" value="Sign In" class="button-primary my-3 col-12">
                                </form>
                            </div>
                            <div class="d-none d-md-block col-md-2"></div>
                        </section>
                    </main>
                    <footer class="row text-center fixed-bottom mb-3">
                        <div class="col-12 col-md-6">
                            Not registered yet? 
                            <a class="link" href="./registration.php">Do it now!</a>
                        </div>
                    </footer>
                </div>
                <div class="d-none d-md-inline-block col-md-6">
                    <img class="wallpaper" src="https://source.unsplash.com/random/1200x1920/?food" alt="">
                </div>
                <div class="col-1 d-md-none"></div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </body>
</html>