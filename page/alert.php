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
        width: 0px;
        /* ความกว้างของ scrollbar */
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
        <form id="alertForm" enctype="multipart/form-data" method="POST">
            <div class="mt-4 row d-flex flex-row-reverse">
                <div class="col-5 col-lg-2 ps-1">
                    <select class="form-select" id="alertStatus" name="alertStatus">
                        <option value="ยังไม่ได้อ่าน">ไม่ระบุ</option>
                        <option value="ยังไม่ได้อ่าน">ยังไม่ได้อ่าน</option>
                        <option value="อ่านเเล้ว">อ่านเเล้ว</option>
                    </select>
                </div>
            </div>
        </form>

        <div class="w-100 mt-3" id="results"></div>

        <script>

            var results = document.getElementById('results');

            fetch('action/check_read_chat.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
                .then(response => response.json())
                .then(data => {
                    data.forEach(function (chat) {
                        var alertElement = document.createElement('div');

                        if (chat.sender_id == '<?php echo $_SESSION["userId"] ?>') {
                            if (chat.already_read == 1) {
                                alertElement.classList.add('jobAlert', 'alert', 'alert-success', 'w-100');
                            } else {
                                alertElement.classList.add('jobAlert', 'alert', 'alert-warning', 'w-100');
                                alertElement.addEventListener('click', function () {
                                    var job_id = this.getAttribute('job_id');

                                    fetch('action/check_chat_alert.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded'
                                        },
                                        body: new URLSearchParams({
                                            job_id: job_id
                                        })
                                    })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.status === 'รอคนหางาน' || data.status === 'กำลังดำเนินการของหางาน') {
                                                window.location.href = '/?page=find&job=' + chat.job_id + '&id=' + chat.receiver_id;
                                            } else if (data.status === 'รอคนจ้างงาน' || data.status === 'กำลังดำเนินการของจ้างงาน') {
                                                window.location.href = '/?page=hire&job=' + chat.job_id + '&id=' + chat.receiver_id;
                                            } else {
                                                console.error('Unknown status:', data.status);
                                            }
                                        })
                                        .catch((error) => {
                                            console.error('Error:', error);
                                        });
                                });

                            }

                            alertElement.setAttribute('job_id', `${chat.job_id}`);
                            alertElement.setAttribute('role', 'alert');
                            alertElement.innerHTML = `
                            <p class="h5">หัวข้อ : มีข้อความใหม่ !</p>
                            <p class="h6">ที่มา : ${chat.title}</p>
                            `;
                            results.appendChild(alertElement);
                        }else if (chat.receiver_id == '<?php echo $_SESSION["userId"] ?>') {
                            if (chat.already_read == 1) {
                                alertElement.classList.add('jobAlert', 'alert', 'alert-success', 'w-100');
                            } else {
                                alertElement.classList.add('jobAlert', 'alert', 'alert-warning', 'w-100');
                                alertElement.addEventListener('click', function () {
                                    var job_id = this.getAttribute('job_id');

                                    fetch('action/check_chat_alert.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded'
                                        },
                                        body: new URLSearchParams({
                                            job_id: job_id
                                        })
                                    })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.status === 'รอคนหางาน') {
                                                window.location.href = '/?page=find&job=' + chat.job_id + '&id=' + chat.receiver_id;
                                            } else if (data.status === 'รอคนจ้างงาน') {
                                                window.location.href = '/?page=hire&job=' + chat.job_id + '&id=' + chat.receiver_id;
                                            } else {
                                                console.error('Unknown status:', data.status);
                                            }
                                        })
                                        .catch((error) => {
                                            console.error('Error:', error);
                                        });
                                });

                            }

                            alertElement.setAttribute('job_id', `${chat.job_id}`);
                            alertElement.setAttribute('role', 'alert');
                            alertElement.innerHTML = `
                            <p class="h5">หัวข้อ : มีข้อความใหม่ !</p>
                            <p class="h6">ที่มา : ${chat.title}</p>
                            `;
                            results.appendChild(alertElement);
                        }
                    });
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        </script>
    </div>
</body>

</html>