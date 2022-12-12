<?php
require_once '../bootstrap.php';

if (isset($_GET["ingredient"])) {
    $ingredient = $_GET["ingredient"];

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

?>