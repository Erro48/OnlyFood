<?php
require_once 'bootstrap.php';

$templateParams["title"] = "OnlyFood - Profile";
$templateParams["nome"] = "profile-content.php";
$templateParams["posts"] = $dbh->getUserPosts("ig_Massari"); //TODO use session profile
$templateParams["profile"] = $dbh->getProfileInfo("ig_Massari");
$templateParams["favouriteIngredients"] = $dbh->getMostUsedIngredients("ig_Massari");
$templateParams["style"] = array("profile-style.css", "home-style.css");
$templateParams["script"] = array("profile-script.js", "home-script.js");

require 'template/base.php';
?>