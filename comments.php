<?php
require_once 'bootstrap.php';

$templateParams["title"] = "OnlyFood - Comments";
$templateParams["name"] = "comments-content.php";
$templateParams["style"] = array("comments-style.css");
$templateParams["script"] = array("comments-script.js");
if(isset($_GET["post"])) {
    $templateParams["postId"] = $_GET["post"];
    $templateParams["comments"] = $dbh->getCommentsByPost($_GET["post"]);
    $templateParams["postDetails"] = $dbh->getPostsById($_GET["post"]);
} else {
    $templateParams["postId"] = -1;     //Per segnalare l'errore
}

require 'template/base.php';
?>