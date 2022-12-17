<?php
require_once 'bootstrap.php';

$templateParams["title"] = "OnlyFood - Explore";
$templateParams["name"] = "explore-content.php";
$templateParams["style"] = array("explore-style.css", "posts-style.css");
$templateParams["script"] = array("home-script.js", "explore-script.js");
$templateParams["tags"] = $dbh->getTags();

$tags = array("breakfast", "launch");
$templateParams["posts"] = $dbh->getExplorePosts("carlo61", $tags);

require 'template/base.php';
?>