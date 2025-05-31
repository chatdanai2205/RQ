<?php
session_start();
session_regenerate_id(true); // 🔥 เปลี่ยน Session ID ทุกครั้งที่มีการ Login
$_SESSION['session_id'] = session_id(); // อัปเดต session ใหม่
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
    <header class="header" style="background-color: #fff;">
        <a class="logo"><i class="fa-solid fa-stethoscope"></i> แบบประเมินพลังสุขภาพจิต</a>
        <span class="header-step">Step 1 / 4</span>
    </header>
    <!--  header -->

    <!-- Home -->
    <form action="insertdata.php" method="POST" id="myForm1">
    <section class="form" id="page1">
    <div class="form-title">
        <a>
            คำชี้แจง : โปรดตอบตามความเป็นจริงและตอบทุกข้อ เพื่อท่านจะได้รู้จักตนเองและวางแผนพัฒนาตนต่อไป
        </a>
    </div>    
        <div class="form-content">
            <div class="form-list">
                <div class="form-title">
                    <h3><strong>ส่วนที่ 1 :</strong> แบบสำรวจข้อมูลทั่วไปเกี่ยวกับปัจจัยของผู้ตอบแบบสอบถาม </h3>
                </div>
                <div class="form-box"> 
                    <label for="gender" class="question">1. เพศ</label><br>
                    <select name="gender" id="gender" class="option" required>
                        <option value="" disabled selected hidden>กรุณาเลือก</option>
                        <option value="ชาย">ชาย</option>
                        <option value="หญิง">หญิง</option>
                    </select><br>
                    <label for="year" class="question">2. ชั้นปีที่กำลังศึกษา</label><br>
                    <select name="year" id="year" class="option" required>
                        <option value="">กรุณาเลือก</option>
                        <option value="ปี 1">ปี 1</option>
                        <option value="ปี 2">ปี 2</option>
                        <option value="ปี 3">ปี 3</option>
                        <option value="ปี 4">ปี 4</option>
                    </select><br>
                    <label for="department" class="question">3. ภาควิชาที่กำลังศึกษา</label><br>
                    <select name="department" id="department" class="option" required>
                        <option value="">กรุณาเลือก</option>
                        <option value="ภาควิชาเคมี">ภาควิชาเคมี</option>
                        <option value="ภาควิชาชีววิทยา">ภาควิชาชีววิทยา</option>
                        <option value="ภาควิชาคณิตศาสตร์">ภาควิชาคณิตศาสตร์</option>
                        <option value="ภาควิชาฟิสิกส์">ภาควิชาฟิสิกส์</option>
                        <option value="ภาควิชาวิทยาการคอมพิวเตอร์">ภาควิชาวิทยาการคอมพิวเตอร์</option>
                        <option value="ภาควิชาสถิติ">ภาควิชาสถิติ</option>
                        <option value="ศูนย์วิเคราะห์ข้อมูลดิจิทัลอัจฉริยะพระจอมเกล้าลาดกระบัง">ศูนย์วิเคราะห์ข้อมูลดิจิทัลอัจฉริยะพระจอมเกล้าลาดกระบัง</option>
                    </select><br>
                    <label for="chronic_disease" class="question">4. โรคประจำตัว</label><br>
                    <select name="chronic_disease" id="chronic_disease" class="option" required>
                        <option value="">กรุณาเลือก</option>
                        <option value="มี">มี</option>
                        <option value="ไม่มี">ไม่มี</option>
                    </select>
                </div>
            </div>
            <!-- ส่วนที่ 2 -->  
            <div class="form-list">
                <div class="form-title">
                    <h3><strong>ส่วนที่ 2 :</strong> แบบสำรวจปัจจัยด้านครอบครัว</h3>
                </div>
                <div class="form-box"> 
                    <label for="fam_status" class="question">1. สถานภาพของบิดามารดาท่านในปัจจุบัน</label><br>
                    <select name="fam_status" id="fam_status" class="option" required>
                        <option value="">กรุณาเลือก</option>
                        <option value="บิดามารดาอยู่ด้วยกัน">บิดามารดาอยู่ด้วยกัน</option>
                        <option value="บิดามารดาแยกกันอยู่">บิดามารดาแยกกันอยู่</option>
                        <option value="บิดา และ/หรือ มารดาเสียชีวิต">บิดา และ/หรือ มารดาเสียชีวิต</option>
                    </select><br>
                    <label for="fam_career" class="question">2. อาชีพหลักของหัวหน้าครอบครัว</label><br>
                    <select name="fam_career" id="fam_career" class="option" required>
                        <option value="">กรุณาเลือก</option>
                        <option value="รับข้าราชการ/พนักงานรัฐวิสาหกิจ">รับข้าราชการ/พนักงานรัฐวิสาหกิจ</option>
                        <option value="พนักงานบริษัท/รับจ้าง">พนักงานบริษัท/รับจ้าง</option>
                        <option value="ค้าขาย/ธุรกิจส่วนตัว/เกษตรกรรม">ค้าขาย/ธุรกิจส่วนตัว/เกษตรกรรม</option>
                        <option value="พ่อบ้าน/แม่บ้าน">พ่อบ้าน/แม่บ้าน</option>
                    </select><br>
                    <label for="fam_earn" class="question">3. รายได้ครอบครัวต่อเดือน</label><br>
                    <select name="fam_earn" id="fam_earn" class="option" required>
                        <option value="">กรุณาเลือก</option>
                        <option value="ต่ำกว่า 9,000 บาท">ต่ำกว่า 9,000 บาท</option>
                        <option value="9,001-20,000 บาท">9,001-20,000 บาท</option>
                        <option value="20,001-40,000 บาท">20,001-40,000 บาท</option>
                        <option value="40,001 บาทขึ้นไป">40,001 บาทขึ้นไป</option>
                    </select><br>
                </div>
            </div>
            <!-- ส่วนที่ 3 -->
            <div class="form-list">
                <div class="form-title">
                    <h3><strong>ส่วนที่ 3 :</strong> แบบสำรวจปัจจัยด้านการศึกษา</h3>
                </div>
                <div class="form-box">
                    <label for="gpa" class="question">1. เกรดเฉลี่ย (GPA)</label><br>
                    <select name="gpa" id="gpa" class="option" required>
                        <option value="">กรุณาเลือก</option>
                        <option value="ต่ำกว่า 2.50">ต่ำกว่า 2.50</option>
                        <option value="2.51-3.00">2.51-3.00</option>
                        <option value="3.01-3.50">3.01-3.50</option>
                        <option value="3.51-4.00">3.51-4.00</option>
                    </select><br>
                    <label for="course" class="question">2. นักศึกษาคิดว่าหลักสูตรที่กำลังศึกษาตอบโจทย์กับความต้องการของตนเองหรือไม่</label><br>
                    <select name="course" id="course" class="option" required>
                        <option value="">กรุณาเลือก</option>
                        <option value="มาก">มาก</option>
                        <option value="ปานกลาง">ปานกลาง</option>
                        <option value="น้อย">น้อย</option>
                    </select>
                    <br>
                </div>
            </div>
        </div>
        <div class="next">
            <button type="submit" class="start-btn" id="next-btn"onclick="return validateForm();">เริ่มทำแบบประเมิน&nbsp;<i class="fa-solid fa-arrow-right"></i></button>
            <button class="next-btn" id="cancle" type="button" onclick="resetFormAndRedirect();" ><i class="fa-solid fa-x"></i>&nbsp;ออกจากแบบประเมิน</button>
        </div>
    </section>
    </form>
    <script>
        function validateForm() {
            let form = document.getElementById("myForm1");
            if (!form.checkValidity()) {
                alert("กรุณากรอกข้อมูลให้ครบถ้วน!");
                return false;
            }
            return true;
        }
        function resetFormAndRedirect() {
            document.getElementById('myForm1').reset(); // ล้างข้อมูลในฟอร์ม
            window.location.href = "index.php";
        }
         // เมื่อผู้ใช้กดย้อนกลับ
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            // ล้างข้อมูล (ถ้าจำเป็น)
            document.getElementById('myForm1').reset(); // ล้างข้อมูลในฟอร์ม
            // Redirect ไปที่หน้า index.php
            window.location.href = "index.php";
        };
    </script>
</body>
</html>