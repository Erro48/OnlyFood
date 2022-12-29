<?php
require_once '../bootstrap.php';

if (isset($_GET["postId"])) {
    $postId = $_GET["postId"];

    if($dbh->postAlreadyLikedByUser($_SESSION["username"], $postId)){
        $dbh->unlikePost($_SESSION["username"], $postId);
        $data["class"] = "not-liked";
    } else {
        $dbh->likePost($_SESSION["username"], $postId);
        $data["class"] = "liked";
    }
    $likes = $dbh->getLikesByPost($postId)[0]["likes"];
    $data["likeNumber"] = printApproximateNumber($likes);
    echo json_encode($data);
}


?>