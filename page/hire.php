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
    .card {
        border-color: black;
        border-width: 1px;
        max-height: 350px;
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
        min-height: 200px;
        max-height: 200px;
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

    .text-black {
        color: black !important;
    }
</style>

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
                        <p class="h1 text-white">ค้นหาผู้รับจ้าง</p>
                        <p class="h1 text-neon-green">ที่ใช่</p>
                        <p class="h1 text-white">ได้ใน</p>
                        <p class="h1 text-neon-green">ทันท่วงที</p>
                    </div>
                    <!-- mobile -->
                    <div class="m-auto gap-2 d-flex d-lg-none">
                        <p class="h4 text-white">ค้นหาผู้รับจ้าง</p>
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
                        <button class="btn btn-find my-auto ms-1 me-0" type="button" data-bs-toggle="modal"
                            data-bs-target="#hireModal">
                            ประกาศจ้างงาน
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>

            function updateButtonText(element, value) {
                document.getElementById('dropdownMenuButton').innerText = element.innerText;
                localStorage.setItem('hire_verify', value);
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
                var verify = localStorage.getItem('hire_verify');

                fetch('action/get_hire.php', {
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
                            const rating = row.average_rating; // ค่าคะแนนเฉลี่ยจากฐานข้อมูล
                            const max_rating = 5.0000; // ค่าคะแนนสูงสุด
                            const percentage = (rating / max_rating) * 100; // คำนวณเป็นเปอร์เซ็นต์
                            const content = `
                                <div class="col-6 col-lg-3 px-2 mt-2">
                                    <div class="shadow card" onclick="openModal('${row.title}', '${row.img}', '${row.price}', '${row.fname}', '${rating}', '${row.rating_count}', '${row.profile_image}', '${row.verify}', '${row.contact}', '${row.description}', '` + JSON.parse(row.types) + `', '${row.id}', '${row.employee_id}', '${row.id_post}')">
                                        <img class="w-100 img rounded-3" src="${row.img}" alt="">
                                        <div class="px-1">
                                            <div class="px-1 w-100 mt-2 d-flex justify-content-between">
                                                <div class="d-flex gap-1">
                                                    <img style="height: calc(45px * 65 / 100); width: auto;" src="${row.profile_image}" alt="">
                                                    <p class="h6 my-auto text-limit">${row.fname}</p>
                                                </div>
                                                <div class="d-none d-sm-flex">
                                                    <div class="Stars" style="--rating: ` + checkValue2(rating) + `;"></div>
                                                    <p class="h6 my-auto">( ${row.rating_count} โหวต )</p>
                                                </div>
                                                <div class="d-flex d-sm-none gap-1">
                                                    <p class="h6 my-auto">`+ (isNaN(parseFloat(checkValue2(rating)).toFixed(1)) ? "" : parseFloat(parseFloat(checkValue2(rating)).toFixed(1))) + `</p>
                                                    `+ (parseFloat(checkValue2(rating)) >= 0 ? '<div class="my-auto" id="star">★</div>' : '') + `
                                                </div>
                                            </div>
                                            <div class="px-1 mt-2">
                                                <div class="d-flex gap-2">
                                                    <p class="h6 my-auto w-auto" id="${row.verify == 1 ? 'verify' : 'unverify'}">${row.verify == 1 ? 'ยืนยันตัวแล้ว' : 'ยังไม่ยืนยันตัว'}</p>
                                                </div>
                                            </div>
                                            <div class="px-1 mt-2">
                                                <p class="fs-6 fw-normal line-clamp">${row.title}</p>
                                            </div>
                                            <div class="px-1 d-flex">
                                                <p class="h5" id="price">ราคา ${row.price} บาท</p>
                                            </div>
                                        </div>
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

        <!-- Modal Structure -->
        <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="infoModalLabel">รายละเอียด</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- เนื้อหาของ popup -->
                        <img id="modal-img" class="w-100 img rounded-3 mb-3" src="" alt="">
                        <h4 id="modal-title"></h4>
                        <hr>
                        <p class="h6" id="modal-fname"></p>
                        <div class="d-flex gap-1 mb-2">
                            <p class="h6 my-auto">คะแนนผู้หางาน : </p>
                            <div class="d-flex">
                                <div class="Stars my-auto" id="modal-stars" style="--rating: 0;"></div>
                                <p class="my-auto h6" id="modal-rating-count"></p>
                            </div>
                        </div>
                        <p class="h6" id="modal-contact"></p>
                        <hr>
                        <p class="h6" id="modal-type"></p>
                        <p class="h6" id="modal-description"></p>
                        <p class="h6" id="modal-price"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning btn-contact text-black" data-bs-toggle="modal" data-bs-target="#chatModal"
                            data-bs-dismiss="modal">ติดต่อผู้หางาน</button>
                        <button type="button" class="btn btn-success btn-confirm text-black">จ้างงาน</button>
                    </div>
                </div>
            </div>
        </div>

        <script>

            function checkValue(input) {
                return input === '' | input === 'null' ? 'ไม่ได้ระบุ' : input;
            }

            function checkValue2(input) {
                return input === null | input === 'null' ? 0 : input;
            }

            function openModal(title, img, price, fname, rating, rating_count, profile_image, verify, contact, description, array_type, id, employee_id, id_post) {

                console.log(array_type);
                localStorage.setItem('id_post_hire', id_post);
                localStorage.setItem('employee_id_post_hire', id);
                localStorage.setItem('fname', fname);

                document.getElementById('modal-title').innerText = title;
                document.getElementById('modal-img').src = img;
                document.getElementById('modal-fname').innerText = 'ชื่อผู้หางาน : ' + fname;
                document.getElementById('modal-stars').style.setProperty('--rating', checkValue2(rating));
                document.getElementById('modal-rating-count').innerText = `( ${rating_count} โหวต )`;
                document.getElementById('modal-contact').innerText = 'ข้อมูลติดต่อผู้หางาน : ' + `${checkValue(contact)}`;

                document.getElementById('modal-type').innerText = 'หมวดหมู่งาน : ' + `${checkValue(array_type)}`;
                document.getElementById('modal-description').innerText = 'รายละเอียดงาน : ' + `${checkValue(description)}`;
                document.getElementById('modal-price').innerText = 'ราคา : ' + `${price} บาท`;

                // ตรวจสอบว่า id ตรงกับ $_SESSION["userId"] หรือไม่
                var sessionUserId = <?php echo json_encode($_SESSION["userId"]); ?>;
                var contactButton = document.querySelector('.btn-contact');
                var confirmButton = document.querySelector('.btn-confirm');

                if (id !== sessionUserId) {
                    contactButton.disabled = false;
                    confirmButton.disabled = false;
                } else {
                    contactButton.disabled = true;
                    confirmButton.disabled = true;
                }

                // แสดง Modal
                var myModal = new bootstrap.Modal(document.getElementById('infoModal'));
                myModal.show();
            }
        </script>

        <div id="results" class="row mt-2"></div>

        <!-- Chat Modal -->
        <div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="chatModalLabel">
                            แชทกับ
                            <button class="btn btn-primary ms-1 rounded" id="refreshButton">รีเฟรชแชท</button>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- แสดงข้อความแชท -->
                        <div id="chatMessages" style="max-height: 300px; overflow-y: auto;">
                            <!-- ตัวอย่างข้อความ -->
                            <!-- <div class="d-flex justify-content-start mb-2">
                                <div class="p-2 bg-light rounded">ข้อความของผู้รับ</div>
                            </div>
                            <div class="d-flex justify-content-end mb-2">
                                <div class="p-2 bg-light rounded">ข้อความของผู้ส่ง</div>
                            </div> -->
                        </div>
                        <!-- ช่องพิมพ์ข้อความ -->
                        <div class="input-group mt-3">
                            <input type="text" id="chatInput" class="form-control"
                                placeholder="พิมพ์ข้อความของคุณที่นี่...">
                            <button class="btn btn-success me-1" id="sendButton">ส่ง</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>

            document.getElementById('refreshButton').addEventListener('click', function () {
                var job_id = localStorage.getItem('id_post_hire'); // ระบุ job_id ของงานนั้นๆ

                if (getParameterByName('job') != null & getParameterByName('id') != null) {
                    var sender_id = '<?php echo $_SESSION["userId"] ?>'; // ใส่ค่า sender_id ของคุณ
                    var receiver_id = getParameterByName('id'); // ใส่ค่า receiver_id ของคุณ
                } else {
                    var sender_id = '<?php echo $_SESSION["userId"] ?>'; // ใส่ค่า sender_id ของคุณ
                    var receiver_id = localStorage.getItem('employee_id_post_hire'); // ใส่ค่า receiver_id ของคุณ
                }

                var chatMessages = document.getElementById('chatMessages');
                chatMessages.innerHTML = ''; // ล้างข้อความเก่าออกก่อน

                // ดึงประวัติการแชทจากฐานข้อมูล
                fetch('action/load_chat.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        sender_id: sender_id,
                        receiver_id: receiver_id,
                        job_id: job_id
                    })
                })
                    .then(response => response.json()) // สมมติว่าเซิร์ฟเวอร์ส่ง JSON กลับมา
                    .then(data => {
                        data.forEach(function (chat) {
                            var messageElement = document.createElement('div');
                            if (chat.receiver_id == sender_id) {
                                messageElement.classList.add('d-flex', 'justify-content-end', 'mb-2');
                                messageElement.innerHTML = '<div class="p-2 bg-light rounded">' + chat.message + '</div>';
                            } else {
                                messageElement.classList.add('d-flex', 'justify-content-start', 'mb-2');
                                messageElement.innerHTML = '<div class="p-2 bg-light rounded">' + chat.message + '</div>';
                            }
                            chatMessages.appendChild(messageElement);
                        });
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            });


            document.getElementById('chatModal').addEventListener('shown.bs.modal', function () {
                var job_id = localStorage.getItem('id_post_hire'); // ระบุ job_id ของงานนั้นๆ

                if (getParameterByName('job') == null & getParameterByName('id') == null) {
                    var sender_id = '<?php echo $_SESSION["userId"] ?>'; // ใส่ค่า sender_id ของคุณ
                    var receiver_id = localStorage.getItem('employee_id_post_hire'); // ใส่ค่า receiver_id ของคุณ

                    // ดึงประวัติการแชทจากฐานข้อมูล
                    fetch('action/load_chat.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            sender_id: sender_id,
                            receiver_id: receiver_id,
                            job_id: job_id
                        })
                    })
                        .then(response => response.json()) // สมมติว่าเซิร์ฟเวอร์ส่ง JSON กลับมา
                        .then(data => {
                            data.forEach(function (chat) {
                                var messageElement = document.createElement('div');
                                if (chat.receiver_id == sender_id) {
                                    messageElement.classList.add('d-flex', 'justify-content-end', 'mb-2');
                                    messageElement.innerHTML = '<div class="p-2 bg-light rounded">' + chat.message + '</div>';
                                } else {
                                    messageElement.classList.add('d-flex', 'justify-content-start', 'mb-2');
                                    messageElement.innerHTML = '<div class="p-2 bg-light rounded">' + chat.message + '</div>';
                                }
                                chatMessages.appendChild(messageElement);
                            });
                            chatMessages.scrollTop = chatMessages.scrollHeight;
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                        });
                } else {
                    var sender_id = '<?php echo $_SESSION["userId"] ?>'; // ใส่ค่า sender_id ของคุณ
                    var receiver_id = getParameterByName('id'); // ใส่ค่า receiver_id ของคุณ
                }

                var fname = localStorage.getItem('fname');

                fname = fname != null ? "ผู้หางาน" : "";

                var chatMessages = document.getElementById('chatMessages');
                chatMessages.innerHTML = ''; // ล้างข้อความเก่าออกก่อน

                const chatModalTitle = document.getElementById("chatModalLabel");
                chatModalTitle.childNodes.forEach(node => {
                    if (node.nodeType === Node.TEXT_NODE && node.nodeValue.trim() === "แชทกับ") {
                        node.nodeValue = "แชทกับ" + fname;
                    }
                });
            });


            document.getElementById('sendButton').addEventListener('click', function () {
                var message = document.getElementById('chatInput').value;
                var job_id = localStorage.getItem('id_post_hire'); // ระบุ job_id ของงานนั้นๆ

                if (getParameterByName('job') == null & getParameterByName('id') == null) {
                    var sender_id = localStorage.getItem('employee_id_post_hire'); // ใส่ค่า sender_id ของคุณ
                    var receiver_id = '<?php echo $_SESSION["userId"] ?>'; // ใส่ค่า receiver_id ของคุณ
                } else {
                    var sender_id = getParameterByName('id'); // ใส่ค่า sender_id ของคุณ
                    var receiver_id = '<?php echo $_SESSION["userId"] ?>'; // ใส่ค่า receiver_id ของคุณ
                }

                if (message.trim() !== '') {
                    // แสดงข้อความในหน้าจอแชท
                    var chatMessages = document.getElementById('chatMessages');
                    var messageElement = document.createElement('div');
                    messageElement.classList.add('d-flex', 'justify-content-end', 'mb-2');
                    messageElement.innerHTML = '<div class="p-2 bg-light rounded">' + message + '</div>';
                    chatMessages.appendChild(messageElement);

                    // ส่งข้อมูลไปยังเซิร์ฟเวอร์เพื่อบันทึกในฐานข้อมูลด้วย fetch API
                    fetch('action/save_chat.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            message: message,
                            sender_id: sender_id,
                            receiver_id: receiver_id,
                            job_id: job_id
                        })
                    })
                        .then(response => response.text()) // เปลี่ยนเป็น response.json() ถ้าคุณส่ง JSON กลับ
                        .then(data => {
                            chatMessages.scrollTop = chatMessages.scrollHeight;
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                        });

                    // ล้างช่องข้อความ
                    document.getElementById('chatInput').value = '';
                }
            });

            function getParameterByName(name) {
                const url = new URL(window.location.href);
                return url.searchParams.get(name);
            }

            if (getParameterByName('job') != null & getParameterByName('id') != null) {
                var message = document.getElementById('chatInput').value;
                var job_id = getParameterByName('job');
                var sender_id = '<?php echo $_SESSION["userId"] ?>'; // ใส่ค่า sender_id ของคุณ
                var receiver_id = getParameterByName('id'); // ใส่ค่า receiver_id ของคุณ

                localStorage.setItem('id_post_hire', job_id);
                localStorage.setItem('employee_id_post_hire', sender_id);

                var chatModal = new bootstrap.Modal(document.getElementById('chatModal'));
                chatModal.show();

                var chatMessages = document.getElementById('chatMessages');
                chatMessages.innerHTML = ''; // ล้างข้อความเก่าออกก่อน

                // ดึงประวัติการแชทจากฐานข้อมูล
                fetch('action/load_chat.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        sender_id: sender_id,
                        receiver_id: receiver_id,
                        job_id: job_id
                    })
                })
                    .then(response => response.json()) // สมมติว่าเซิร์ฟเวอร์ส่ง JSON กลับมา
                    .then(data => {
                        data.forEach(function (chat) {
                            var messageElement = document.createElement('div');
                            if (chat.receiver_id == sender_id) {
                                messageElement.classList.add('d-flex', 'justify-content-end', 'mb-2');
                                messageElement.innerHTML = '<div class="p-2 bg-light rounded">' + chat.message + '</div>';
                            } else {
                                messageElement.classList.add('d-flex', 'justify-content-start', 'mb-2');
                                messageElement.innerHTML = '<div class="p-2 bg-light rounded">' + chat.message + '</div>';
                            }
                            chatMessages.appendChild(messageElement);
                        });
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            };
        </script>

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
                                ไม่ระบุ
                            </button>
                            <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                                <!-- ฟอร์มส่งค่า verify = 2 -->
                                <li>
                                    <input type="hidden" id="verifyValue" name="verify" value="2">
                                    <button class="dropdown-item text-center"
                                        onclick="updateButtonText(this, 2);">ไม่ระบุ</button>
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

        <div class="modal fade" id="hireModal" tabindex="-1" aria-labelledby="hireModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="hireModalLabel">ประกาศจ้างงาน</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="jobForm" enctype="multipart/form-data" method="POST">
                        <div class="modal-body">
                            <p class="h5 text-center">แนบรูปภาพ</p>
                            <input class="form-control" accept=".png, .jpg, .jpeg" type="file" id="jobImage"
                                name="jobImage" accept="image/*" required>
                            <p class="h5 mt-2 text-center">ชื่อของงาน</p>
                            <input class="form-control" type="text" id="jobTitle" name="jobTitle"
                                placeholder="ชื่อของงานที่ต้องทำ" required>
                            <p class="h5 mt-2 text-center">รายละเอียดงาน</p>
                            <textarea class="form-control" name="jobDescription" id="jobDescription"
                                placeholder="ควรใส่รายละเอียดให้ผู้อ่านเข้าใจได้ง่าย" rows="3" required></textarea>
                            <p class="h5 mt-2 text-center">ราคาที่ต้องการ</p>
                            <div class="d-flex gap-2">
                                <div class="row w-100">
                                    <div class="col-4 pe-1">
                                        <!-- Dropdown -->
                                        <select class="form-select" id="priceType" name="priceType">
                                            <option value="ทั้งหมด">ทั้งหมด</option>
                                            <option value="เริ่มต้น">เริ่มต้น</option>
                                            <option value="จุดละ">จุดละ</option>
                                        </select>
                                    </div>
                                    <div class="col-8 ps-1">
                                        <!-- Input -->
                                        <input class="form-control" type="number" id="jobPrice" name="jobPrice"
                                            placeholder="ราคาที่ต้องการ" step="1" required>
                                    </div>
                                </div>
                                <p class="h5 my-auto">บาท</p>
                            </div>
                            <p class="h5 mt-2 text-center">หมวดหมู่ของงาน</p>
                            <div>
                                <button class="btn btn-secondary dropdown-toggle w-100" type="button"
                                    id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                    เลือกหมวดหมู่
                                </button>
                                <ul class="dropdown-menu select_bar_width" aria-labelledby="dropdownMenuButton2"
                                    id="dropdownList">
                                </ul>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" onclick="submitJobForm()">ส่งประกาศ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            fetch('action/get_tag.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    updateDropdown(data);
                })
                .catch(error => console.error('Fetch error:', error));

            function updateDropdown(data) {
                const list = document.getElementById('dropdownList');
                list.innerHTML = ''; // Clear existing items
                data.forEach(item => {
                    const li = document.createElement('li');
                    li.innerHTML = `<input type="hidden" value='${item}' name="type">
                            <div class="form-check text-center d-flex justify-content-center gap-2">
                                <input class="form-check-input" type="checkbox" id='${item}' value='${item}' name="selectedItems[]">
                                <label class="form-check-label" for='${item}'>
                                    ${item}
                                </label>
                            </div>`;
                    list.appendChild(li);
                });
            }
        </script>


        <script>
            function submitJobForm() {
                event.preventDefault(); // ป้องกันการกระทำเริ่มต้นของการส่งฟอร์ม
                var form = document.getElementById('jobForm');
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return; // หยุดฟังก์ชันถ้าข้อมูลในฟอร์มไม่ถูกต้อง
                }
                var formData = new FormData(form);

                // ลบฟิลด์ที่ไม่ต้องการออกจาก FormData
                formData.delete('type'); // ลบฟิลด์ 'type' ที่เป็นการซ้ำซ้อนออก
                formData.delete('selectedItems[]'); // ลบฟิลด์ 'type' ที่เป็นการซ้ำซ้อนออก

                const selectedItems = [];
                document.querySelectorAll('input[name="selectedItems[]"]:checked').forEach((checkbox) => {
                    selectedItems.push(checkbox.value);
                });

                // เพิ่ม selectedItems ลงใน FormData
                formData.append('selectedItems', JSON.stringify(selectedItems));

                fetch('action/create_hire_post.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Success:', data);
                        $('#hireModal').modal('hide');  // ใช้ jQuery เพื่อปิด modal
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            }
        </script>

        <div class="mb-3"></div>
    </div>
</body>

</html>