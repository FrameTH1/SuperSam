<?php

session_start();

include 'database.php';


// รับค่าพารามิเตอร์ status จาก URL
$status = isset($_GET['status']) ? $_GET['status'] : '';

$status_map = [
    'รอดำเนินการ' => 'รอดำเนินการ',
    'กำลังดำเนินการ' => 'กำลังดำเนินการ',
    'ดำเนินการเสร็จสิ้น' => 'ดำเนินการเสร็จสิ้น'
];

$user_id = $_SESSION["userId"];

if ($status == 'รอดำเนินการ') {
    if (array_key_exists($status, $status_map)) {
        $sql = "SELECT jobs.title, employer.display_name AS employer, jobs.price, jobs.location, jobs.post_date, jobs.due_date, jobs.employee_id 
                FROM jobs 
                JOIN users AS employer ON jobs.employer_id = employer.id 
                JOIN users ON jobs.employer_id = users.id 
                JOIN job_status ON jobs.status_id = job_status.id 
                WHERE job_status.status_name =? AND employer.user_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $status_map[$status],$user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $jobs = [];
        while ($row = $result->fetch_assoc()) {
            $jobs[] = $row;
        }

        $stmt->close();
        echo json_encode($jobs);
    } else {
        echo json_encode([]);
    }
} else if ($status == 'กำลังดำเนินการ') {
    if (array_key_exists($status, $status_map)) {
        $sql = "SELECT jobs.title, employer.display_name AS employer, employee.display_name AS employee, jobs.location, jobs.post_date, jobs.due_date 
            FROM jobs 
            JOIN users AS employer ON jobs.employer_id = employer.id 
            JOIN users AS employee ON jobs.employee_id = employee.id 
            JOIN job_status ON jobs.status_id = job_status.id 
            WHERE job_status.status_name = ? AND employer.user_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $status_map[$status], $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $jobs = [];
        while ($row = $result->fetch_assoc()) {
            $jobs[] = $row;
        }

        $stmt->close();
        echo json_encode($jobs);
    }

} else if ($status == 'ดำเนินการเสร็จสิ้น') {
    if (array_key_exists($status, $status_map)) {
        $sql = "SELECT jobs.title, employer.display_name AS employer, employee.display_name AS employee, jobs.location, jobs.post_date, jobs.due_date, jobs.rating
                FROM jobs 
                JOIN users AS employer ON jobs.employer_id = employer.id 
                JOIN users AS employee ON jobs.employee_id = employee.id 
                JOIN job_status ON jobs.status_id = job_status.id 
                WHERE job_status.status_name = ? AND employer.user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status_map[$status], $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $jobs = [];
        while ($row = $result->fetch_assoc()) {
            $jobs[] = $row;
        }

        $stmt->close();
        echo json_encode($jobs);
    }

}



$conn->close();
?>