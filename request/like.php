<?php
require_once '../bootstrap.php';

if (isset($_GET["postId"])) {
    $postId = $_GET["postId"];

    if($dbh->postAlreadyLikedByUser("carlo61", $postId)){ //TODO cambiare user
        $dbh->unlikePost("carlo61", $postId);
        $data["backgroundColor"] = "#f0f0f0";
    } else {
        $dbh->likePost("carlo61", $postId);
        $data["backgroundColor"] = "var(--primary)";
    }
    $likes = $dbh->getLikesByPost($postId)[0]["likes"];
    $data["likeNumber"] = printApproximateNumber($likes);
    echo json_encode($data);
}


?>