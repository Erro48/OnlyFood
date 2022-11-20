<?php
require_once 'bootstrap.php';

//Base Template
// $templateParams["titolo"] = "Blog TW - Home";
$templateParams["nome"] = "home.php";
$templateParams["posts"] = $dbh->getPostsByUser(0);
// $templateParams["articolicasuali"] = $dbh->getRandomPosts(2);
// //Home Template
// $templateParams["articoli"] = $dbh->getPosts(2);

require 'template/base.php';
?>