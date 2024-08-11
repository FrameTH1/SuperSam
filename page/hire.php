<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<?php
$jobs_type = ["รอดำเนินการ", "กำลังดำเนินการ", "ดำเนินการเสร็จสิ้น"];
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<style>
    .job-card {
        border: 1px solid #ddd;
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
    }

    .job-card button {
        background-color: #FFD700;
        border: none;
        padding: 10px;
        cursor: pointer;
    }

    .search {
        background-color: #FFD700;
    }
</style>

<body>
    <?php require 'assets/navbar.php' ?>
    <div class="container mt-4">
        <div class="d-flex justify-content-end">
            <div class="dropdown">
                <button class="btn search dropdown-toggle" type="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    เลือกการดำเนินการ
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <?php foreach ($jobs_type as $job_type): ?>
                        <li><a class="dropdown-item cursor-pointer"
                                onclick="filterJobs('<?php echo $job_type; ?>')"><?php echo $job_type; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div id="job-list"></div>


    </div>

    <script>
        function filterJobs(status) {
            var cards = document.querySelectorAll('.job-card');
            var dropdownMenuButton1 = document.querySelector('#dropdownMenuButton1');
            dropdownMenuButton1.innerHTML = status;

            const jobList = document.getElementById('job-list');
            jobList.innerHTML = '';

            fetch('../action/get_hire.php?status=' + status)
                .then(response => response.json())
                .then(data => {
                    if (status == 'รอดำเนินการ') {
                        data.forEach(job => {
                            const jobCard = document.createElement('div');
                            jobCard.classList.add('job-card');
                            jobCard.setAttribute('data-status', status);
                            jobCard.innerHTML = `
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="h2 my-auto">${job.title}</p>
                                        <p class="h5 ms-2 mt-1">นายจ้างงาน ${job.employer}</p>
                                    </div>
                                    <p class="h6 mb-auto">${job.post_date}</p>
                                </div>
                                <div class="mt-5 d-flex gap-2">
                                    <span class="material-symbols-outlined">
                                        payments
                                    </span>
                                    <p class="h5">จำนวนเงิน</p>
                                </div>
                                <p class="h6 ms-2">${job.price}</p>
                                <div class="mt-1 d-flex gap-2">
                                    <span class="material-symbols-outlined">
                                        pin_drop
                                    </span>
                                    <p class="h5">สถานที่ทำงาน</p>
                                </div>
                                <p class="h6 ms-2">${job.location}</p>
                                <button class="w-100 h6">แก้ไขโพสต์</button>
                            `;
                            jobList.appendChild(jobCard);
                        });
                    } else if (status == 'กำลังดำเนินการ') {
                        data.forEach(job => {
                            const jobCard = document.createElement('div');
                            jobCard.classList.add('job-card');
                            jobCard.setAttribute('data-status', status);
                            jobCard.innerHTML = `
                                <div class="d-flex justify-content-between">
                    <div>
                        <p class="h2 my-auto">${job.title}</p>
                        <p class="h5 ms-2 mt-1">ชื่อผู้จ้างงาน ${job.employer}</p>
                    </div>
                    <p class="h6 mb-auto">${job.post_date}</p>
                </div>
                <div class="mt-5 d-flex gap-2">
                    <span class="material-symbols-outlined">
                        group
                    </span>
                    <p class="h5">ผู้ปฏิบัติงาน</p>
                </div>
                <p class="h6 ms-2">${job.employee}</p>
                <div class="mt-1 d-flex gap-2">
                    <span class="material-symbols-outlined">
                    calendar_month
                    </span>
                    <p class="h5">วันเริ่มงาน</p>
                </div>
                <p class="h6 ms-2">${job.due_date}</p>
                <div class="mt-1 d-flex gap-2">
                    <span class="material-symbols-outlined">
                        pin_drop
                    </span>
                    <p class="h5">สถานที่ทำงาน</p>
                </div>
                <p class="h6 ms-2">${job.location}</p>
                <button class="w-100 h6">ดูรายละเอียด</button>
                            `;
                            jobList.appendChild(jobCard);
                        });
                    } else if (status == 'ดำเนินการเสร็จสิ้น') {
                        data.forEach(job => {
                            const jobCard = document.createElement('div');
                            jobCard.classList.add('job-card');
                            jobCard.setAttribute('data-status', status);
                            jobCard.innerHTML = `
                                <div class="d-flex justify-content-between">
                    <div>
                        <p class="h2 my-auto">${job.title}</p>
                        <p class="h5 ms-2 mt-1">ชื่อผู้จ้างงาน ${job.employer}</p>
                    </div>
                    <div class="mb-auto" id="rating">
                    </div>
                </div>
                <div class="mt-5 d-flex gap-2">
                    <span class="material-symbols-outlined">
                        group
                    </span>
                    <p class="h5">ผู้ปฏิบัติงาน</p>
                </div>
                <p class="h6 ms-2">${job.employee}</p>
                <div class="mt-1 d-flex gap-2">
                    <span class="material-symbols-outlined">
                        pin_drop
                    </span>
                    <p class="h5">สถานที่ทำงาน</p>
                </div>
                <p class="h6 ms-2">${job.location}</p>
                <button class="w-100 h6">ดูรายละเอียด</button>
                            `;
                            jobList.appendChild(jobCard);
                            if (job.rating == undefined) {
                                jobCard.querySelector('#rating').innerHTML = '<p class="h6 mb-1 text-center text-danger">สำเร็จเเล้ว</p><button class="py-1 px-2 h6 rounded">ให้คะเเนน</button>'
                            } else {
                                jobCard.querySelector('#rating').innerHTML = '<p class="h6 mb-1 text-center text-danger">ให้คะเเนนเเล้ว</p>'
                            }
                        }
                        )
                    }

                })


            cards.forEach(function (card) {
                if (card.getAttribute('data-status') === status) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });

        }

        filterJobs('รอดำเนินการ');
    </script>

</body>

</html>