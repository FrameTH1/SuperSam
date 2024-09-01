<?php

session_start();

include 'database.php';

// รับข้อมูลจากฟอร์ม
$jobPost = $_POST['jobPost'];
$jobStatus = $_POST['jobStatus'];
$userId = $_SESSION['userId'];

$sql = '';

if ($jobPost === 'โพสต์จ้างงาน') {
    if ($jobStatus === 'รอดำเนินการ') {
        $sql = "
    SELECT 
        lj.*, 
        lm.fname, 
        lm.profile_image,
        lm.verify,
        lm.contact,
        r.rating_count, 
        r.average_rating
    FROM 
        lakhok_jobs lj
    JOIN 
        lakhok_mushroom lm 
    ON 
        lj.employer_id = lm.id
    LEFT JOIN (
        SELECT 
            employer_id,
            COUNT(rating) AS rating_count, 
            AVG(rating) AS average_rating
        FROM 
            lakhok_jobs
        WHERE 
            status = 'รอคนหางาน'
        GROUP BY 
            employer_id
    ) r 
    ON 
        lj.employer_id = r.employer_id
    WHERE 
        lj.status = 'รอคนหางาน' 
    AND 
        lm.lineid = ?;
";
        // สร้าง query
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $userId);

        // รัน query
        $stmt->execute();
        $result = $stmt->get_result();

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
        // สามารถเพิ่ม SQL query อื่นๆ สำหรับ jobStatus อื่นๆ
        $sql = ''; // กรณีอื่นๆ
    }
} else if ($jobPost === 'โพสต์หางาน') {
    if ($jobStatus === 'รอดำเนินการ') {
        $sql = "
    SELECT 
        lj.*, 
        lm.fname, 
        lm.profile_image,
        lm.verify,
        lm.contact,
        r.rating_count, 
        r.average_rating
    FROM 
        lakhok_jobs lj
    JOIN 
        lakhok_mushroom lm 
    ON 
        lj.employee_id = lm.id
    LEFT JOIN (
        SELECT 
            employee_id,
            COUNT(rating) AS rating_count, 
            AVG(rating) AS average_rating
        FROM 
            lakhok_jobs
        WHERE 
            status = 'รอคนจ้างงาน'
        GROUP BY 
            employee_id
    ) r 
    ON 
        lj.employee_id = r.employee_id
    WHERE 
        lj.status = 'รอคนจ้างงาน' 
    AND 
        lm.lineid = ?;
";
        // สร้าง query
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $userId);

        // รัน query
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        // ส่งข้อมูลกลับไปที่ frontend ในรูปแบบ JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    } else if ($jobStatus === 'กำลังดำเนินการ') {
        $sql = "
    SELECT 
        lj.*, 
        lm.fname AS employee_name, 
        lm.profile_image,
        lm.verify,
        em.contact AS contact,
        r.rating_count, 
        r.average_rating,
        em.fname AS fname,
        CASE 
            WHEN em.lineid = ? THEN lm.lineid 
            ELSE em.lineid 
        END AS receiver_id
    FROM 
        lakhok_jobs lj
    JOIN 
        lakhok_mushroom lm 
    ON 
        lj.employee_id = lm.id
    LEFT JOIN (
        SELECT 
            employer_id,
            COUNT(rating) AS rating_count, 
            AVG(rating) AS average_rating
        FROM 
            lakhok_jobs
        WHERE 
            status = 'กำลังดำเนินการของจ้างงาน'
        GROUP BY 
            employer_id
    ) r 
    ON 
        lj.employer_id = r.employer_id
    LEFT JOIN 
        lakhok_mushroom em 
    ON 
        lj.employer_id = em.id
    WHERE 
        lj.status = 'กำลังดำเนินการของจ้างงาน' 
    AND 
        (lm.lineid = ? OR em.lineid = ?);
";
        // สร้าง query
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $userId, $userId, $userId);

        // รัน query
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        // ส่งข้อมูลกลับไปที่ frontend ในรูปแบบ JSON
        header('Content-Type: application/json');
        echo json_encode($data);

    } else if ($jobStatus === 'ดำเนินการเสร็จสิ้น') {
        $sql = "
        SELECT 
            lj.*, 
            lm.fname AS employee_name, 
            lm.profile_image,
            lm.verify,
            em.contact AS contact,
            r.rating_count, 
            r.average_rating,
            em.fname AS fname,
            CASE 
                WHEN em.lineid = ? THEN lm.lineid 
                ELSE em.lineid 
            END AS receiver_id
        FROM 
            lakhok_jobs lj
        JOIN 
            lakhok_mushroom lm 
        ON 
            lj.employee_id = lm.id
        LEFT JOIN (
            SELECT 
                employer_id,
                COUNT(rating) AS rating_count, 
                AVG(rating) AS average_rating
            FROM 
                lakhok_jobs
            WHERE 
                status = 'การดำเนินการจ้างงานเสร็จสิ้น'
            GROUP BY 
                employer_id
        ) r 
        ON 
            lj.employer_id = r.employer_id
        LEFT JOIN 
            lakhok_mushroom em 
        ON 
            lj.employer_id = em.id
        WHERE 
            lj.status = 'การดำเนินการจ้างงานเสร็จสิ้น' 
        AND 
            (lm.lineid = ? OR em.lineid = ?);
    ";
        // สร้าง query
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $userId, $userId, $userId);

        // รัน query
        $stmt->execute();
        $result = $stmt->get_result();

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
?>