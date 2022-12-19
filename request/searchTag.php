<?php
require_once '../bootstrap.php';

if (isset($_GET["tag"])) {
    $tag = $_GET["tag"];

    if(empty($tag)){
        $tagList = $dbh->getTags();
    } else {
        $tagList = $dbh->searchTag($tag);
    }
    echo json_encode($tagList);
}


?>