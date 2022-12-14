<?php
require_once 'bootstrap.php';

$templateParams["title"] = "OnlyFood - Explore";
$templateParams["nome"] = "explore-content.php";
$templateParams["style"] = array("explore-style.css");
$templateParams["script"] = array(/*"https://unpkg.com/axios/dist/axios.min.js", */"home-script.js", "explore-script.js");
$templateParams["tags"] = $dbh->getTags();
$templateParams["posts"] = $dbh->getExplorePosts("carlo61");

require 'template/base.php';
?>