<?php

session_start();

include 'database.php';

// รับคำค้นหาจาก POST
$searchQuery = isset($_POST['search']) ? '%' . $_POST['search'] . '%' : '%';

// รับค่า POST
if (isset($_POST['verify'])) {

    if ($_POST['verify'] == 0 || $_POST['verify'] == 1) {
        // เตรียม query พร้อมเงื่อนไข verify
        $sql = "SELECT lakhok_jobs.*, lakhok_mushroom.profile_image, lakhok_mushroom.fname, lakhok_mushroom.verify 
            FROM lakhok_jobs
            INNER JOIN lakhok_mushroom ON lakhok_jobs.employer_id = lakhok_mushroom.id 
            WHERE lakhok_jobs.status_id = 1
            AND lakhok_mushroom.verify = ?
            AND lakhok_jobs.title LIKE ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $_POST['verify'], $searchQuery);
        $stmt->execute();
        $result = $stmt->get_result();
        // ตรวจสอบผลลัพธ์และส่งกลับในรูปแบบ JSON
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        // ส่งข้อมูลกลับไปที่ frontend ในรูปแบบ JSON
        header('Content-Type: application/json');
        echo json_encode($data);

    } else {
        // ดึงข้อมูลทั้งหมดที่ status_id เท่ากับ 1 โดยไม่สนค่า verify
        $sql = "
        SELECT lakhok_jobs.*, lakhok_mushroom.profile_image, lakhok_mushroom.fname, lakhok_mushroom.verify 
        FROM lakhok_jobs
        INNER JOIN lakhok_mushroom ON lakhok_jobs.employer_id = lakhok_mushroom.id 
        WHERE lakhok_jobs.status_id = 1
        AND lakhok_jobs.title LIKE ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $searchQuery);
        $stmt->execute();
        $result = $stmt->get_result();
        // ตรวจสอบผลลัพธ์และส่งกลับในรูปแบบ JSON
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        // ส่งข้อมูลกลับไปที่ frontend ในรูปแบบ JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>