<?php
require_once 'bootstrap.php';

$templateParams["title"] = "OnlyFood - Home";
$templateParams["name"] = "home.php";
$templateParams["style"] = array("home-style.css", "posts-style.css");
$templateParams["script"] = array("home-script.js");
$templateParams["posts"] = $dbh->getPostsByUser("carlo61");

require 'template/base.php';
?>