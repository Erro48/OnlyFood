<?php
require_once './bootstrap.php';
$DEFAULT_PROFILE_PIC = "/imgs/propics/default.png";

$errors = array();
    
if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm-password'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $profile_pic = $_FILES['profile-pic']; //isset($_FILES['profile-pic']) ? $_FILES['profile-pic'] : $DEFAULT_PROFILE_PIC;
    $intolerances = (isset($_POST['intolerances'])) ? $_POST['intolerances'] : array();

    print_r($profile_pic);

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
        // echo $username;
        array_push($errors, "Username is not valid");
    }
    if (preg_match("/^[a-zA-Z][0-9a-zA-Z_!$@#^&]{7,}$/", $password) == 0) {
        // controllo password valida
        array_push($errors, "Password is not valid");
    }
    
    if (count($errors) == 0) {
        $profile_pic_name = isset($_FILES['profile-pic']) 
                ? encryptProfilePic($username, $profile_pic['name']) 
                : $DEFAULT_PROFILE_PIC;
        
        $insert_result = $dbh->registerUser($name, $surname, $username, $email, $password, $profile_pic_name, $intolerances);
        if ($insert_result == false) {
            array_push($errors, "Registration fails");
        } else {
            // set session
            $_SESSION['username'] = $username;
            
            if (isset($_FILES['profile-pic'])) {
                downloadProfilePic($profile_pic, $dbh);
            }
            // header("Location: ./index.php");
        }
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OnlyFood - Registration</title>

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="./script/verification.js"></script>
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
            <header class="row text-left text-md-center mb-5 p-0">
                <h1 class="p-0">Create an account</h1>
                <em class="p-0">Fields with <strong class="required-char">*</strong> are required</em>
            </header>
            
            <main class="d-flex justify-content-center align-content-center flex-column p-0 p-md-5">
                <section class="row login-section">
                    <div class="d-none d-md-block col-md-2"></div>

                    <div class="col-12 col-md-8 scrollable">

                        <div class="alert error-alert <?= count($errors) == 0 ? 'd-none' : '' ?>">
                            <?php
                                foreach($errors as $error) {
                                    echo $error;
                                }
                            ?>
                        </div>

                        <form enctype="multipart/form-data" action="./registration.php" method="post" class="mt-4 d-flex flex-column justify-content-between">
                            
<!-- ----------------------- FIRST PAGE ----------------------- -->
                            <fieldset class="fieldset-0 p-0 m-0 col-12 d-flex flex-column">
                                <legend>Personal informations:</legend>
                                <label for="user-pic" class="mt-2 p-0 mx-auto">
                                    <input class="ps-3 d-none" type="file" name="profile-pic" id="user-pic" accept="image/*" onchange="profilePicPreview(this)">
                                    <p class="profile-pic m-0">
                                        <img src="./imgs/propics/default.png" alt="Profile pic preview">
                                    </p>
                                </label>

                                <label for="user-name" class="p-0">
                                    <input class="ps-3" type="text" name="name" id="user-name" required>
                                    <p class="ps-3 m-0"><strong class="required-char">*</strong> First Name</p>
                                </label>
                            
                                <label for="user-surname" class="p-0">
                                    <input class="ps-3" type="text" name="surname" id="user-surname" required>
                                    <p class="ps-3 m-0"><strong class="required-char">*</strong> Last Name</p>
                                </label>
                            </fieldset>

                            <div class="fieldset-0 row justify-content-end p-0 mx-0 ">
                                <input type="button" value="Next" class="col-5 button-primary" onclick="changeFieldset(event, RegistrationFieldset.ACCOUNT_INFORMATIONS)">
                            </div>

<!-- ----------------------- SECOND PAGE ----------------------- -->
                        <fieldset class="fieldset-1 p-0 m-0 col-12 d-none">
                            <legend>Account Informations:</legend>
                            <label for="user-username" class="p-0">
                                <input class="ps-3" type="text" name="username" id="user-username" required>
                                <p class="ps-3 m-0"><strong class="required-char">*</strong> Username</p>
                            </label>
                        
                            <label for="user-email" class="p-0">
                                <input class="ps-3" type="text" name="email" id="user-email" required>
                                <p class="ps-3 m-0"><strong class="required-char">*</strong> Email</p>
                            </label>

                            <label for="user-password" class="p-0">
                                <input class="ps-3" type="password" name="password" id="user-password" required>
                                <p class="ps-3 m-0"><strong class="required-char">*</strong> Password</p>
                            </label>
                            
                            <label for="user-cpassword" class="p-0">
                                <input class="ps-3" type="password" name="confirm-password" id="user-cpassword" required>
                                <p class="ps-3 m-0"><strong class="required-char">*</strong> Confirm Password</p>
                            </label>
                        </fieldset>
                        
                        <div class="fieldset-1 row justify-content-center p-0 mx-0  d-none">
                            <input type="button" value="Back" class="col-5 button-secondary" onclick="changeFieldset(event, RegistrationFieldset.PERSONAL_INFORMATIONS)">
                            <div class="col-2"></div>
                            <input type="button" value="Next" class="col-5 button-primary" onclick="changeFieldset(event, RegistrationFieldset.INTOLERANCES_INFORMATIONS)">
                        </div>

<!-- ----------------------- THIRD PAGE ----------------------- -->
                        <fieldset class="fieldset-2 p-0 m-0 col-12 d-none">
                            <legend>Intolerances:</legend>

                            <section class="search-section p-0 row w-100 mx-auto mt-4 mb-2">
                                <label for="search-ingredient" class="p-0 col-12">
                                    <input class="ps-3 pe-2" type="search" name="search-ingredient" id="search-ingredient"
                                        onkeyup="search(this)"
                                        onsearch="clearElement()"
                                        onfocusout="hideLabel(this)">
                                    <p class="ps-3 m-0">Search ingredient</p>
                                </label>

                                <!-- <button class="button-secondary col-2" onclick="addIngredientToList(event)">
                                    +
                                </button> -->

                                <div class="search-result-container p-0 col-12">
                                    <ul class="search-result p-0" id="search-result">
                        
                                    </ul>
                                </div>
                            </section>
                            
                            <div class="ingredients-list row w-100 m-auto mt-4 scrollable" data-server="true">
                                <?php foreach ($dbh->getMostFrequentIntolerances(5) as $intolerance):?>
                                    
                                    <label for="ingr-<?= $intolerance['name'] ?>" class="col-6 col-md-4">
                                        <input type="checkbox" name="intolerances[]" id="ingr-<?= $intolerance['name'] ?>" value="<?= $intolerance['name'] ?>">
                                        <span class="ingredient-pill"><?= ucwords($intolerance['name']) ?></span>
                                    </label>

                                <?php endforeach ?>
                            </div>

                        </fieldset>
                        <div class="fieldset-2 row justify-content-center p-0 m-0  d-none">
                            <input type="button" value="Back" class="col-5 button-secondary" onclick="changeFieldset(event, RegistrationFieldset.ACCOUNT_INFORMATIONS)">
                            <div class="col-2"></div>
                            <input type="submit" value="Sign Up" class="col-5 button-primary">
                        </div>

                        </form>

                        

                        
                        
                    </div>

                    <div class="d-none d-md-block col-md-2"></div>
                    

                </section>
            </main>
            <footer class="row text-center fixed-bottom mb-3">
                <div class="col-12 col-md-6">
                    Already registered? 
                    <a class="link" href="./login.php">Log in here!</a>
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