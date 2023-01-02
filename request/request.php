<?php
require_once '../bootstrap.php';

if (isset($_GET["ingredient"])) {
    $ingredients_list = $dbh->getIngredients($_GET["ingredient"]);
    echo json_encode($ingredients_list);
}

if (isset($_GET["username"])) {
    $user = $dbh->getUserInfo($_GET["username"]);
    echo json_encode($user);
}

if (isset($_GET["email"])) {
    $user = $dbh->getUserByEmail($_GET["email"]);
    echo json_encode($user);
}

if (isset($_GET["user"])) {
    $username = $_GET["user"];
    $users_list = $dbh->searchUser($username);
    
    for ($i=0; $i < count($users_list); $i++) {
        $users_list[$i]["profilePic"] = $PROFILE_PIC_DIR.$users_list[$i]["profilePic"];
    }

    echo json_encode($users_list);
}

if (isset($_GET["follow"])) {
    $username = $_GET["follow"];
    $dbh->follow($username);
    echo "1";
}

if (isset($_GET["unfollow"])) {
    $username = $_GET["unfollow"];
    $dbh->unfollow($username);
    echo "1";
}

if (isset($_GET["measures"])) {
    $ingredient = $_GET["measures"];
    $measures = $dbh->getIngredientsMeasures($ingredient);
    echo json_encode($measures);
}

if (isset($_GET["tag"])) {
    $tags_list = $dbh->getTags($_GET["tag"]);
    echo json_encode($tags_list);
}

if (isset($_GET["logout"])) {
    unset($_SESSION['username']);
    echo "1";
}

?>