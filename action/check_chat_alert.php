<?php

session_start();
include 'database.php';

// รับข้อมูลจาก POST request
$job_id = $_POST['job_id'];

// ดึงข้อมูล status จากตาราง lakhok_jobs
$sql = "SELECT status FROM lakhok_jobs WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();

$sql = "UPDATE lakhok_chat 
SET already_read = 1 
WHERE job_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $job_id);
$stmt->execute();

$status = '';

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $status = $row['status'];
}

// ส่งข้อมูลกลับในรูปแบบ JSON
echo json_encode(['status' => $status]);

$stmt->close();
$conn->close();
?>
