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


<section>
    <header class="row">
        <h1>Login</h1>
    </header>

    <div class="row">
        <div class="col-12 <?= !isset($error) ? 'd-none' : '' ?>">
            <?= $error ?>
        </div>
    </div>

    <form action="./login.php" method="post" class="row">
        <label for="user-input">Username (or email)</label>
        <input type="text" name="user" id="user-input" placeholder="Username (or email)" required>
    
        <label for="user-password">Password</label>
        <input type="password" name="password" id="user-password" placeholder="Password" required>

        <input type="submit" value="Login">
    </form>

    <div class="row">
        <div>
            Not registered yet? 
            <a href="./registration.php"> Do it now!</a>
        </div>
    </div>
</section>
