<?php
require_once 'bootstrap.php';

$templateParams["title"] = "OnlyFood - Notification";
$templateParams["name"] = "notifications-content.php";
$templateParams["style"] = array("notifications-style.css");
$templateParams["script"] = array("notifications-script.js");
$templateParams["notifications"] = $dbh->getUnreadNotifications($_SESSION["username"]);

require 'template/base.php';

$dbh->markNotificationsAsRead($templateParams["notifications"]);
?>