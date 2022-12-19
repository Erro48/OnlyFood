<?php
require_once '../bootstrap.php';

if (isset($_GET["tag"])) {
    $tags = json_decode($_GET["tag"]);

    $postList = $dbh->getExplorePosts("carlo61", $tags);
    for($i = 0; $i < count($postList); $i++) {
        $postList[$i]["ingredients"] = $dbh->getIngredientByPost($postList[$i]["postId"]);
    }
    echo json_encode($postList);
}


?>