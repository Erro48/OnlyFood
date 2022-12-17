<?php
require_once '../bootstrap.php';

if (isset($_GET["tag"])) {
    $tags = json_decode($_GET["tag"]);

    $postList = $dbh->getExplorePosts("carlo61", $tags);
    echo json_encode($postList);
}


?>