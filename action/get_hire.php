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
            ANY_VALUE(lj.id) AS id_post,
            ANY_VALUE(lm.lineid) AS id,
            lj.employee_id, 
            ANY_VALUE(r.rating_count) AS rating_count, 
            ANY_VALUE(r.average_rating) AS average_rating, 
            ANY_VALUE(lj.title) AS title,
            ANY_VALUE(lj.price) AS price, 
            ANY_VALUE(lj.img) AS img,
            ANY_VALUE(lj.description) AS description,
            ANY_VALUE(lj.types) AS types,
            ANY_VALUE(lm.profile_image) AS profile_image, 
            ANY_VALUE(lm.fname) AS fname, 
            ANY_VALUE(lm.verify) AS verify,
            ANY_VALUE(lm.contact) AS contact
        FROM lakhok_jobs lj
        INNER JOIN lakhok_mushroom lm ON lj.employee_id = lm.id
        LEFT JOIN (
            SELECT 
                employee_id,
                COUNT(rating) AS rating_count, 
                AVG(rating) AS average_rating
            FROM lakhok_jobs
            WHERE status = 'รอคนจ้างงาน'
            GROUP BY employee_id
        ) r ON lj.employee_id = r.employee_id
        WHERE lj.status = 'รอคนจ้างงาน'
        AND lm.verify = ?
        AND lj.title LIKE ?";

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
            ANY_VALUE(lj.id) AS id_post,
            ANY_VALUE(lm.lineid) AS id,
            lj.employee_id, 
            ANY_VALUE(r.rating_count) AS rating_count, 
            ANY_VALUE(r.average_rating) AS average_rating, 
            ANY_VALUE(lj.title) AS title,
            ANY_VALUE(lj.price) AS price, 
            ANY_VALUE(lj.img) AS img,
            ANY_VALUE(lj.description) AS description,
            ANY_VALUE(lj.types) AS types,
            ANY_VALUE(lm.profile_image) AS profile_image, 
            ANY_VALUE(lm.fname) AS fname, 
            ANY_VALUE(lm.verify) AS verify,
            ANY_VALUE(lm.contact) AS contact
        FROM lakhok_jobs lj
        INNER JOIN lakhok_mushroom lm ON lj.employee_id = lm.id
        LEFT JOIN (
            SELECT 
                employee_id,
                COUNT(rating) AS rating_count, 
                AVG(rating) AS average_rating
            FROM lakhok_jobs
            WHERE status = 'รอคนจ้างงาน'
            GROUP BY employee_id
        ) r ON lj.employee_id = r.employee_id
        WHERE lj.status = 'รอคนจ้างงาน'
        AND lj.title LIKE ?";


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