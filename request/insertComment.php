<?php
require_once '../bootstrap.php';;

$input = json_decode(file_get_contents('php://input'), true);
echo $dbh->insertComment("carlo61", $input["postId"], $input["text"]);   //TODO cambiare user


?>