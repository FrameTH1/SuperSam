<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<div class="container mt-3">
    <div class="d-flex justify-content-between" id="navbar">
        <ul class="ms-3 d-flex list-unstyled gap-4 my-auto">
            <a href="?page=hire">
                <li class="h5 py-2 cursor-pointer" role="button">จ้างงาน</li>
            </a>
            <a href="?page=find">
                <li class="h5 py-2 cursor-pointer" role="button">หางาน</li>
            </a>
        </ul>
        <ul class="me-3 d-flex list-unstyled gap-1 my-auto">
            <li class="h5 cursor-pointer">
                <?php
                if (isset($_SESSION["displayName"])) {
                    echo "<div class='dropdown'>
                                        <button class='btn dropdown-toggle d-flex gap-2 align-items-center' type='button' id='dropdownMenuButtonProfile'
                                            data-bs-toggle='dropdown' aria-expanded='false'>
                                            <img class='rounded-3' style='height: calc(45px * 75 / 100); width: auto;' src='". $_SESSION["pictureUrl"] ."'>" . $_SESSION["displayName"] . "
                                        </button>
                                        <ul class='dropdown-menu' aria-labelledby='dropdownMenuButtonProfile'>
                                            <li><a class='dropdown-item cursor-pointer' onclick='goto(".'"profile"'.");'>บัญชีของฉัน</a></li>
                                            <li><a class='dropdown-item cursor-pointer' onclick='goto(".'"history"'.");'>โพสต์ของฉัน</a></li>
                                            <li><a class='dropdown-item cursor-pointer' onclick='goto(".'"logout"'.");'>ออกจากระบบ</a></li>
                                        </ul>
                                    </div>";
                } else {
                    echo "<a class='h5 cursor-pointer' onclick='goto(".'"login"'.");'>เข้าสู่ระบบ</a>";
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