<?php

session_start();
include 'database.php';

$id_post = $_POST['id_post'];


// Query เพื่อตรวจสอบสถานะปัจจุบัน
$query = "SELECT status FROM lakhok_jobs WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id_post);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    $status = $row['status'];

    // อัพเดทสถานะตามที่กำหนด
    if ($status == 'รอคนจ้างงาน') {
        $new_status = 'กำลังดำเนินการของจ้างงาน';
    } elseif ($status == 'รอคนหางาน') {
        $new_status = 'กำลังดำเนินการของหางาน';
    } elseif ($status == 'กำลังดำเนินการของจ้างงาน') {
        $new_status = 'การดำเนินการจ้างงานเสร็จสิ้น';
    } elseif ($status == 'กำลังดำเนินการของหางาน') {
        $new_status = 'การดำเนินการหางานเสร็จสิ้น';
    } elseif ($status == 'การดำเนินการจ้างงานเสร็จสิ้น') {
        echo json_encode(['success' => true, 'rating' => true]);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'สถานะไม่ถูกต้อง =>' . $status]);
        exit;
    }

    // อัพเดทสถานะในฐานข้อมูล
    $update_query = "UPDATE lakhok_jobs SET status = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param('si', $new_status, $id_post);

    if ($update_stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'ไม่สามารถอัพเดทสถานะได้']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ไม่พบโพสต์']);
}

$stmt->close();
$conn->close();
?>