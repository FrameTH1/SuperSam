<?php
session_start();
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

    .text-wrap-category {
        word-break: break-all;
        white-space: normal;
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
                    <div class="d-flex m-auto gap-2">
                        <p class="h1 text-white">ค้นหางาน</p>
                        <p class="h1 text-neon-green">ที่ใช่</p>
                        <p class="h1 text-white">ได้ใน</p>
                        <p class="h1 text-neon-green">ทันท่วงที</p>
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
                    <span class="material-symbols-outlined fs-1">
                        screen_search_desktop
                    </span>
                    <p class="h5">ล้างจาน</p>
                </div>
            </div>
            <div class="col d-flex shadow m-2">
                <div class="m-auto d-flex flex-column align-items-center p-2">
                    <span class="material-symbols-outlined fs-1">
                        screen_search_desktop
                    </span>
                    <p class="h5 text-wrap-category">ทำความสะอาด</p>
                </div>
            </div>
            <div class="col d-flex shadow m-2">
                <div class="m-auto d-flex flex-column align-items-center p-2">
                    <span class="material-symbols-outlined fs-1">
                        screen_search_desktop
                    </span>
                    <p class="h5">ซ่อมสิ่งของ</p>
                </div>
            </div>
            <div class="col d-flex shadow m-2">
                <div class="m-auto d-flex flex-column align-items-center p-2">
                    <span class="material-symbols-outlined fs-1">
                        screen_search_desktop
                    </span>
                    <p class="h5">ดูเเลเด็ก</p>
                </div>
            </div>
            <div class="col d-flex shadow m-2">
                <div class="m-auto d-flex flex-column align-items-center p-2">
                    <span class="material-symbols-outlined fs-1">
                        screen_search_desktop
                    </span>
                    <p class="h5">งานทั่วไป</p>
                </div>
            </div>
            <div class="col d-flex shadow m-2">
                <div class="m-auto d-flex flex-column align-items-center p-2">
                    <span class="material-symbols-outlined fs-1">
                        screen_search_desktop
                    </span>
                    <p class="h5">งานทั่วไป 2</p>
                </div>
            </div>
            <div class="col d-flex shadow m-2">
                <div class="m-auto d-flex flex-column align-items-center p-2">
                    <span class="material-symbols-outlined fs-1">
                        screen_search_desktop
                    </span>
                    <p class="h5">งานทั่วไป 3</p>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <p class="fs-5">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quasi perferendis aut sit? Enim quae ratione ipsum illo vitae vel excepturi temporibus, quidem quod corporis sed labore quasi! Atque, itaque neque. Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus perspiciatis commodi dolorem omnis beatae vitae officiis deserunt, cumque quidem nesciunt magni! Dolorum facere quod quo animi doloremque atque consequatur ratione. Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur cum praesentium similique, corporis officiis odit, adipisci animi saepe rerum reprehenderit optio quas! Totam modi ex dolores voluptatem at accusamus officiis. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquid natus placeat veritatis culpa nulla facere quo molestiae eaque, nisi libero maiores hic deleniti numquam, quas praesentium aperiam quis expedita quia!</p>
        </div>
    </div>


</body>

</html>