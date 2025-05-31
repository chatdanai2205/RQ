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
// ล้าง Session หลังจากจบกระบวนการ
unset($_SESSION['can_access_form']);

// เก็บข้อมูลเมื่อส่งฟอร์ม
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $value) {
        $_SESSION[$key] = $value; // เก็บข้อมูลใน session
    }
    header("Location: insertdata3.php"); // ไปหน้าถัดไป
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
        <span class="header-step">Step 4 / 4</span>
    </header>
    <!--  header -->
        
    <!-- form section 3 -->
    <form method="POST" action="insertdata3.php" id="myForm1">
        <div class="form" id="form3" >
            <div class="form-container">
                <div class="form-list">
                    <div class="header-title">
                        <span class="header-form"> ด้านความทนต่อแรงกดดัน (พลังอึด) </span>
                    </div>
                    <div class="form-title">
                        <h3><strong>ส่วนที่ 4 :</strong> แบบประเมินพลังสุขภาพจิต RQ โดยกรมสุขภาพจิต </h3>
                        <a>
                            คำชี้แจง : กรุณาเลือกคำตอบที่ตรงกับข้อมูลและความคิดเห็นของท่านมากที่สุด
                        </a>
                    </div>
                
                <div class="form-table">
                    <div class="form-box">
                    <!-- Hidden inputs for each question -->
                    <input type="hidden" name="question16" value="">
                    <input type="hidden" name="question17" value="">
                    <input type="hidden" name="question18" value="">
                    <input type="hidden" name="question19" value="">
                    <input type="hidden" name="question20" value="">
                    <table>
                        <thead>
                            <tr>
                                <td>16.</td>
                                <td>ฉันอยากหนีไปให้พ้นหากมีปัญหาหนักหนาที่ต้องรับผิดชอบ</td>
                                <td><button type="button" class="likert-btn" value="4" name="question16" required>ไม่จริง</button></td>
                                <td><button type="button" class="likert-btn" value="3" name="question16" required>จริงบางครั้ง</button></td>
                                <td><button type="button" class="likert-btn" value="2" name="question16" required>ค่อนข้างจริง</button></td>
                                <td><button type="button" class="likert-btn" value="1" name="question16" required>จริงมาก</button></td>
                            </tr>
                            <tr>
                                <td>17.</td>
                                <td>การแก้ไขปัญหาทำให้ฉันมีประสบการณ์มากขึ้น</td>
                                <td><button type="button" class="likert-btn" value="1" name="question17" required>ไม่จริง</button></td>
                                <td><button type="button" class="likert-btn" value="2" name="question17" required>จริงบางครั้ง</button></td>
                                <td><button type="button" class="likert-btn" value="3" name="question17" required>ค่อนข้างจริง</button></td>
                                <td><button type="button" class="likert-btn" value="4" name="question17" required>จริงมาก</button></td>
                            </tr>
                            <tr>
                                <td>18.</td>
                                <td>ในการพูดคุยฉันหาเหตุผลที่ทุกคนยอมรับหรือเห็นด้วยกับฉันได้</td>
                                <td><button type="button" class="likert-btn" value="1" name="question18" required>ไม่จริง</button></td>
                                <td><button type="button" class="likert-btn" value="2" name="question18" required>จริงบางครั้ง</button></td>
                                <td><button type="button" class="likert-btn" value="3" name="question18" required>ค่อนข้างจริง</button></td>
                                <td><button type="button" class="likert-btn" value="4" name="question18" required>จริงมาก</button></td>
                            </tr>
                            <tr>
                                <td>19.</td>
                                <td>ฉันเตรียมหาทางออกไว้หากปัญหาร้ายแรงกว่าที่คิด</td>
                                <td><button type="button" class="likert-btn" value="1" name="question19" required>ไม่จริง</button></td>
                                <td><button type="button" class="likert-btn" value="2" name="question19" required>จริงบางครั้ง</button></td>
                                <td><button type="button" class="likert-btn" value="3" name="question19" required>ค่อนข้างจริง</button></td>
                                <td><button type="button" class="likert-btn" value="4" name="question19" required>จริงมาก</button></td>
                            </tr>
                            <tr>
                                <td>20.</td>
                                <td>ฉันชอบฟังความคิดเห็นที่แตกต่างจากฉัน</td>
                                <td><button type="button" class="likert-btn" value="1" name="question20" required>ไม่จริง</button></td>
                                <td><button type="button" class="likert-btn" value="2" name="question20" required>จริงบางครั้ง</button></td>
                                <td><button type="button" class="likert-btn" value="3" name="question20" required>ค่อนข้างจริง</button></td>
                                <td><button type="button" class="likert-btn" value="4" name="question20" required>จริงมาก</button></td>
                            </tr>

                        </thead>
                    </table>
                </div>  
                </div>
            </div>
        </div>
        <div class="next">
            <button type="button" class="next-btn" >ส่งข้อมูล</i></button>
        </div>
    </div>
    <!-- form section 3 -->
</form>
<script src="js/form1-3.js"></script>
</body>
</html>