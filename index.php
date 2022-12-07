<?php
require_once 'bootstrap.php';

$templateParams["title"] = "OnlyFood - Home";
$templateParams["nome"] = "home.php";
$templateParams["script"] = "homeScript.js";
$templateParams["posts"] = $dbh->getPostsByUser("carlo61");

require 'template/base.php';
?>