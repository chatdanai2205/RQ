<?php
session_start();

// ตรวจสอบ Session
if (!isset($_SESSION['can_access_form']) || $_SESSION['can_access_form'] !== true) {
    header("Location: index.php");
    // เคลียร์ session หากต้องการ
    unset($_SESSION['data_inserted']);
    unset($_SESSION['session_id']);
    exit();
}
if (!isset($_SESSION['session_id'])) {
    die("Session ไม่ถูกต้อง!"); // ตรวจสอบว่ามี session หรือไม่
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // เก็บข้อมูลใน session
    foreach ($_POST as $key => $value) {
        $_SESSION[$key] = $value;
    }
    // ไปที่หน้า form4
    header('Location: form4.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แบบประเมิน RQ</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <!-- Custom CSS Link -->
    <link rel="stylesheet" href="style28-5(1).css">

</head>

<body>
    <!--  header -->
    <header class="header" style="background-color: #fff;">
        <a class="logo"><i class="fa-solid fa-stethoscope"></i> แบบประเมินพลังสุขภาพจิต</a>
        <span class="header-step">Step 3 / 4</span>
    </header>
    <!--  header -->

        <!-- form section 2 -->
    <form method="POST" action="" id="myForm1">
    <div class="form" id="form2" >
        <div class="form-container">
            <div class="form-list">
                <div class="form-title">
                    <h3><strong>ส่วนที่ 4 :</strong> แบบประเมินพลังสุขภาพจิต RQ โดยกรมสุขภาพจิต </h3>
                    <a>
                        คำชี้แจง : กรุณาเลือกคำตอบที่ตรงกับข้อมูลและความคิดเห็นของท่านมากที่สุด
                    </a>
                </div>
                <div class="header-title">
                    <span class="header-form"> ด้านความทนต่อแรงกดดัน (พลังอึด) </span>
                </div>
                <div class="form-table">
                    <div class="form-box">
                    <!-- Hidden inputs for each question -->
                    <input type="hidden" name="question11" value="">
                    <input type="hidden" name="question12" value="">
                    <input type="hidden" name="question13" value="">
                    <input type="hidden" name="question14" value="">
                    <input type="hidden" name="question15" value="">
                    <table>
                        <thead>
                        <tr>
                            <td>11.</td>
                            <td>จากประสบการณ์ที่ผ่านมาทำให้ฉันมั่นใจว่าจะแก้ปัญหาต่าง ๆ ที่ผ่านเข้ามาในชีวิตได้</td>
                            <td><button type="button" class="likert-btn" value="1" name="question11" required>ไม่จริง</button></td>
                            <td><button type="button" class="likert-btn" value="2" name="question11" required>จริงบางครั้ง</button></td>
                            <td><button type="button" class="likert-btn" value="3" name="question11" required>ค่อนข้างจริง</button></td>
                            <td><button type="button" class="likert-btn" value="4" name="question11" required>จริงมาก</button></td>
                        </tr>
                        <tr>
                            <td>12.</td>
                            <td>ฉันมีครอบครัวและคนใกล้ชิดเป็นกำลังใจ</td>
                            <td><button type="button" class="likert-btn" value="1" name="question12" required>ไม่จริง</button></td>
                            <td><button type="button" class="likert-btn" value="2" name="question12" required>จริงบางครั้ง</button></td>
                            <td><button type="button" class="likert-btn" value="3" name="question12" required>ค่อนข้างจริง</button></td>
                            <td><button type="button" class="likert-btn" value="4" name="question12" required>จริงมาก</button></td>
                        </tr>
                        <tr>
                            <td>13.</td>
                            <td>ฉันมีแผนการที่จะทำให้ชีวิตก้าวไปข้างหน้า</td>
                            <td><button type="button" class="likert-btn" value="1" name="question13" required>ไม่จริง</button></td>
                            <td><button type="button" class="likert-btn" value="2" name="question13" required>จริงบางครั้ง</button></td>
                            <td><button type="button" class="likert-btn" value="3" name="question13" required>ค่อนข้างจริง</button></td>
                            <td><button type="button" class="likert-btn" value="4" name="question13" required>จริงมาก</button></td>
                        </tr>
                        <tr>
                            <td>14.</td>
                            <td>เมื่อมีปัญหาวิกฤติเกิดขึ้นฉันรู้สึกว่าตัวเองไร้ความสามารถ</td>
                            <td><button type="button" class="likert-btn" value="4" name="question14" required>ไม่จริง</button></td>
                            <td><button type="button" class="likert-btn" value="3" name="question14" required>จริงบางครั้ง</button></td>
                            <td><button type="button" class="likert-btn" value="2" name="question14" required>ค่อนข้างจริง</button></td>
                            <td><button type="button" class="likert-btn" value="1" name="question14" required>จริงมาก</button></td>
                        </tr>
                        <tr>
                            <td>15.</td>
                            <td>เป็นเรื่องยากสำหรับฉันที่จะทำให้ชีวิตดีขึ้น</td>
                            <td><button type="button" class="likert-btn" value="4" name="question15" required>ไม่จริง</button></td>
                            <td><button type="button" class="likert-btn" value="3" name="question15" required>จริงบางครั้ง</button></td>
                            <td><button type="button" class="likert-btn" value="2" name="question15" required>ค่อนข้างจริง</button></td>
                            <td><button type="button" class="likert-btn" value="1" name="question15" required>จริงมาก</button></td>
                        </tr>
                        </thead>
                    </table>
                    </div>
                </div> 
                </div>
            </div>
        <div class="next">
            <button type="button" class="next-btn" id="next-btn">ถัดไป&nbsp;<i class="fa-solid fa-arrow-right"></i></button>
        </div>
    </div>
    <!-- form section 2 -->
</form>
<script src="js/form1-3.js"></script>
</body>
</html>