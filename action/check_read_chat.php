<?php

session_start();
include 'database.php';

$userId = $_SESSION["userId"];

$sql = "SELECT c.*, j.employer_id, j.employee_id, j.title, m.fname
FROM lakhok_chat c
JOIN lakhok_jobs j ON c.job_id = j.id
JOIN lakhok_mushroom m ON m.lineid = c.sender_id
WHERE m.lineid = '" . $_SESSION["userId"] . "'
ORDER BY c.time DESC;";

$result = $conn->query($sql);

$unreadMessages = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $unreadMessages[] = $row;
    }
} else {
    // ถ้า result เป็น [], ทำการ query ใหม่
    $sql = "SELECT 
        c.*, 
        j.employer_id, 
        j.employee_id, 
        j.title, 
        m.fname 
    FROM 
        lakhok_chat c 
    JOIN 
        lakhok_jobs j 
    ON 
        c.job_id = j.id 
    JOIN 
        lakhok_mushroom m 
    ON 
        m.lineid = c.sender_id 
    WHERE 
        m.lineid = '" . $_SESSION["userId"] . "'
        ORDER BY c.time DESC;
    ";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $unreadMessages[] = $row;
        }
    }
}

// สามารถใช้งาน $unreadMessages ได้ตามต้องการ

echo json_encode($unreadMessages);

$conn->close();

?>