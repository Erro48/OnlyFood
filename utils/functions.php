<?php
require_once(__DIR__ . "/consts.php");

function downloadProfilePic($file, $dbh) {
    global $MAX_FILE_SIZE;
    global $PROFILE_PIC_DIR;

    $file_name = $file['name'];
    $file_tmp_name = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];
    $file_type = $file['type'];

    $file_extension = explode('.', $file_name);
    $file_extension = strtolower(end($file_extension));

    if(in_array($file_extension, array('jpg', 'jpeg', 'png', "gif", "jfif"))) {
        if($file_error === 0){
            if($file_size < $MAX_FILE_SIZE){
                // delete old photo (if present)
                $result = $dbh->getUserInfo($_SESSION['username']);
                if(count($result) == 1){
                    $row = $result[0];
                    if($row['profilePic'] && file_exists($PROFILE_PIC_DIR . $row["profilePic"])){
                        unlink($PROFILE_PIC_DIR.$row['profilePic']);
                    }
                }

                $new_file_name = encryptProfilePic($_SESSION['username'], $file_name);
                
                // upload new photo
                $dbh->updateProfilePic($new_file_name);

                $file_destination = $PROFILE_PIC_DIR.$new_file_name;

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

?>