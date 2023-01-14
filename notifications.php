<?php
require_once 'bootstrap.php';

$templateParams["title"] = "OnlyFood - Notification";
$templateParams["name"] = "notifications-content.php";
$templateParams["style"] = array("notifications-style.css");
$templateParams["notifications"] = $dbh->getNotifications($_SESSION["username"]);

usort($templateParams["notifications"], function($a, $b) {
    $a_datetime = new DateTime($a["date"]);
    $b_datetime = new DateTime($b["date"]);
    if ($a_datetime == $b_datetime) {
        return 0;
    }
    return $a_datetime > $b_datetime ? -1 : 1;
});

$dbh->markNotificationsAsRead($templateParams["notifications"]);

require 'template/base.php';
?>