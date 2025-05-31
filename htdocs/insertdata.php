<?php
session_start(); // เริ่มต้น session
require("dbconnect.php");

$gender = $_POST["gender"];
$year = $_POST["year"];
$department = $_POST["department"];
$chronic_disease = $_POST["chronic_disease"];
$fam_status = $_POST["fam_status"];
$fam_career = $_POST["fam_career"];
$fam_earn = $_POST["fam_earn"];
$gpa = $_POST["gpa"];
$course = $_POST["course"];
$session_id = $_SESSION['session_id']; // ใช้ session_id ของผู้ใช้ปัจจุบัน

// แทรกข้อมูลลงในตาราง user
$sql = "INSERT INTO user(gender, year, department, chronic_disease, gpa, course, fam_status, fam_career, fam_earn, session_id) 
        VALUES('$gender', '$year', '$department', '$chronic_disease', '$gpa', '$course', '$fam_status', '$fam_career', '$fam_earn', '$session_id')";
$result = mysqli_query($conn, $sql);

// ตรวจสอบผลลัพธ์
if ($result) {           
    // ตั้งค่า Session เพื่ออนุญาตให้เข้าถึงหน้าฟอร์มถัดไป
    $_SESSION['can_access_form'] = true;

    // ไปยังหน้าฟอร์มถัดไป
    header("location:form2.php");
    exit(0);
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
