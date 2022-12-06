<?php
require_once '../bootstrap.php';

if (isset($_GET["ingredient"])) {
    $ingredient = $_GET["ingredient"];

    $ingredients_list = $dbh->getIngredients($_GET["ingredient"]);
    echo json_encode($ingredients_list);
}

?>