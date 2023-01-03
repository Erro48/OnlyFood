<?php
require_once '../bootstrap.php';

$input = json_decode(file_get_contents('php://input'), true);
echo $dbh->insertComment($_SESSION["username"], $input["postId"], $input["text"]);
?>