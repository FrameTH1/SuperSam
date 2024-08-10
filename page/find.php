<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
    <?php require 'assets/navbar.php' ?>
    <?php foreach ($jobs as $job): ?>
            <div class="job-card" data-status="รอดำเนินการ">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="h2 my-auto"><?php echo $job['title']; ?></p>
                        <p class="h5 ms-2 mt-1">นายจ้างงาน <?php echo $job['employer']; ?></p>
                    </div>
                    <p class="h6 mb-auto"><?php echo $job['postDate']; ?></p>
                </div>
                <div class="mt-5 d-flex gap-2">
                    <span class="material-symbols-outlined">
                        payments
                    </span>
                    <p class="h5">จำนวนเงิน</p>
                </div>
                <p class="h6 ms-2"><?php echo $job['price']; ?></p>
                <div class="mt-1 d-flex gap-2">
                    <span class="material-symbols-outlined">
                        pin_drop
                    </span>
                    <p class="h5">สถานที่ทำงาน</p>
                </div>
                <p class="h6 ms-2"><?php echo $job['location']; ?></p>
                <button class="w-100 h6">แก้ไขโพสต์</button>
            </div>
        <?php endforeach; ?>

        <?php foreach ($jobs as $job): ?>
            <div class="job-card" style="display:none;" data-status="กำลังดำเนินการ">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="h2 my-auto"><?php echo $job['title']; ?></p>
                        <p class="h5 ms-2 mt-1">ชื่อผู้จ้างงาน <?php echo $job['employer']; ?></p>
                    </div>
                    <p class="h6 mb-auto"><?php echo $job['postDate']; ?></p>
                </div>
                <div class="mt-5 d-flex gap-2">
                    <span class="material-symbols-outlined">
                        group
                    </span>
                    <p class="h5">ผู้ปฏิบัติงาน</p>
                </div>
                <p class="h6 ms-2"><?php echo $job['employee']; ?></p>
                <div class="mt-1 d-flex gap-2">
                    <span class="material-symbols-outlined">
                        group
                    </span>
                    <p class="h5">วันเริ่มงาน</p>
                </div>
                <p class="h6 ms-2"><?php echo $job['dueDate']; ?></p>
                <div class="mt-1 d-flex gap-2">
                    <span class="material-symbols-outlined">
                        pin_drop
                    </span>
                    <p class="h5">สถานที่ทำงาน</p>
                </div>
                <p class="h6 ms-2"><?php echo $job['location']; ?></p>
                <button class="w-100 h6">แก้ไขโพสต์</button>
            </div>
        <?php endforeach; ?>

        <?php foreach ($jobs as $job): ?>
            <div class="job-card" style="display:none;" data-status="ดำเนินการเสร็จสิ้น">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="h2 my-auto"><?php echo $job['title']; ?></p>
                        <p class="h5 ms-2 mt-1">ชื่อผู้จ้างงาน <?php echo $job['employer']; ?></p>
                    </div>
                    <div class="mb-auto">
                        <p class="h6 mb-1 text-center">สำเร็จเเล้ว</p>
                        <button class="py-1 px-2 h6">ให้คะเเนน</button>
                    </div>
                </div>
                <div class="mt-5 d-flex gap-2">
                    <span class="material-symbols-outlined">
                        group
                    </span>
                    <p class="h5">ผู้ปฏิบัติงาน</p>
                </div>
                <p class="h6 ms-2"><?php echo $job['employee']; ?></p>
                <div class="mt-1 d-flex gap-2">
                    <span class="material-symbols-outlined">
                        pin_drop
                    </span>
                    <p class="h5">สถานที่ทำงาน</p>
                </div>
                <p class="h6 ms-2"><?php echo $job['location']; ?></p>
                <button class="w-100 h6">แก้ไขโพสต์</button>
            </div>
        <?php endforeach; ?>
</body>

</html>