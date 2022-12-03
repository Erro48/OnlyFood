<?php
require_once 'bootstrap.php';

$templateParams["title"] = "OnlyFood - Profile";
$templateParams["nome"] = "profile-content.php";
$templateParams["posts"] = $dbh->getUserPosts("ig_Massari"); //TODO use session profile
$templateParams["style"] = array("profile-style.css");

require 'template/base.php';
?>