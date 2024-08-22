<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<style>
    .card {
        border-color: black;
        border-width: 1px;
        max-height: 310px;
        overflow-y: scroll;
    }

    .card::-webkit-scrollbar {
        width: 0px; /* ความกว้างของ scrollbar */
    }

    .text-neon-green {
        color: #1dbf72;
    }

    .text-dark-green {
        color: #126f43;
    }

    .search-anything {
        height: 55px;
        border-radius: 5px;
    }

    .btn-search-anything {
        width: calc(55px - 5px);
        height: calc(55px - (5px * 2));
        margin: auto 5px;
        background-color: #126f43;
        color: white;
        border-radius: 5px;
    }

    .bg-color-search {
        background-color: #126f43;
    }

    .image-cover {
        min-height: 225px;
    }

    .image-cover img {
        object-fit: cover;
    }

    .btn-find {
        color: #126f43;
        background-color: white;
    }

    input {
        border-color: transparent;
    }

    input:focus {
        outline: none;
        box-shadow: none;
    }

    #verify {
        padding: 4px 6px;
        background-color: #1dbf72;
        border-radius: 25px;
        white-space: nowrap;
        /* ไม่ให้ข้อความขึ้นบรรทัดใหม่ */
        overflow: hidden;
        /* ซ่อนข้อความที่ยาวเกิน */
        text-overflow: ellipsis;
        /* เพิ่มจุดไข่ปลา (...) */
    }

    #unverify {
        padding: 4px 6px;
        background-color: #FFD700;
        border-radius: 25px;
        white-space: nowrap;
        /* ไม่ให้ข้อความขึ้นบรรทัดใหม่ */
        overflow: hidden;
        /* ซ่อนข้อความที่ยาวเกิน */
        text-overflow: ellipsis;
        /* เพิ่มจุดไข่ปลา (...) */
    }

    .line-clamp {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        /* จำนวนบรรทัดที่ต้องการแสดง */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    @media (max-width: 767px) {
        .text-limit {
            display: inline-block;
            width: 6ch;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    }

    .img {
        height: 200px;
        object-fit: cover;
    }

    .Stars {
        --percent: calc(var(--rating) / 5 * 100%);

        display: inline-block;
        font-family: Times; // make sure ★ appears correctly
        line-height: 1;
        margin: auto 0;

        &::before {
            content: '★★★★★';
            letter-spacing: 3px;
            background: linear-gradient(90deg, #fc0 var(--percent), #DADADA var(--percent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    }

    #star {
        color: #fc0;
    }

    #suggestions div {
        padding: 10px;
        cursor: pointer;
        border-bottom: 1px solid #ddd;
    }

    #suggestions div:hover {
        background-color: #f0f0f0;
    }

    .select_bar_width {
        width: calc(100% - (16px * 2));
    }
</style>

<body>
    <?php require 'assets/navbar.php' ?>
    <div class="container">
        <form id="jobForm" enctype="multipart/form-data" method="POST">
            <div class="mt-4 row d-flex flex-row-reverse">
                <div class="col-5 col-lg-2 ps-1">
                    <select class="form-select" id="jobStatus" name="jobStatus">
                        <option value="รอดำเนินการ">รอดำเนินการ</option>
                        <option value="กำลังดำเนินการ">กำลังดำเนินการ</option>
                        <option value="ดำเนินการเสร็จสิ้น">ดำเนินการเสร็จสิ้น</option>
                    </select>
                </div>

                <div class="col-5 col-lg-2 pe-1">
                    <select class="form-select" id="jobPost" name="jobPost">
                        <option value="โพสต์จ้างงาน">โพสต์จ้างงาน</option>
                        <option value="โพสต์หางาน">โพสต์หางาน</option>
                    </select>
                </div>
            </div>
        </form>

        <div id="results" class="row mt-3"></div>

        <script>
            const form = document.getElementById('jobForm');
            const formData = new FormData(form);

            fetch('action/get_history.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    // แสดงผลข้อมูลที่ค้นหา
                    data.forEach(row => {
                        // คำนวณค่า rating
                        const rating = row.rating || 0;

                        // สร้าง HTML element สำหรับแต่ละรายการ
                        const itemHTML = `
                                    <div class="col-6 col-lg-3 mt-2 mb-1">
                                   <div class="shadow card p-3">
                                     <img class="w-100 img rounded-3" src="${row.img}" alt="">
                                    <div class="px-1 mt-2">
                                        <p class="h6 fw-normal line-clamp">ชื่องาน : ${row.title}</p>
                                    </div>
                                    <div class="px-1 d-flex">
                                        <p class="h5" id="price">ราคา : ${row.price} บาท</p>
                                    </div>
                                   </div>
                                </div>
                                `;
                        document.getElementById('results').insertAdjacentHTML('beforeend', itemHTML);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                });

            document.querySelectorAll('#jobForm select').forEach(function (element) {
                element.addEventListener('change', function () {

                    document.getElementById('results').innerHTML = "";

                    const form = document.getElementById('jobForm');
                    const formData = new FormData(form);

                    fetch('action/get_history.php', {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            // แสดงผลข้อมูลที่ค้นหา
                            data.forEach(row => {
                                // คำนวณค่า rating
                                const rating = row.rating || 0;

                                // สร้าง HTML element สำหรับแต่ละรายการ
                                const itemHTML = `
                                    <div class="col-6 col-lg-3 mt-2 mb-2">
                                   <div class="shadow card p-3" onclick="openModal('${row.title}', '${row.img}', '${row.price}', '${row.fname}', '${rating}', '${row.rating_count}', '${row.profile_image}', '${row.verify}', '${row.contact}', '${row.description}', '` + JSON.parse(row.types) + `')">
                                     <img class="w-100 img rounded-3" src="${row.img}" alt="">
                                    <div class="px-1 mt-2">
                                        <p class="h6 fw-normal line-clamp">ชื่องาน : ${row.title}</p>
                                    </div>
                                    <div class="px-1 d-flex">
                                        <p class="h5" id="price">ราคา : ${row.price} บาท</p>
                                    </div>
                                   </div>
                                </div>
                                `;
                                document.getElementById('results').insertAdjacentHTML('beforeend', itemHTML);
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
        </script>
    </div>
</body>

</html>