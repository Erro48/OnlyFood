<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["title"] = "OnlyFood - Login";
$templateParams["nome"] = "template/login-content.php";
$templateParams["posts"] = $dbh->getPostsByUser("carlo61");

// //Home Template
// $templateParams["articoli"] = $dbh->getPosts(2);

require 'template/login-base.php';
?>