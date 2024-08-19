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
            test
        </div>
    </div>
</body>

</html>