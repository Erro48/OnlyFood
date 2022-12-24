<?php
require_once 'bootstrap.php';

$templateParams["title"] = "OnlyFood - Profile";
$templateParams["name"] = "profile-content.php";

if (isset($_GET["user"])) {

    if (isset($_SESSION["username"]) && $_SESSION["username"] == $_GET["user"]) {
        header("Location: ./profile.php");
    }

    $templateParams["posts"] = $dbh->getUserPosts($_GET["user"]);
    $templateParams["profile"] = $dbh->getProfileInfo($_GET["user"]);
    $templateParams["favouriteIngredients"] = $dbh->getMostUsedIngredients($_GET["user"]);
} else {
    /* TODO: remove, for debug only */
    if (isset($_SESSION["username"])) {
        $templateParams["posts"] = $dbh->getUserPosts($_SESSION["username"]);
        $templateParams["profile"] = $dbh->getProfileInfo($_SESSION["username"]);
        $templateParams["favouriteIngredients"] = $dbh->getMostUsedIngredients($_SESSION["username"]);    
    } else {
        $templateParams["posts"] = $dbh->getUserPosts("ig_Massari");
        $templateParams["profile"] = $dbh->getProfileInfo("ig_Massari");
        $templateParams["favouriteIngredients"] = $dbh->getMostUsedIngredients("ig_Massari");    
    }
}

$templateParams["style"] = array("profile-style.css", "posts-style.css");
$templateParams["script"] = array("profile-script.js", "posts-script.js");

require 'template/base.php';
?>