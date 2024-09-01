<?php

session_start();
include 'database.php';


$jobId = $_POST['jobId'];
$rating = $_POST['rating'];

// อัปเดต rating ในฐานข้อมูล
$stmt = $conn->prepare("UPDATE lakhok_jobs SET rating = ? WHERE id = ?");
$stmt->bind_param("ii", $rating, $jobId);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'ไม่สามารถอัปเดต rating ได้']);
}

$stmt->close();


$conn->close();
?>