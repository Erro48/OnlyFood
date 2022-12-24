<?php
require_once 'bootstrap.php';

$templateParams["title"] = "OnlyFood - Explore";
$templateParams["name"] = "explore-content.php";
$templateParams["style"] = array("explore-style.css", "posts-style.css");
$templateParams["script"] = array("posts-script.js", "explore-script.js");
$templateParams["tags"] = $dbh->getTags();
$templateParams["posts"] = $dbh->getExplorePosts("carlo61");

require 'template/base.php';
?>