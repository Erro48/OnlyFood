<?php
require_once '../bootstrap.php';

if (isset($_GET["title"])) {
    $title = $_GET["title"];
    $posts_list = $dbh->searchPost($title);
    
    for ($i = 0; $i < count($posts_list); $i++) {
        $posts_list[$i]["preview"] = $POST_PIC_DIR.$posts_list[$i]["preview"];
        $posts_list[$i]["profilePic"] = $PROFILE_PIC_DIR.$posts_list[$i]["profilePic"];
        $posts_list[$i]["comments"] = $dbh->getCommentsCountByPost($posts_list[$i]["postId"])[0]["comments"];
        $posts_list[$i]["likes"] = $dbh->getLikesByPost($posts_list[$i]["postId"])[0]["likes"];
        $posts_list[$i]["ingredients"] = $dbh->getIngredientByPost($posts_list[$i]["postId"]);
        $posts_list[$i]["liked"] = $dbh->postAlreadyLikedByUser($_SESSION["username"], $posts_list[$i]["postId"]);
    }

    echo json_encode($posts_list);
}
?>