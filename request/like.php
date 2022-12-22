<?php
require_once '../bootstrap.php';

if (isset($_GET["postId"])) {
    $postId = $_GET["postId"];

    if($dbh->postAlreadyLikedByUser("carlo61", $postId)){ //TODO cambiare user
        $dbh->unlikePost("carlo61", $postId);
        $data["class"] = "not-liked";
    } else {
        $dbh->likePost("carlo61", $postId);
        $data["class"] = "liked";
    }
    $likes = $dbh->getLikesByPost($postId)[0]["likes"];
    $data["likeNumber"] = printApproximateNumber($likes);
    echo json_encode($data);
}


?>