<?php
require_once '../bootstrap.php';

if (isset($_GET["tag"])) {
    $tags = json_decode($_GET["tag"]);

    $postList = $dbh->getExplorePosts($_SESSION["username"], $tags);
    for($i = 0; $i < count($postList); $i++) {
        $postList[$i]["ingredients"] = $dbh->getIngredientByPost($postList[$i]["postId"]);
        $postList[$i]["likes"] = $dbh->getLikesByPost($postList[$i]["postId"])[0]["likes"];
        $postList[$i]["comments"] = $dbh->getCommentsCountByPost($postList[$i]["postId"])[0]["comments"];
        $postList[$i]["likeButtonClass"] = $dbh->postAlreadyLikedByUser($_SESSION["username"], $postList[$i]["postId"]) ? "liked" : "not-liked"; 
    }
    echo json_encode($postList);
}


?>