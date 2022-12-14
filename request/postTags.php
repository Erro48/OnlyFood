<?php
require_once '../bootstrap.php';

if (isset($_GET["tag"])) {
    $tag = $_GET["tag"];
    
    $postList = $dbh->getExplorePosts("carlo61");
    echo json_encode($postList);
}

?>