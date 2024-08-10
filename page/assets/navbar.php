<?php
session_start();
?>

<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<div class="container mt-3">
    <div class="d-flex justify-content-between" id="navbar">
        <ul class="d-flex list-unstyled gap-2 my-auto">
            <a href="?page=hire">
                <li class="h5 px-3 py-2 cursor-pointer" role="button">จ้างงาน</li>
            </a>
            <a href="?page=find">
                <li class="h5 px-3 py-2 cursor-pointer" role="button">หางาน</li>
            </a>
        </ul>
        <ul class="d-flex list-unstyled gap-1 my-auto">
            <li class="h5 px-3 py-2 cursor-pointer">
                <?php
                if (isset($_SESSION["displayName"])) {
                    echo "<div class='dropdown'>
                                        <button class='btn dropdown-toggle' type='button' id='dropdownMenuButtonProfile'
                                            data-bs-toggle='dropdown' aria-expanded='false'>
                                            " . $_SESSION["displayName"] . "
                                        </button>
                                        <ul class='dropdown-menu' aria-labelledby='dropdownMenuButtonProfile'>
                                            <li><a class='dropdown-item cursor-pointer' onclick='goto(".'"profile"'.");'>แก้ไขข้อมูล</a></li>
                                            <li><a class='dropdown-item cursor-pointer' onclick='goto(".'"logout"'.");'>ออกจากระบบ</a></li>
                                        </ul>
                                    </div>";
                } else {
                    echo "<a class='h5 py-2 my-auto' onclick='goto(".'"login"'.");'>เข้าสู่ระบบ</a>";
                }
                ?>
            </li>
        </ul>
    </div>
    <script>
        function goto(link) {
            window.location.href = '/?page='+link;
        }
    </script>
</div>