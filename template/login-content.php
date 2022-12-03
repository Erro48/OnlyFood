<?php
    $error = "";
    
    if (isset($_POST['user']) && isset($_POST['password'])) {
        $user = $_POST['user'];
        $password = $_POST['password'];
        if ($dbh->isUserRegistered($user)) {

            if (verifyUserPassword($user, $password)) {
                // set session
                $_SESSION['username'] = $user;
                
                header('Location: ./index.php');
            } else {
                $error = "Wrong password";
            }
        } else {
            $error = "Not registered";
        }
    }

    function verifyUserPassword($user, $password) {
        global $dbh;
        $password_hash = $dbh->getUserPassword($user);
        return password_verify($password, $password_hash);
    }
?>


<section class="login-section ">
    <header class="row text-center">
        <h1>Welcome back Chef</h1>
    </header>

    <div class="row">
        <div class="col-12 <?= !isset($error) ? 'd-none' : '' ?>">
            <?= $error ?>
        </div>
    </div>

    <div class="row text-center mt-4 mb-1">
        <p class="col-12 m-0">Sign in to continue</p>
    </div>

    <form action="./login.php" method="post" class="row">
        <label for="user-input" class="mt-2">Username</label>
        <input type="text" name="user" id="user-input" placeholder="Username" required>
    
        <label for="user-password" class="mt-2">Password</label>
        <input type="password" name="password" id="user-password" placeholder="Password" required>

        <input type="submit" value="Sign In" class="button-primary my-3">
    </form>

    <div class="row text-end"><a href="" class="link p-0">Forgot Password?</a></div>

    <div class="row text-center">
        <div>
            Not registered yet? 
            <a class="link" href="./registration.php"> <strong>Do it now!</strong></a>
        </div>
    </div>
</section>
