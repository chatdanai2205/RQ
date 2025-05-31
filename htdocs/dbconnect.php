<?php
$servername = "sql200.infinityfree.com";
$username = "if0_38080361"; // ชื่อผู้ใช้ฐานข้อมูล
$password = "e3Aiy9ZhKL1tN5"; // รหัสผ่านฐานข้อมูล
$dbname = "if0_38080361_test_rq"; // ชื่อฐานข้อมูล

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}
// ตั้งค่าการเข้ารหัสให้เป็น utf8mb4
$conn->set_charset("utf8mb4");
?>
