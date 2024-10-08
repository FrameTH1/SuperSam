<?php

session_start();

$target_dir = "../uploads/image/".$_SESSION["userId"]."/"; // โฟลเดอร์เก็บรูปภาพ
$target_file = $target_dir . basename($_FILES["jobImage"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// ตรวจสอบและสร้างโฟลเดอร์ถ้ายังไม่มี
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true); // ตัวเลข 0777 คือการตั้งสิทธิ์การเข้าถึง, true คือสร้างโฟลเดอร์ย่อยๆ หากจำเป็น
}

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["jobImage"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["jobImage"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["jobImage"]["tmp_name"], $target_file)) {
        echo json_encode("The file ". htmlspecialchars( basename( $_FILES["jobImage"]["name"])). " has been uploaded.");
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>