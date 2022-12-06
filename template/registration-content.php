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
        <header class="row text-left mb-5">
            <h1>Create an account</h1>
            <em>Fields with <strong class="required-char">*</strong> are required</em>
        </header>

        <div class="row justify-content-center p-0 <?= !isset($error) ? 'd-none' : '' ?>">
            <div class="col-12 w-100 alert alert-danger">
                <?= $error ?>
            </div>
        </div>

        <form action="./registration.php" method="post" class="row justify-content-center m-0 mt-4">
            <label for="search-ingredient" class="mt-2 p-0">
                <input class="ps-3 pe-2" type="search" name="search-ingredient" id="search-ingredient" required>
                <p class="ps-3 m-0">Search ingredient</p>
            </label>
            
            <div class="ingredients-list row">
                <?php foreach ($templateParams["intolerances"] as $intolerance):?>
                    
                    <label for="ingr-<?= $intolerance['name'] ?>" class="col-6 col-md-4">
                        <input type="checkbox" name="ingredient-chk" id="ingr-<?= $intolerance['name'] ?>">
                        <span class="ingredient-pill"><?= $intolerance['name'] ?></span>
                    </label>

                <?php endforeach ?>
            </div>


        
            

            <div class="row justify-content-center p-0 m-0">
                <input type="button" value="Back" class="col-5 button-secondary">
                <div class="col-2"></div>
                <input type="button" value="Next" class="col-5 button-primary">
            </div>
        </form>

        <!-- FIRST PAGE -->
        <!--    <label for="user-pic" class="mt-2 p-0">
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

            <div class="row justify-content-center p-0 m-0">
                <div class="col-7"></div>
                <input type="button" value="Next" class="col-5 button-primary">
            </div> -->

            <!-- SECOND PAGE -->
            <!-- <label for="user-username" class="mt-2 p-0">
                <input class="ps-3" type="text" name="username" id="user-username" required>
                <p class="ps-3 m-0"><strong class="required-char">*</strong> Username</p>
            </label>
        
            <label for="user-email" class="mt-2 p-0">
                <input class="ps-3" type="text" name="email" id="user-email" required>
                <p class="ps-3 m-0"><strong class="required-char">*</strong> Email</p>
            </label>

            <label for="user-password" class="mt-2 p-0">
                <input class="ps-3" type="password" name="password" id="user-password" required>
                <p class="ps-3 m-0"><strong class="required-char">*</strong> Password</p>
            </label>
            
            <label for="user-cpassword" class="mt-2 p-0">
                <input class="ps-3" type="password" name="cpassword" id="user-cpassword" required>
                <p class="ps-3 m-0"><strong class="required-char">*</strong> Confirm Password</p>
            </label>

            <div class="row justify-content-center p-0 m-0">
                <input type="button" value="Back" class="col-5 button-secondary">
                <div class="col-2"></div>
                <input type="button" value="Next" class="col-5 button-primary">
            </div> -->
        
    </div>

    <div class="d-none d-md-block col-md-2"></div>
    

</section>
<footer class="row text-center fixed-bottom mb-3">
    <div class="col-12 col-md-6">
        Already registered? 
        <a class="link" href="./login.php">Log in here!</a>
    </div>
</footer>
