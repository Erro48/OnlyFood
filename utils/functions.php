<?php

define("PROPICS_DIR", "./imgs/propics/");

function downloadProfilePic($file, $dbh) {
    define("MAX_FILE_SIZE", 10000000);

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExtension = explode('.', $fileName);
    $fileExtension = strtolower(end($fileExtension));

    $allowedExtension = array('jpg', 'jpeg', 'png');

    if(in_array($fileExtension, $allowedExtension)) {
        if($fileError === 0){
            if($fileSize < MAX_FILE_SIZE){
                //ELIMINO LA VECCHIA FOTO PROFILO SE ESISTENTE
                $result = $dbh->getUserInfo($_SESSION['username']);
                
                if(count($result) == 1){
                    $row = $result[0];
                    if($row['profilePic'] && file_exists(PROPICS_DIR . $row["profilePic"])){
                        unlink(PROPICS_DIR.$row['profilePic']);
                    }
                }

                $new_file_name = encryptProfilePic($_SESSION['username'], $fileName);
                
                //CARICO LA NUOVA FOTO PROFILO
                $dbh->updateProfilePic($new_file_name);

                $fileDestination = PROPICS_DIR.$new_file_name;

                move_uploaded_file($fileTmpName, $fileDestination);                    
                //header("location: ../settings.php");
            }
        } else {
            //header("location: ../settings.php?error=3");
        }
    }
}

function encryptProfilePic($username, $profile_pic_name) {
    $file_extension = explode('.', $profile_pic_name);
    $file_extension = strtolower(end($file_extension));

    return hash("md5", $username)."_".uniqid('', true).".".$file_extension;
}

?>