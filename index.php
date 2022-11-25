<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["title"] = "OnlyFood - Home";
$templateParams["nome"] = "home.php";
$templateParams["posts"] = $dbh->getPostsByUser("carlo61");

// //Home Template
// $templateParams["articoli"] = $dbh->getPosts(2);

require 'template/base.php';
?>