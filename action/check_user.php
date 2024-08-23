<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$userId = isset($_POST['userId']) ? $_POST['userId'] : null;
$displayName = isset($_POST['displayName']) ? $_POST['displayName'] : null;
$statusMessage = isset($_POST['statusMessage']) ? $_POST['statusMessage'] : null;
$pictureUrl = isset($_POST['pictureUrl']) ? $_POST['pictureUrl'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;

if (!$userId || !$displayName) {
    echo json_encode(['error' => 'Missing required parameters']);
    exit;
}

$_SESSION["userId"] = $userId;
$_SESSION["displayName"] = $displayName;
$_SESSION["statusMessage"] = $statusMessage;
$_SESSION["pictureUrl"] = $pictureUrl;
$_SESSION["email"] = $email;

include 'database.php';

// ใช้ prepared statement
$stmt = $conn->prepare("SELECT * FROM `lakhok_mushroom` WHERE lineid = ?");
$stmt->bind_param("s", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // ผู้ใช้มีอยู่ในฐานข้อมูล
    $row = $result->fetch_assoc(); // ดึงข้อมูลแถวแรก
    $_SESSION["tel"] = $row["tel"]; // ใช้ค่าจากแถวที่ดึงมา
    $_SESSION["contact"] = $row["contact"]; // ใช้ค่าจากแถวที่ดึงมา
    $_SESSION["id"] = $row["id"]; // ใช้ค่าจากแถวที่ดึงมา
    echo json_encode(['exists' => true]);
} else {
    // ไม่มีผู้ใช้, เพิ่มเข้าไป
    $insertStmt = $conn->prepare("INSERT INTO `lakhok_mushroom` (`lineid`, `fname`, `profile_image`) VALUES (?, ?, ?)");
    $insertStmt->bind_param("sss", $userId, $displayName, $pictureUrl);
    $insertStmt->execute();
    echo json_encode(['exists' => false]);
}

// ปิด statement และ connection
$stmt->close();
if (isset($insertStmt)) {
    $insertStmt->close();
}
$conn->close();

?>