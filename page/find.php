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

    #verify {
        padding: 4px 6px;
        background-color: #1dbf72;
        border-radius: 25px;
    }

    #unverify {
        padding: 4px 6px;
        background-color: #FFD700;
        border-radius: 25px;
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
        <div class="mt-4 d-flex position-relative">
            <img class="w-100 h-auto"
                src="https://fiverr-res.cloudinary.com/image/upload/f_auto,q_auto/v1/attachments/generic_asset/asset/678686c47c024e18e773c75e90aaab1c-1705999902357/hero-xl.png"
                alt="" srcset="">
            <div class="d-flex position-absolute w-100 h-100">
                <div class="m-auto">
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
                    <div class="mt-2 d-flex flex-row-reverse">
                        <input class="w-100 search-anything" type="text" placeholder="พิมพ์คำค้นหา">
                        <div class="d-flex search-anything position-absolute">
                            <div class="btn-search-anything d-flex">
                                <span class="material-symbols-outlined m-auto">
                                    search
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col d-flex shadow m-2">
                <div class="m-auto d-flex flex-column align-items-center p-2">
                    <p class="h4 text-center">#1</p>
                    <p class="h5 text-center">ล้างจาน</p>
                </div>
            </div>
            <div class="col d-flex shadow m-2">
                <div class="m-auto d-flex flex-column align-items-center p-2">
                    <p class="h4 text-center">#2</p>
                    <p class="h5 text-center">ทำความสะอาด</p>
                </div>
            </div>
            <div class="col d-flex shadow m-2">
                <div class="m-auto d-flex flex-column align-items-center p-2">
                    <p class="h4 text-center">#3</p>
                    <p class="h5 text-center">ซ่อมสิ่งของ</p>
                </div>
            </div>
            <div class="col d-flex shadow m-2">
                <div class="m-auto d-flex flex-column align-items-center p-2">
                    <p class="h4 text-center">#4</p>
                    <p class="h5 text-center">ดูเเลเด็ก</p>
                </div>
            </div>
            <div class="col d-flex shadow m-2">
                <div class="m-auto d-flex flex-column align-items-center p-2">
                    <p class="h4 text-center">#5</p>
                    <p class="h5 text-center">งานทั่วไป</p>
                </div>
            </div>
            <div class="col d-flex shadow m-2">
                <div class="m-auto d-flex flex-column align-items-center p-2">
                    <p class="h4 text-center">#6</p>
                    <p class="h5 text-center">งานทั่วไป 2</p>
                </div>
            </div>
            <div class="col d-flex shadow m-2">
                <div class="m-auto d-flex flex-column align-items-center p-2">
                    <p class="h4 text-center">#7</p>
                    <p class="h5 text-center">งานทั่วไป 3</p>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <?php
            // SQL คำสั่งในการดึงข้อมูลที่ status_id เท่ากับ 1
            $sql = "
            SELECT lakhok_jobs.*, lakhok_mushroom.profile_image, lakhok_mushroom.fname , lakhok_mushroom.verify 
            FROM lakhok_jobs
            INNER JOIN lakhok_mushroom ON lakhok_jobs.employer_id = lakhok_mushroom.id 
            WHERE lakhok_jobs.status_id = 1";
            $result = $conn->query($sql);

            // ตรวจสอบและแสดงผลข้อมูล
            if ($result->num_rows > 0) {
                // วนลูปเพื่อแสดงผลข้อมูลแต่ละแถว
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-6 col-lg-3 px-2 mt-2">';
                    echo '    <img class="w-100 h-auto rounded-3" src="https://placehold.co/600x400" alt="">';
                    echo '    <div class="px-1 w-100 mt-2 d-flex justify-content-between">';
                    echo '        <div class="d-flex gap-1">';
                    echo '            <img style="height: calc(45px * 65 / 100); width: auto;" src="' . $row["profile_image"] . '" alt="">';
                    echo '            <p class="h6 my-auto text-limit">' . $row["fname"] . '</p>';
                    echo '        </div>';
                    echo '        <p class="h6 my-auto" id="' . ($row["verify"] ? "verify" : "unverify") . '">' . ($row["verify"] ? "ยืนยันแล้ว" : "ยังไม่ยืนยันตัว") . '</p>'; // ตรวจสอบการยืนยัน
                    echo '    </div>';
                    echo '    <div class="px-1 mt-2">';
                    echo '        <p class="fs-6 fw-normal line-clamp">' . $row["title"] . '</p>'; // แสดงชื่อของงาน
                    echo '    </div>';
                    echo '    <div class="px-1 d-flex">';
                    echo '        <p class="h5" id="price">ราคา ' . $row["price"] . ' บาท</p>';
                    echo '    </div>';
                    echo '</div>';
                }
            } 

            // ปิดการเชื่อมต่อ
            $conn->close();
            ?>
        </div>

        <div class="mb-3"></div>
    </div>



</body>

</html>