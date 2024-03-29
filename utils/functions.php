<?php
require_once(__DIR__ . "/consts.php");

function downloadImage($file, $dbh, $file_destination) {
    global $MAX_FILE_SIZE;
    global $POST_PIC_DIR;

    $file_name = basename($file_destination);
    $destination_folder = str_replace($file_name, '', $file_destination);

    $file_tmp_name = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];
    $file_type = $file['type'];

    $file_extension = explode('.', $file_name);
    $file_extension = strtolower(end($file_extension));

    if(in_array($file_extension, array('jpg', 'jpeg', 'png', "gif", "jfif"))) {
        if($file_error === 0){
            if($file_size < $MAX_FILE_SIZE){
                if (!file_exists($POST_PIC_DIR)) {
                    mkdir($POST_PIC_DIR, 0777, true);
                }
                move_uploaded_file($file_tmp_name, $file_destination);                    
            }
        }
    }
}

function encryptProfilePic($username, $profile_pic_name) {
    $file_extension = explode('.', $profile_pic_name);
    $file_extension = strtolower(end($file_extension));

    return hash("md5", $username)."_".uniqid('', true).".".$file_extension;
}

function printApproximateNumber($n){
    if($n >= 1000 && $n < 1000000) {
        $n = ($n / 1000)."k";
    } else if($n >= 1000000 && $n < 1000000000) {
        $n = ($n / 1000000)."m";
    } else if($n >= 1000000000) {
        $n = ($n / 1000000000)."b";
    }
    if(strpos($n, ".") != false) {
        return substr($n, 0, strpos($n, ".")).substr($n, -1, 1);
    } else {
        return $n;
    }
}

function passwordValidation($password) {
    $is_special = preg_match('/[_!$@#^&+\?]/', $password);
    $is_numeric = preg_match('/[0-9]/', $password);
    $is_lower_char = preg_match('/[a-z]/', $password);
    $is_upper_char = preg_match('/[A-Z]/', $password);

    return $is_special + $is_numeric + $is_lower_char + $is_upper_char == 4 && strlen($password) >= 7;
}

function datetimeToString($datestring) {
    $date = new DateTime($datestring);
    $current_date = new DateTime();
    $timestamp = $current_date->diff($date);

    $output_string = "less than a minute ago";
    if ($timestamp->d > 0 || $timestamp->m > 0 || $timestamp->y > 0) {
        $output_string = $date->format('d/m/Y'); 
    } else {
        if ($timestamp->h > 0) {
            $output_string = $timestamp->h." hour".($timestamp->h > 1 ? "s" : "")." ago";
        } else if ($timestamp->i > 0) {
            $output_string = $timestamp->i." minute".($timestamp->i > 1 ? "s" : "")." ago";
        }
    }

    return $output_string;
}

?>