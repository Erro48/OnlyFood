<?php

$PROFILE_PIC_DIR = "imgs/propics/";
$DEFAULT_PROFILE_PIC = "default.png";
$POST_PIC_DIR = "imgs/posts/";

$MAX_FILE_SIZE = 10000000;
$NUM_FAVOURITE_INGREDIENTS = 3;

enum NotificationTypes: int {
    case Follow = 0;
    case Like = 1;
    case Comment = 2;
}

?>