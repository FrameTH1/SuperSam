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


$sql = "SELECT * FROM `lakhok_mushroom` WHERE lineid = '" . $userId . "'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // ผู้ใช้มีอยู่ในฐานข้อมูล
    $row = $result->fetch_assoc(); // ดึงข้อมูลแถวแรก
    $_SESSION["tel"] = $row["tel"]; // ใช้ค่าจากแถวที่ดึงมา
    $_SESSION["contact"] = $row["contact"]; // ใช้ค่าจากแถวที่ดึงมา
    echo json_encode(['exists' => true]);
} else {
    // ไม่มีผู้ใช้, เพิ่มเข้าไป
    $insertSql = "INSERT INTO `lakhok_mushroom` (`lineid`, `fname`) VALUES ('" . $userId . "','" . $displayName . "')";
    $conn->query($insertSql);
    echo json_encode(['exists' => false]);
}


$conn->close();
?>