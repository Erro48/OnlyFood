<?php
require_once 'bootstrap.php';

$templateParams["title"] = "OnlyFood - Profile";
$templateParams["name"] = "profile-content.php";

if (isset($_GET["user"])) {
    if (!$dbh->userAlreadyRegistered($_GET["user"])) {
        header("Location: ./not-found.php");
    }

    if (isset($_SESSION["username"]) && strtolower($_SESSION["username"]) == strtolower($_GET["user"])) {
        header("Location: ./profile.php");
    }

    $templateParams["posts"] = $dbh->getUserPosts($_GET["user"]);
    $templateParams["profile"] = $dbh->getProfileInfo($_GET["user"]);
    $templateParams["favouriteIngredients"] = $dbh->getMostUsedIngredients($_GET["user"]);
} else {
    $templateParams["posts"] = $dbh->getUserPosts($_SESSION["username"]);
    $templateParams["profile"] = $dbh->getProfileInfo($_SESSION["username"]);
    $templateParams["favouriteIngredients"] = $dbh->getMostUsedIngredients($_SESSION["username"]);
}

$templateParams["style"] = array("profile-style.css", "posts-style.css");
$templateParams["script"] = array("profile-script.js", "posts-script.js");

require 'template/base.php';
?>