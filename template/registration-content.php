<?php
    $errors = array();
    
    if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm-password'])) {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm-password'];
        
        // controllo username già presente
        // controllo email già presente
        if ($dbh->userAlreadyRegistered($username, $email)) {
            array_push($errors, "User already registered");

        }
        if (strcmp($password, $confirm_password) != 0) {
            // controllo password uguali
            array_push($errors, "Passwords are not equal");
            
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // controllo email valida
            array_push($errors, "Email is not valid");

        }
        if(preg_match('/^[^\W_]{3,}+$/', $username) == 0) {
            // controllo username valido
            echo $username;
            array_push($errors, "Username is not valid");
            
        }
        if (preg_match("/^[a-zA-Z][0-9a-zA-Z_!$@#^&]{7,}$/", $password) == 0) {
            // controllo password valida
            array_push($errors, "Password is not valid");
            
        }
        
        if (count($errors) == 0) {
            $insert_result = $dbh->registerUser($name, $surname, $username, $email, $password);
            if ($insert_result == false) {
                array_push($errors, "Registration fails");
            } else {
                // set session
                $_SESSION['username'] = $username;

                header("Location: ./index.php");
            }
        }

    }

?>



<section class="row login-section">
    <div class="d-none d-md-block col-md-2"></div>

    <div class="col-12 col-md-8">
        <header class="row text-center mb-5">
            <h1>Create an account</h1>
            <em>Fields with <strong class="required-char">*</strong> are required</em>
        </header>

        <div class="row justify-content-center p-0 <?= !isset($error) ? 'd-none' : '' ?>">
            <div class="col-12 w-100 alert alert-danger">
                <?= $error ?>
            </div>
        </div>

        <form action="./registration.php" method="post" class="row justify-content-center m-0 mt-4">
            <label for="user-pic" class="mt-2 p-0">
                <input class="ps-3 d-none" type="file" name="profile-pic" id="user-pic" accept="image/*" onchange="profilePicPreview()">
                <p class="profile-pic m-0">
                    <img src="./imgs/propics/default.png" alt="Profile pic preview">
                </p>
            </label>

            <label for="user-name" class="mt-2 p-0">
                <input class="ps-3" type="text" name="name" id="user-name" required>
                <p class="ps-3 m-0"><strong class="required-char">*</strong> First Name</p>
            </label>
        
            <label for="user-surname" class="mt-2 p-0">
                <input class="ps-3" type="text" name="surname" id="user-surname" required>
                <p class="ps-3 m-0"><strong class="required-char">*</strong> Last Name</p>
            </label>

            <div class="row justify-content-end p-0 m-0">
                <input type="button" value="Next" class="button-primary w-50">
            </div>
        </form>
        
    </div>

    <div class="d-none d-md-block col-md-2"></div>
    

</section>
<footer class="row text-center fixed-bottom mb-3">
    <div class="col-12 col-md-6">
        Already registered? 
        <a class="link" href="./login.php">Log in here!</a>
    </div>
</footer>


<!-- <section>
    <header class="row">
        <h1>Registration</h1>
    </header>

    <div class="row">
        <div class="col-12 <?= count($errors) == 0 ? 'd-none' : '' ?>">
            <?php
                foreach ($errors as $error) {
                    echo $error;
                }
            ?>
        </div>
    </div>

    <form action="./registration.php" method="post" class="row">
        <fieldset>
            <legend>Personal informations:</legend>

            <label for="name">First Name</label>
            <input type="text" name="name" id="name" \>

            <label for="surname">Last Name</label>
            <input type="text" name="surname" id="surname" \>

            <label for="profile-pic">Profile pic</label>
            <input type="file" name="profile-pic" id="profile-pic" \>
        </fieldset>

        <fieldset>
            <legend>Account informations:</legend>

            <label for="username">Username</label>
            <input type="text" name="username" id="username" \>

            <label for="email">Email</label>
            <input type="text" name="email" id="email" \>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" \>

            <label for="confirm-password">Confirm Password</label>
            <input type="password" name="confirm-password" id="confirm-password" \>
        </fieldset>

        <fieldset>
            <legend>Intolerances:</legend>

            <label for="intolerance">Intolerance</label>
            <input type="text" name="intolerance" id="intolerance" \>
        </fieldset>

        <input type="submit" value="Sign Up">
    </form>

    <div class="row">
        <div>
            Already registered? 
            <a href="./login.php"> Log in here!</a>
        </div>
    </div>
</section> -->
