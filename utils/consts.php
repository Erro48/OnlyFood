<?php

$PROFILE_PIC_DIR = "imgs/propics/";
$DEFAULT_PROFILE_PIC = "default.png";

$MAX_FILE_SIZE = 10000000;

enum NotificationTypes: int {
    case Follow = 0;
    case Like = 1;
    case Comment = 2;
}

?>