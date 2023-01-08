<?php
require_once 'bootstrap.php';

$templateParams["title"] = "OnlyFood - Search";
$templateParams["name"] = "search-content.php";
$templateParams["style"] = array("search-style.css", "modal.css");
$templateParams["script"] = array("search-script.js", "modal.js", 'search-ingredient.js');

require 'template/base.php';
?>