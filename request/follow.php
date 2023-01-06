<?php
require_once '../bootstrap.php';

if (isset($_GET["followers_of"])) {
    $followers = $dbh->getFollowers($_GET["followers_of"]);
    echo json_encode($followers);
}

if (isset($_GET["followings_of"])) {
    $followings = $dbh->getFollowings($_GET["followings_of"]);
    echo json_encode($followings);
}

?>