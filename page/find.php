<?php
session_start();

include "../action/database.php"

    ?>

<!DOCTYPE html>
<html lang="en">

<style>
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
        max-width: 100%;
        /* กำหนดความกว้างสูงสุด */
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
        max-width: 100%;
        /* กำหนดความกว้างสูงสุด */
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
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php require 'assets/navbar.php' ?>
    <div class="container">
        <div class="mt-4 d-flex position-relative image-cover">
            <img class="w-100 h-auto"
                src="https://fiverr-res.cloudinary.com/image/upload/f_auto,q_auto/v1/attachments/generic_asset/asset/678686c47c024e18e773c75e90aaab1c-1705999902357/hero-xl.png"
                alt="" srcset="">
            <div class="d-flex position-absolute w-100 h-100">
                <div class="m-auto d-flex flex-column">
                    <!-- pc -->
                    <div class="m-auto gap-2 d-none d-lg-flex">
                        <p class="h1 text-white">ค้นหางาน</p>
                        <p class="h1 text-neon-green">งานที่ใช่</p>
                        <p class="h1 text-white">ได้ใน</p>
                        <p class="h1 text-neon-green">ทันท่วงที</p>
                    </div>
                    <!-- mobile -->
                    <div class="m-auto gap-2 d-flex d-lg-none">
                        <p class="h4 text-white">ค้นหางาน</p>
                        <p class="h4 text-neon-green">ที่ใช่</p>
                        <p class="h4 text-white">ได้ใน</p>
                        <p class="h4 text-neon-green">ทันท่วงที</p>
                    </div>
                    <div class="mt-2 d-flex bg-white rounded-2">
                        <input class="w-100 me-1 search-anything fs-5" type="text" placeholder="พิมพ์คำค้นหา">
                        <div class="d-flex search-anything">
                            <div class="btn-search-anything d-flex ms-0" data-bs-toggle="modal"
                                data-bs-target="#settingsModal">
                                <span class="material-symbols-outlined m-auto" onclick="search()">
                                    settings
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex mt-3 gap-2 justify-content-center">
                        <p class="h5 text-white my-auto text-center">หรือต้องการ</p>
                        <button class="btn btn-find my-auto ms-1 me-0" type="button">
                            ประกาศหางาน
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>

            function updateButtonText(element, value) {
                document.getElementById('dropdownMenuButton').innerText = element.innerText;
                localStorage.setItem('verify', value);
            }

            // ฟังก์ชันที่เรียกใช้เมื่อกดปุ่ม Enter
            function handleEnterKey(event) {
                if (event.key === 'Enter') {
                    event.preventDefault(); // ป้องกันการส่งฟอร์ม
                    search(); // เรียกใช้ฟังก์ชันค้นหา
                }
            }

            // ฟังก์ชันค้นหาข้อมูล
            function search() {
                var searchQuery = document.querySelector('.search-anything').value;
                var verify = localStorage.getItem('verify');

                fetch('action/get_find.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'search': searchQuery,
                        'verify': verify
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        const resultsDiv = document.getElementById('results');
                        resultsDiv.innerHTML = ''; // ล้างข้อมูลเก่าออก

                        // แสดงผลข้อมูลที่ค้นหา
                        data.forEach(row => {
                            const content = `
                                <div class="col-6 col-lg-3 px-2 mt-2">
                                    <img class="w-100 h-auto rounded-3" src="https://placehold.co/600x400" alt="">
                                    <div class="px-1 w-100 mt-2 d-flex justify-content-between">
                                        <div class="d-flex gap-1">
                                            <img style="height: calc(45px * 65 / 100); width: auto;" src="${row.profile_image}" alt="">
                                            <p class="h6 my-auto text-limit">${row.fname}</p>
                                        </div>
                                        <p class="h6 my-auto" id="${row.verify == 1 ? 'verify' : 'unverify'}">${row.verify == 1 ? 'ยืนยันแล้ว' : 'ยังไม่ยืนยันตัว'}</p>
                                    </div>
                                    <div class="px-1 mt-2">
                                        <p class="fs-6 fw-normal line-clamp">${row.title}</p>
                                    </div>
                                    <div class="px-1 d-flex">
                                        <p class="h5" id="price">ราคา ${row.price} บาท</p>
                                    </div>
                                </div>
                            `;
                            resultsDiv.innerHTML += content;
                        });
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            search()

            // เพิ่ม event listener ให้ฟิลด์ค้นหา
            document.querySelector('.search-anything').addEventListener('keydown', handleEnterKey);
        </script>

        <div id="results" class="row mt-2"></div>


        <div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="settingsModalLabel">กรองการค้นหา</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="h5 text-center">การยืนยันตัวตน</p>
                        <!-- Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle w-100" type="button"
                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                ได้ทั้งสอง
                            </button>
                            <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                                <!-- ฟอร์มส่งค่า verify = 2 -->
                                <li>
                                    <input type="hidden" id="verifyValue" name="verify" value="2">
                                    <button class="dropdown-item text-center"
                                        onclick="updateButtonText(this, 2);">ได้ทั้งสอง</button>
                                </li>
                                <!-- ฟอร์มส่งค่า verify = 1 -->
                                <li>
                                    <input type="hidden" id="verifyValue" name="verify" value="1">
                                    <button class="dropdown-item text-center"
                                        onclick="updateButtonText(this, 1);">ยืนยันแล้ว</button>
                                </li>
                                <!-- ฟอร์มส่งค่า verify = 0 -->
                                <li>
                                    <input type="hidden" id="verifyValue" name="verify" value="0">
                                    <button class="dropdown-item text-center"
                                        onclick="updateButtonText(this, 0);">ยังไม่ยืนยัน</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">ยืนยัน</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3"></div>
    </div>



</body>

</html>