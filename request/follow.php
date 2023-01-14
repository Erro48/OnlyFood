<?php
require_once '../bootstrap.php';

if (isset($_GET["followers_of"])) {
    $followers = $dbh->getFollowers($_GET["followers_of"]);
    for ($i = 0; $i < count($followers); $i++) {
        $follower = $followers[$i];
        if ($follower["username"] == $_SESSION["username"]) {
            $follower = array(
                "current" => true,
                "profilePic" => $follower['profilePic'],
                "username" => $follower['username'],
                "follows_back" => $follower['follows_back']
            );
            $follower = (object)$follower;

            $followers[$i] = $follower;
        }
    }
    echo json_encode($followers);
}

if (isset($_GET["followings_of"])) {
    $followings = $dbh->getFollowings($_GET["followings_of"]);

    for ($i = 0; $i < count($followings); $i++) {
        $followed = $followings[$i];
        if ($followed["username"] == $_SESSION["username"]) {
            $followed = array(
                "current" => true,
                "profilePic" => $followed['profilePic'],
                "username" => $followed['username'],
                "follows_back" => $followed['follows_back']
            );
            $followed = (object)$followed;

            $followings[$i] = $followed;
        }
    }

    echo json_encode($followings);
}

?>