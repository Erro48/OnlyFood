<?php
require_once '../bootstrap.php';

if (isset($_GET["user"])) {
    $username = $_GET["user"];
    $users_list = $dbh->searchUser($username);
    
    for ($i=0; $i < count($users_list); $i++) {
        $users_list[$i]["profilePic"] = $PROFILE_PIC_DIR.$users_list[$i]["profilePic"];
    }

    echo json_encode($users_list);
}
?>