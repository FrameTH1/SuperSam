<?php
session_start();
include 'database.php';

if (isset($_POST['displayName']) && isset($_POST['tel']) && isset($_POST['contact'])) {
    $displayName = $_POST['displayName'];
    $tel = $_POST['tel'];
    $contact = $_POST['contact'];
    $lineid = $_SESSION['userId']; // หรือใช้ค่า ID ของผู้ใช้ที่มีการเก็บในเซสชัน

    // เตรียมคำสั่ง SQL เพื่ออัปเดตข้อมูล
    $sql = "UPDATE `lakhok_mushroom` SET `fname` = ?, `tel` = ?, `contact` = ? WHERE `lineid` = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $displayName, $tel, $contact, $lineid);

    if ($stmt->execute()) {
        // อัปเดตข้อมูลสำเร็จ
        $_SESSION['displayName'] = $displayName;
        $_SESSION['tel'] = $tel;
        $_SESSION['contact'] = $contact;
        echo json_encode(['success' => true]);
    } else {
        // อัปเดตข้อมูลล้มเหลว
        echo json_encode(['success' => false]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false]);
}

$conn->close();
?>