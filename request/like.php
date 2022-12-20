<?php
require_once '../bootstrap.php';

if (isset($_GET["postId"])) {
    $postId = $_GET["postId"];

    if($dbh->postAlreadyLikedByUser("carlo61", $postId)){ //TODO cambiare user
        $dbh->unlikePost("carlo61", $postId);
        $data["backgroundColor"] = "var(--background)";
    } else {
        $dbh->likePost("carlo61", $postId);
        $data["backgroundColor"] = "var(--primary)";
    }
    echo json_encode($data);
}


?>