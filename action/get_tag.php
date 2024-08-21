<?php

session_start();

include 'database.php';

$query = "SELECT id, name FROM lakhok_job_types";
$result = $conn->query($query);

$data = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row['name'];
    }
}

echo json_encode($data);
// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>