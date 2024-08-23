<?php
session_start();
include 'database.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// รับข้อมูลจากฟอร์ม
$jobTitle = $_POST['jobTitle'];
$jobDescription = $_POST['jobDescription'];
$jobPrice = $_POST['priceType']. ' ' . $_POST['jobPrice'];
$selectedItems = $_POST['selectedItems'];
$imagePath = "";

// ตรวจสอบและอัพโหลดรูปภาพ
if (isset($_FILES['jobImage']) && $_FILES['jobImage']['error'] == 0) {
    $userId = $_SESSION["userId"];
    $target_dir = "../uploads/image/" . $userId . "/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["jobImage"]["name"]);
    if (move_uploaded_file($_FILES["jobImage"]["tmp_name"], $target_file)) {
        $imagePath = $target_file;
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// เตรียมคำสั่ง SQL
$sql = "INSERT INTO lakhok_jobs (title, img, price, description, employer_id, post_date, status , types) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

// ตั้งค่าโซนเวลา ตัวอย่างนี้ใช้เวลาของกรุงเทพฯ (Thailand)
date_default_timezone_set('Asia/Bangkok');

// รับวันที่และเวลาปัจจุบัน
$currentDateTime = date('Y-m-d');
$status = "รอคนหางาน";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssisss", $jobTitle, $imagePath, $jobPrice, $jobDescription, $_SESSION["id"], $currentDateTime, $status, $selectedItems);

// บันทึกข้อมูลลงฐานข้อมูล
if ($stmt->execute()) {
    echo json_encode("New post created successfully");
} else {
    echo json_encode("Error: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>