<?php 
require_once "../bootstrap.php";

$username = $_SESSION['username'];
$num = $dbh->unreadNotificationCount($username);
echo $num;


?>