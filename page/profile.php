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
                <p class="h3 text-center mb-3">โปรไฟล์ผู้ใช้งาน</p>
                <img class="w-50 h-auto m-auto rounded" src="<?php echo $_SESSION["pictureUrl"] ?>" alt="" srcset="">
                <div class="mt-3 w-100">
                    <p class="h5">ชื่อผู้ใช้ :</p>
                    <input id="displayNameInput" class="form-control" type="text"
                        value="<?php echo $_SESSION['displayName']; ?>" readonly>
                </div>
                <div class="mt-3 w-100">
                    <p class="h5">เบอร์มือถือ :</p>
                    <input id="telInput" class="form-control" type="text" value="<?php echo $_SESSION['tel']; ?>"
                        readonly>
                </div>
                <div class="mt-3 w-100">
                    <p class="h5">ที่อยู่ติดต่อเพิ่มเติม :</p>
                    <input id="contactInput" class="form-control" type="text"
                        value="<?php echo $_SESSION['contact']; ?>" readonly>
                </div>
                <div class="mt-3 w-100 d-flex justify-content-center">
                    <button id="editButton" class="btn btn-primary me-2" onclick="enableEdit()">แก้ไข</button>
                    <button id="updateButton" class="btn btn-success d-none"
                        onclick="updateProfile()">อัปเดตข้อมูล</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function enableEdit() {
            // เปลี่ยน input ให้แก้ไขได้
            document.getElementById('displayNameInput').removeAttribute('readonly');
            document.getElementById('telInput').removeAttribute('readonly');
            document.getElementById('contactInput').removeAttribute('readonly');

            // แสดงปุ่มอัปเดตข้อมูลและซ่อนปุ่มแก้ไข
            document.getElementById('editButton').classList.add('d-none');
            document.getElementById('updateButton').classList.remove('d-none');
        }

        function updateProfile() {
            const displayName = document.getElementById('displayNameInput').value;
            const tel = document.getElementById('telInput').value;
            const contact = document.getElementById('contactInput').value;

            fetch('action/profile.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'displayName': displayName,
                    'tel': tel,
                    'contact': contact
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // อัปเดตข้อมูลสำเร็จ
                        // alert('ข้อมูลถูกอัปเดตเรียบร้อยแล้ว');
                        // ทำให้ input กลับเป็น read-only
                        document.getElementById('displayNameInput').setAttribute('readonly', 'readonly');
                        document.getElementById('telInput').setAttribute('readonly', 'readonly');
                        document.getElementById('contactInput').setAttribute('readonly', 'readonly');
                        // ซ่อนปุ่มอัปเดตและแสดงปุ่มแก้ไข
                        document.getElementById('editButton').classList.remove('d-none');
                        document.getElementById('updateButton').classList.add('d-none');
                    } else {
                        // แสดงข้อผิดพลาด
                        alert('เกิดข้อผิดพลาดในการอัปเดตข้อมูล');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
</body>

</html>