<?php
    
    if (isset($_POST['user']) && isset($_POST['password'])) {
        $user = $_POST['user'];
        $password = $_POST['password'];
        if ($dbh->isUserRegistered($user) && verifyUserPassword($user, $password)) {
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


<section class="row login-section">
    <div class="d-none d-md-block col-md-2"></div>

    <div class="col-12 col-md-8">
        <header class="row text-center mb-5">
            <h1>Welcome back Chef</h1>
        </header>

        <div class="row justify-content-center p-0 <?= !isset($error) ? 'd-none' : '' ?>">
            <div class="col-12 w-100 alert alert-danger">
                <?= $error ?>
            </div>
        </div>

        <div class="row text-center mt-4 mb-1">
            <p class="col-12 m-0">Sign in to continue</p>
        </div>

        <form action="./login.php" method="post" class="row m-0 mt-4">
            <label for="user-input" class="mt-2 p-0">
                <input class="ps-3" type="text" name="user" id="user-input" required>
                <p class="ps-3 m-0">Username</p>
            </label>
        
            <label for="user-password" class="mt-2 p-0">
                <input class="ps-3" type="password" name="password" id="user-password" required>
                <p class="ps-3 m-0">Password</p>
            </label>

            <input type="submit" value="Sign In" class="button-primary my-3">
        </form>

        <div class="row justify-content-end m-0 mt-3">
            <a href="" class="link p-0 w-auto">Forgot Password?</a>
        </div>
    </div>

    <div class="d-none d-md-block col-md-2"></div>
    

</section>
<footer class="row text-center fixed-bottom mb-3">
    <div class="col-12 col-md-6">
        Not registered yet? 
        <a class="link" href="./registration.php"> <strong>Do it now!</strong></a>
    </div>
</footer>