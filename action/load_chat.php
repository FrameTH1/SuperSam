<?php

session_start();
include 'database.php';

$sender_id = $_POST['sender_id'];
$receiver_id = $_POST['receiver_id'];
$job_id = $_POST['job_id'];

$sql = "SELECT * FROM lakhok_chat WHERE job_id = '$job_id' AND ((sender_id = '$sender_id' AND receiver_id = '$receiver_id') OR (sender_id = '$receiver_id' AND receiver_id = '$sender_id'))";
$result = $conn->query($sql);

$chats = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $chats[] = $row;
    }
}

echo json_encode($chats);

$conn->close();

?>
