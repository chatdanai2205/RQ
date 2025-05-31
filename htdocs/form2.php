<?php
session_start();

// ตรวจสอบว่า Session ได้รับอนุญาตให้เข้าถึงหรือไม่
if (!isset($_SESSION['can_access_form']) || $_SESSION['can_access_form'] !== true) {
    // หากไม่ได้รับอนุญาต, รีไดเร็กกลับไปหน้าแรก
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
    // ไปที่หน้า form3
    header('Location: form3.php');
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

<body class="form-page">
    <!--  header -->
    <header class="header" style="background: #fff;">
        <a class="logo"><i class="fa-solid fa-stethoscope"></i> แบบประเมินพลังสุขภาพจิต</a>
        <span class="header-step">Step 2 / 4</span>
    </header>
    <!--  header -->

    <!-- form section 1 -->
    <form  action="" method="POST" id="myForm1">
    <div class="form" id="page2" >
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
                    <div class="form-box" >
                    <!-- Hidden inputs for each question -->
                    <input type="hidden" name="question1" value="">
                    <input type="hidden" name="question2" value="">
                    <input type="hidden" name="question3" value="">
                    <input type="hidden" name="question4" value="">
                    <input type="hidden" name="question5" value="">
                    <input type="hidden" name="question6" value="">
                    <input type="hidden" name="question7" value="">
                    <input type="hidden" name="question8" value="">
                    <input type="hidden" name="question9" value="">
                    <input type="hidden" name="question10" value="">
                    <table>
                        <thead>
                            <tr>
                                <td>1.</td>
                                <td>เรื่องไม่สบายใจเล็กน้อยทำให้ฉันว้าวุ่นใจนั่งไม่ติด</td>
                                <td><button type="button" class="likert-btn" value="4" name="question1" required>ไม่จริง</button></td>
                                <td><button type="button" class="likert-btn" value="3" name="question1" required>จริงบางครั้ง</button></td>
                                <td><button type="button" class="likert-btn" value="2" name="question1" required>ค่อนข้างจริง</button></td>
                                <td><button type="button" class="likert-btn" value="1" name="question1" required>จริงมาก</button></td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>ฉันไม่เคยใส่ใจคนหัวเราะเยาะฉัน</td>
                                <td><button type="button" class="likert-btn" value="1" name="question2" required>ไม่จริง</button></td>
                                <td><button type="button" class="likert-btn" value="2" name="question2" required>จริงบางครั้ง</button></td>
                                <td><button type="button" class="likert-btn" value="3" name="question2" required>ค่อนข้างจริง</button></td>
                                <td><button type="button" class="likert-btn" value="4" name="question2" required>จริงมาก</button></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>เมื่อฉันทำผิดพลาดหรือเสียหายฉันยอมรับผิดหรือผลที่ตามมา</td>
                                <td><button type="button" class="likert-btn" value="1" name="question3" required>ไม่จริง</button></td>
                                <td><button type="button" class="likert-btn" value="2" name="question3" required>จริงบางครั้ง</button></td>
                                <td><button type="button" class="likert-btn" value="3" name="question3" required>ค่อนข้างจริง</button></td>
                                <td><button type="button" class="likert-btn" value="4" name="question3" required>จริงมาก</button></td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>ฉันเคยยอมทนลำบากเพื่ออนาคตที่ดีขึ้น</td>
                                <td><button type="button" class="likert-btn" value="1" name="question4" required>ไม่จริง</button></td>
                                <td><button type="button" class="likert-btn" value="2" name="question4" required>จริงบางครั้ง</button></td>
                                <td><button type="button" class="likert-btn" value="3" name="question4" required>ค่อนข้างจริง</button></td>
                                <td><button type="button" class="likert-btn" value="4" name="question4" required>จริงมาก</button></td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td>เวลาทุกข์ใจมากๆ ฉันเจ็บป่วยไม่สบาย</td>
                                <td><button type="button" class="likert-btn" value="4" name="question5" required>ไม่จริง</button></td>
                                <td><button type="button" class="likert-btn" value="3" name="question5" required>จริงบางครั้ง</button></td>
                                <td><button type="button" class="likert-btn" value="2" name="question5" required>ค่อนข้างจริง</button></td>
                                <td><button type="button" class="likert-btn" value="1" name="question5" required>จริงมาก</button></td>
                            </tr>
                            <tr>
                                <td>6.</td>
                                <td>ฉันสอนและเตือนตัวเอง</td>
                                <td><button type="button" class="likert-btn" value="1" name="question6" required>ไม่จริง</button></td>
                                <td><button type="button" class="likert-btn" value="2" name="question6" required>จริงบางครั้ง</button></td>
                                <td><button type="button" class="likert-btn" value="3" name="question6" required>ค่อนข้างจริง</button></td>
                                <td><button type="button" class="likert-btn" value="4" name="question6" required>จริงมาก</button></td>
                            </tr>
                            <tr>
                                <td>7.</td>
                                <td>ความยากลำบากทำให้ฉันแกร่งขึ้น</td>
                                <td><button type="button" class="likert-btn" value="1" name="question7" required>ไม่จริง</button></td>
                                <td><button type="button" class="likert-btn" value="2" name="question7" required>จริงบางครั้ง</button></td>
                                <td><button type="button" class="likert-btn" value="3" name="question7" required>ค่อนข้างจริง</button></td>
                                <td><button type="button" class="likert-btn" value="4" name="question7" required>จริงมาก</button></td>
                            </tr>
                            <tr>
                                <td>8.</td>
                                <td>ฉันไม่จดจำเรื่องเลวร้ายในอดีต</td>
                                <td><button type="button" class="likert-btn" value="1" name="question8" required>ไม่จริง</button></td>
                                <td><button type="button" class="likert-btn" value="2" name="question8" required>จริงบางครั้ง</button></td>
                                <td><button type="button" class="likert-btn" value="3" name="question8" required>ค่อนข้างจริง</button></td>
                                <td><button type="button" class="likert-btn" value="4" name="question8" required>จริงมาก</button></td>
                            </tr>
                            <tr>
                                <td>9.</td>
                                <td>ถึงแม้ปัญหาจะหนักหนาเพียงใดชีวิตฉันก็ไม่เลวร้ายไปหมด</td>
                                <td><button type="button" class="likert-btn" value="1" name="question9" required>ไม่จริง</button></td>
                                <td><button type="button" class="likert-btn" value="2" name="question9" required>จริงบางครั้ง</button></td>
                                <td><button type="button" class="likert-btn" value="3" name="question9" required>ค่อนข้างจริง</button></td>
                                <td><button type="button" class="likert-btn" value="4" name="question9" required>จริงมาก</button></td>
                            </tr>
                            <tr>
                                <td>10.</td>
                                <td>เมื่อมีเรื่องหนักใจ ฉันมีคนปรับทุกด้วย</td>
                                <td><button type="button" class="likert-btn" value="1" name="question10" required>ไม่จริง</button></td>
                                <td><button type="button" class="likert-btn" value="2" name="question10" required>จริงบางครั้ง</button></td>
                                <td><button type="button" class="likert-btn" value="3" name="question10" required>ค่อนข้างจริง</button></td>
                                <td><button type="button" class="likert-btn" value="4" name="question10" required>จริงมาก</button></td>
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
        <!-- form section 1 -->
</form>
<script src="js/form1-3.js"></script>
</body>
</html>