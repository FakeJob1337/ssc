<?php
if ($_FILES && $_FILES["photo"]["error"]== UPLOAD_ERR_OK)
{   $id = $_COOKIE['id'];
    $path_info = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    $hashname = hash("xxh3", $_FILES['photo']['name']);
    $name = "/var/www/html/upload_photos/$hashname.$path_info";
    $db_name = "upload_photos/$hashname.$path_info";
    $status = move_uploaded_file($_FILES["photo"]["tmp_name"], $name);
    $conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');
    $sql = "UPDATE `personal_information` SET `profile_photo`= '$db_name' WHERE shtat_id = '$id'";
    // $sql = "INSERT INTO `photos`(`shtat_id`, `file_path`) VALUES ('$id','$db_name')";
    $res = $conn->query($sql)->fetch();
}

echo "$status";