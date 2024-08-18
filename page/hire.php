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
    .text-neon-green {
        color: #1dbf72;
    }

    .search-anything {
        height: 55px;
        border-radius: 5px;
    }

    @media (max-width: 768px) {
        .search-anything {
            height: 45px;
        }
    }

    .btn-search-anything {
        width: calc(55px - 5px);
        height: calc(55px - (5px * 2));
        margin: auto 5px;
        background-color: #119356;
        color: white;
        border-radius: 5px;
    }

    .btn-color {
        background-color: #119356;
        color: white;
    }

    .btn-color:hover {
        color: white;
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
</style>

<body>
    <?php require 'assets/navbar.php' ?>
    <div class="container">
        <div class="mt-4 d-flex position-relative">
            <img class="w-100 h-auto"
                src="https://fiverr-res.cloudinary.com/image/upload/f_auto,q_auto/v1/attachments/generic_asset/asset/678686c47c024e18e773c75e90aaab1c-1705999902357/hero-xl.png"
                alt="" srcset="">
        </div>

        <div class="row mt-3 d-flex flex-row-reverse">
            <div class="col-3 d-flex ps-2 d-none d-md-flex">
                <div class="d-flex w-100">
                    <div class="m-auto w-100">
                        <div class="d-flex flex-row-reverse">
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
            <div class="col justify-content-between d-flex flex-row-reverse pe-lg-0">
                <div class="dropdown my-auto">
                    <button class="btn btn-color dropdown-toggle search-anything" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        เลือกโหมด
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="#">รอดำเนินการ</a></li>
                        <li><a class="dropdown-item" href="#">กำลังดำเนินการ</a></li>
                        <li><a class="dropdown-item" href="#">ดำเนินการเสร็จสิ้น</a></li>
                    </ul>
                </div>
                <button class="btn btn-color search-anything" type="button">
                    สร้างการจ้างงาน
                </button>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-6 col-lg-3 px-2 mt-2">
                <img class="w-100 h-auto rounded-3" src="https://placehold.co/600x400" alt="">
                <div class="px-1 w-100 mt-2 d-flex justify-content-between">
                    <div class="d-flex gap-1">
                        <img style="height: calc(45px * 65 / 100); width: auto;"
                            src="https://profile.line-scdn.net/0hvnY5-1znKUF0TAAjJORXPgQcKitXPXBTX3hgIUVLdiMadT1ECn1lIUdMcnEafWxEC39mJhNLJSR4X14nahrVdXN8dHBIeGwXUC5gow"
                            alt="">
                        <p class="h6 my-auto">Frame</p>
                    </div>
                    <p class="h6 my-auto" id="verify">ยืนยันตัวแล้ว</p>
                </div>
                <div class="px-1 mt-2">
                    <p class="fs-6 fw-normal line-clamp">หาคนมาสร้างบ้านให้หมาครับ หน้าฝนแล้วหมาไม่มีที่อยู่ ครับฟู่</p>
                </div>
                <div class="px-1 d-flex gap-1">
                    <p class="h5">ราคา</p>
                    <p class="h5" id="price">100</p>
                    <p class="h5">บาท</p>
                </div>
            </div>
            <div class="col-6 col-lg-3 px-2 mt-2">
                <img class="w-100 h-auto rounded-3" src="https://placehold.co/600x400" alt="">
                <div class="px-1 w-100 mt-2 d-flex justify-content-between">
                    <div class="d-flex gap-1">
                        <img style="height: calc(45px * 65 / 100); width: auto;"
                            src="https://profile.line-scdn.net/0hvnY5-1znKUF0TAAjJORXPgQcKitXPXBTX3hgIUVLdiMadT1ECn1lIUdMcnEafWxEC39mJhNLJSR4X14nahrVdXN8dHBIeGwXUC5gow"
                            alt="">
                        <p class="h6 my-auto">Frame</p>
                    </div>
                    <p class="h6 my-auto" id="unverify">ยังไม่ยืนยันตัว</p>
                </div>
                <div class="px-1 mt-2">
                    <p class="fs-6 fw-normal line-clamp">รับทำความสะอาดบ้าน ปัดกวาด เช็ดถู</p>
                </div>
                <div class="px-1 d-flex gap-1">
                    <p class="h5">ราคา</p>
                    <p class="h5" id="price">200</p>
                    <p class="h5">บาท</p>
                </div>
            </div>

            <div class="col-6 col-lg-3 px-2 mt-2">
                <img class="w-100 h-auto rounded-3" src="https://placehold.co/600x400" alt="">
                <div class="px-1 w-100 mt-2 d-flex justify-content-between">
                    <div class="d-flex gap-1">
                        <img style="height: calc(45px * 65 / 100); width: auto;"
                            src="https://profile.line-scdn.net/0hvnY5-1znKUF0TAAjJORXPgQcKitXPXBTX3hgIUVLdiMadT1ECn1lIUdMcnEafWxEC39mJhNLJSR4X14nahrVdXN8dHBIeGwXUC5gow"
                            alt="">
                        <p class="h6 my-auto">Frame</p>
                    </div>
                    <p class="h6 my-auto" id="unverify">ยังไม่ยืนยันตัว</p>
                </div>
                <div class="px-1 mt-2">
                    <p class="fs-6 fw-normal line-clamp">ซ่อมแซมอุปกรณ์ในบ้าน เปลี่ยนหลอดไฟ ประตูหน้าต่าง</p>
                </div>
                <div class="px-1 d-flex gap-1">
                    <p class="h5">ราคา</p>
                    <p class="h5" id="price">150</p>
                    <p class="h5">บาท</p>
                </div>
            </div>

            <div class="col-6 col-lg-3 px-2 mt-2">
                <img class="w-100 h-auto rounded-3" src="https://placehold.co/600x400" alt="">
                <div class="px-1 w-100 mt-2 d-flex justify-content-between">
                    <div class="d-flex gap-1">
                        <img style="height: calc(45px * 65 / 100); width: auto;"
                            src="https://profile.line-scdn.net/0hvnY5-1znKUF0TAAjJORXPgQcKitXPXBTX3hgIUVLdiMadT1ECn1lIUdMcnEafWxEC39mJhNLJSR4X14nahrVdXN8dHBIeGwXUC5gow"
                            alt="">
                        <p class="h6 my-auto">Frame</p>
                    </div>
                    <p class="h6 my-auto" id="verify">ยืนยันตัวแล้ว</p>
                </div>
                <div class="px-1 mt-2">
                    <p class="fs-6 fw-normal line-clamp">บริการพาสุนัขเดินเล่น ปล่อยพลังงาน และดูแลในขณะเจ้าของไม่อยู่
                    </p>
                </div>
                <div class="px-1 d-flex gap-1">
                    <p class="h5">ราคา</p>
                    <p class="h5" id="price">300</p>
                    <p class="h5">บาท</p>
                </div>
            </div>

            <div class="col-6 col-lg-3 px-2 mt-2">
                <img class="w-100 h-auto rounded-3" src="https://placehold.co/600x400" alt="">
                <div class="px-1 w-100 mt-2 d-flex justify-content-between">
                    <div class="d-flex gap-1">
                        <img style="height: calc(45px * 65 / 100); width: auto;"
                            src="https://profile.line-scdn.net/0hvnY5-1znKUF0TAAjJORXPgQcKitXPXBTX3hgIUVLdiMadT1ECn1lIUdMcnEafWxEC39mJhNLJSR4X14nahrVdXN8dHBIeGwXUC5gow"
                            alt="">
                        <p class="h6 my-auto">Frame</p>
                    </div>
                    <p class="h6 my-auto" id="verify">ยืนยันตัวแล้ว</p>
                </div>
                <div class="px-1 mt-2">
                    <p class="fs-6 fw-normal line-clamp">ให้คำปรึกษาด้านการตกแต่งบ้านและออกแบบภายใน</p>
                </div>
                <div class="px-1 d-flex gap-1">
                    <p class="h5">ราคา</p>
                    <p class="h5" id="price">500</p>
                    <p class="h5">บาท</p>
                </div>
            </div>

            <div class="col-6 col-lg-3 px-2 mt-2">
                <img class="w-100 h-auto rounded-3" src="https://placehold.co/600x400" alt="">
                <div class="px-1 w-100 mt-2 d-flex justify-content-between">
                    <div class="d-flex gap-1">
                        <img style="height: calc(45px * 65 / 100); width: auto;"
                            src="https://profile.line-scdn.net/0hvnY5-1znKUF0TAAjJORXPgQcKitXPXBTX3hgIUVLdiMadT1ECn1lIUdMcnEafWxEC39mJhNLJSR4X14nahrVdXN8dHBIeGwXUC5gow"
                            alt="">
                        <p class="h6 my-auto">Frame</p>
                    </div>
                    <p class="h6 my-auto" id="verify">ยืนยันตัวแล้ว</p>
                </div>
                <div class="px-1 mt-2">
                    <p class="fs-6 fw-normal line-clamp">ให้บริการทำอาหารมื้อพิเศษตามความต้องการของลูกค้า Lorem ipsum
                        dolor sit amet consectetur, adipisicing elit. Eius dignissimos quis facere dolore quia labore
                        nesciunt magni error ducimus odio sequi, inventore cum facilis alias earum natus cumque eveniet
                        quasi?</p>
                </div>
                <div class="px-1 d-flex gap-1">
                    <p class="h5">ราคา</p>
                    <p class="h5" id="price">700</p>
                    <p class="h5">บาท</p>
                </div>
            </div>
        </div>

        <div class="mb-3"></div>
    </div>
</body>

</html>