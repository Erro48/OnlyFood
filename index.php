<?php
require_once 'bootstrap.php';

$templateParams["title"] = "OnlyFood - Home";
$templateParams["name"] = "home.php";
$templateParams["style"] = array("home-style.css", "posts-style.css");
$templateParams["script"] = array("posts-script.js");
$templateParams["posts"] = $dbh->getPostsByUser($_SESSION["username"]);

require 'template/base.php';
?>