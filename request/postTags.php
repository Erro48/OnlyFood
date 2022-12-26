<?php
require_once '../bootstrap.php';

if (isset($_GET["tag"])) {
    $tags = json_decode($_GET["tag"]);

    $postList = $dbh->getExplorePosts("carlo61", $tags);
    for($i = 0; $i < count($postList); $i++) {
        $postList[$i]["ingredients"] = $dbh->getIngredientByPost($postList[$i]["postId"]);
        $postList[$i]["likes"] = $dbh->getLikesByPost($postList[$i]["postId"])[0]["likes"];
        $postList[$i]["comments"] = $dbh->getCommentsCountByPost($postList[$i]["postId"])[0]["comments"];
        
        //TODO cambiare user
        $postList[$i]["likeButtonClass"] = $dbh->postAlreadyLikedByUser("carlo61", $postList[$i]["postId"]) ? "liked" : "not-liked"; 
    }
    echo json_encode($postList);
}


?>