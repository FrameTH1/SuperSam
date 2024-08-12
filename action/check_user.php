<?php

$userId = $_POST['userId'];
$displayName = $_POST['displayName'];
$statusMessage = $_POST['statusMessage'];
$pictureUrl = $_POST['pictureUrl'];
$email = $_POST['email'];

session_start();
$_SESSION["userId"] = $_POST['userId'];
$_SESSION["displayName"] = $_POST['displayName'];
$_SESSION["statusMessage"] = $_POST['statusMessage'];
$_SESSION["pictureUrl"] = $_POST['pictureUrl'];
$_SESSION["email"] = $_POST['email'];


include 'database.php';


$sql = "SELECT * FROM `users` WHERE user_id = '" . $userId . "'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // ผู้ใช้มีอยู่ในฐานข้อมูล
    echo json_encode(['exists' => true]);
} else {
    // ไม่มีผู้ใช้, เพิ่มเข้าไป
    $insertSql = "INSERT INTO `users` (`user_id`, `display_name`, `status_message`, `picture_url`, `email`) VALUES ('" . $userId . "','" . $displayName . "','" . $statusMessage . "','" . $pictureUrl. "','" . $email . "')";
    $conn->query($insertSql);
    echo json_encode(['exists' => false]);
}


$conn->close();
?>