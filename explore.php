<?php
require_once 'bootstrap.php';

$templateParams["title"] = "OnlyFood - Explore";
$templateParams["nome"] = "explore-content.php";
$templateParams["style"][0] = "explore-style.css";
$templateParams["script"][0] = "home-script.js";
$templateParams["tags"] = $dbh->getTags();
$templateParams["posts"] = $dbh->getExplorePosts("carlo61");

require 'template/base.php';
?>