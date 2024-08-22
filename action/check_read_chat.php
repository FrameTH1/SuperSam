<?php

session_start();
include 'database.php';

$userId = $_SESSION["userId"];

$sql = "SELECT c.*, j.employer_id, j.employee_id, j.title, m.fname
        FROM lakhok_chat c
        JOIN lakhok_jobs j ON c.job_id = j.id
        JOIN lakhok_mushroom m ON (j.employer_id = m.id OR j.employee_id = m.id)
        WHERE m.lineid = '".$_SESSION["userId"]."';";


$result = $conn->query($sql);

$unreadMessages = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $unreadMessages[] = $row;
    }
}

echo json_encode($unreadMessages);

$conn->close();

?>
