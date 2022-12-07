<?php
require_once 'bootstrap.php';

$templateParams["title"] = "OnlyFood - Home";
$templateParams["nome"] = "home.php";
$templateParams["style"][0] = "home-style.css";
$templateParams["script"][0] = "home-script.js";
$templateParams["posts"] = $dbh->getPostsByUser("carlo61");

require 'template/base.php';
?>