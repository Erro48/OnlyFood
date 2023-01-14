<?php
require_once 'bootstrap.php';

$templateParams["title"] = "OnlyFood - Create Post";
$templateParams["name"] = "create-post.php";
$templateParams["style"] = array("create-post-style.css", "modal.css");
$templateParams["script"] = array("cookie.js", "modal.js", "create-post-script.js", "search-ingredient.js", "search-tag.js");

require 'template/base.php';
?>