<?php

session_start();
include 'database.php';

// รับข้อมูลจาก POST request
$message = $_POST['message'];
$sender_id = $_POST['sender_id'];
$receiver_id = $_POST['receiver_id'];
$job_id = $_POST['job_id']; // เพิ่ม job_id เพื่อระบุว่างานไหน

// บันทึกข้อมูลลงในตาราง lakhok_chat
$sql = "INSERT INTO lakhok_chat (message, receiver_id, sender_id, job_id) VALUES ('$message', '$sender_id', '$receiver_id', '$job_id')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>
