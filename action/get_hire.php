<?php

session_start();

include 'database.php';

// รับคำค้นหาจาก POST
$searchQuery = isset($_POST['search']) ? '%' . $_POST['search'] . '%' : '%';

// รับค่า POST
if (isset($_POST['verify'])) {

    if ($_POST['verify'] == 0 || $_POST['verify'] == 1) {
        // เตรียม query พร้อมเงื่อนไข verify
        $sql = "SELECT 
                    lakhok_jobs.employee_id, 
                    AVG(lakhok_jobs.rating) AS average_rating, 
                    COUNT(lakhok_jobs.rating) AS rating_count, 
                    ANY_VALUE(lakhok_jobs.title) AS title,
                    ANY_VALUE(lakhok_jobs.price) AS price, 
                    ANY_VALUE(lakhok_jobs.img) AS img, 
                    ANY_VALUE(lakhok_mushroom.profile_image) AS profile_image, 
                    ANY_VALUE(lakhok_mushroom.fname) AS fname, 
                    ANY_VALUE(lakhok_mushroom.verify) AS verify
                FROM lakhok_jobs
                INNER JOIN lakhok_mushroom ON lakhok_jobs.employee_id = lakhok_mushroom.id
                WHERE lakhok_jobs.status = 'รอคนจ้างงาน'
                AND lakhok_mushroom.verify = ?
                AND lakhok_jobs.title LIKE ?
                GROUP BY lakhok_jobs.employee_id";

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
        $sql = "SELECT 
                    lakhok_jobs.employee_id, 
                    AVG(lakhok_jobs.rating) AS average_rating, 
                    COUNT(lakhok_jobs.rating) AS rating_count, 
                    ANY_VALUE(lakhok_jobs.title) AS title,
                    ANY_VALUE(lakhok_jobs.price) AS price, 
                    ANY_VALUE(lakhok_jobs.img) AS img,
                    ANY_VALUE(lakhok_mushroom.profile_image) AS profile_image, 
                    ANY_VALUE(lakhok_mushroom.fname) AS fname, 
                    ANY_VALUE(lakhok_mushroom.verify) AS verify
                FROM lakhok_jobs
                INNER JOIN lakhok_mushroom ON lakhok_jobs.employee_id = lakhok_mushroom.id
                WHERE lakhok_jobs.status = 'รอคนจ้างงาน'
                AND lakhok_jobs.title LIKE ?
                GROUP BY lakhok_jobs.employee_id";


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