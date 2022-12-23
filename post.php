<?php
require_once 'bootstrap.php';

$templateParams["title"] = "OnlyFood - Create Post";
$templateParams["name"] = "create-post.php";
$templateParams["style"] = array("create-post-style.css");
$templateParams["script"] = array("create-post-script.js", "search-ingredient.js");

require 'template/base.php';
?>