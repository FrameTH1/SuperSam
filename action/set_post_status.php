<?php

session_start();
include 'database.php';

$id_post = $_POST['id_post'];

// Query เพื่อตรวจสอบสถานะปัจจุบัน
$query = "SELECT status, employer_id, employee_id FROM lakhok_jobs WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id_post);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    $status = $row['status'];
    $employer_id = $row['employer_id'];
    $employee_id = $row['employee_id'];

    // ตรวจสอบว่า employer หรือ employee มีอยู่แล้วหรือไม่
    if (!$employer_id) {
        // เช็ต employer หากไม่มีค่า
        $new_employer_id = $_SESSION['id']; // หรืออาจเป็นค่าที่ได้จากที่อื่น
        $update_employer_query = "UPDATE lakhok_jobs SET employer_id = ? WHERE id = ?";
        $update_employer_stmt = $conn->prepare($update_employer_query);
        $update_employer_stmt->bind_param('ii', $new_employer_id, $id_post);
        $update_employer_stmt->execute();
        $update_employer_stmt->close();
    }

    if (!$employee_id) {
        // เช็ต employee หากไม่มีค่า
        $new_employee_id = $_SESSION['id']; // หรืออาจเป็นค่าที่ได้จากที่อื่น
        $update_employee_query = "UPDATE lakhok_jobs SET employee_id = ? WHERE id = ?";
        $update_employee_stmt = $conn->prepare($update_employee_query);
        $update_employee_stmt->bind_param('ii', $new_employee_id, $id_post);
        $update_employee_stmt->execute();
        $update_employee_stmt->close();
    }

    // อัพเดทสถานะตามที่กำหนด
    if ($status == 'รอคนจ้างงาน') {
        $new_status = 'กำลังดำเนินการของจ้างงาน';
    } elseif ($status == 'รอคนหางาน') {
        $new_status = 'กำลังดำเนินการของหางาน';
    } elseif ($status == 'กำลังดำเนินการของจ้างงาน') {
        $new_status = 'การดำเนินการจ้างงานเสร็จสิ้น';
    } elseif ($status == 'กำลังดำเนินการของหางาน') {
        $new_status = 'การดำเนินการหางานเสร็จสิ้น';
    } elseif ($status == 'การดำเนินการจ้างงานเสร็จสิ้น' || $status == 'การดำเนินการหางานเสร็จสิ้น') {
        echo json_encode(['success' => true, 'rating' => true]);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'สถานะไม่ถูกต้อง =>' . $status]);
        exit;
    }

    // อัพเดทสถานะในฐานข้อมูล พร้อมกับ end_date ถ้าสถานะเป็นการดำเนินการเสร็จสิ้น
    if ($new_status == 'การดำเนินการจ้างงานเสร็จสิ้น' || $new_status == 'การดำเนินการหางานเสร็จสิ้น') {
        $update_query = "UPDATE lakhok_jobs SET status = ?, end_date = NOW() WHERE id = ?";
    } else {
        $update_query = "UPDATE lakhok_jobs SET status = ? WHERE id = ?";
    }
    
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