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
    .editable {
        display: none;
    }

    .custom-wrap {
        word-wrap: break-word;
        /* ใช้สำหรับการตัดคำ */
        overflow-wrap: break-word;
        /* ใช้สำหรับการห่อคำ */
    }
</style>

<body>
    <?php require 'assets/navbar.php' ?>
    <div class="container">
        <div class="mt-4 d-flex">
            <div class="m-auto d-flex flex-column align-items-center">
                <img class="w-25 h-auto m-auto rounded" src="<?php echo $_SESSION["pictureUrl"] ?>" alt="" srcset="">
                <div class="mt-3 w-100">
                    <p class="h5">ชื่อผู้ใช้ :</p>
                    <input id="displayNameInput" class="form-control" type="text"
                        value="<?php echo $_SESSION['displayName']; ?>" readonly>
                </div>
                <div class="mt-3 w-100">
                    <p class="h5">เบอร์มือถือ :</p>
                    <input id="displayNameInput" class="form-control" type="text"
                        value="<?php echo $_SESSION['tel']; ?>" readonly>
                </div>
                <div class="mt-3 w-100">
                    <p class="h5">ที่อยู่ติดต่อเพิ่มเติม :</p>
                    <input id="displayNameInput" class="form-control" type="text"
                        value="<?php echo $_SESSION['contact']; ?>" readonly>
                </div>
            </div>
        </div>
    </div>
</body>

</html>