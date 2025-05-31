<?php
session_start(); // เปิดใช้งาน session
require("dbconnect.php");

// ดึงค่าจาก $_POST และเก็บลงใน $_SESSION
foreach ($_POST as $key => $value) {
    $_SESSION[$key] = $value; // เก็บค่าทั้งหมดใน session
}

// ตรวจสอบว่าข้อมูลครบทุกคำถามหรือไม่
if (isset($_SESSION['question1'], $_SESSION['question20'])) {
    // ดึง id ล่าสุดจากตาราง user
    $sql = "SELECT id FROM user ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $id = $row['id']; // เก็บ id ล่าสุดที่ดึงมาได้

        // เตรียมคำสั่ง SQL สำหรับบันทึกข้อมูล
        $sql4 = "INSERT INTO reserch (
            id, question1, question2, question3, question4, question5,
            question6, question7, question8, question9, question10,
            question11, question12, question13, question14, question15,
            question16, question17, question18, question19, question20
        ) VALUES (
            '$id',
            '" . $_SESSION['question1'] . "', '" . $_SESSION['question2'] . "', '" . $_SESSION['question3'] . "', 
            '" . $_SESSION['question4'] . "', '" . $_SESSION['question5'] . "', '" . $_SESSION['question6'] . "', 
            '" . $_SESSION['question7'] . "', '" . $_SESSION['question8'] . "', '" . $_SESSION['question9'] . "', 
            '" . $_SESSION['question10'] . "', '" . $_SESSION['question11'] . "', '" . $_SESSION['question12'] . "', 
            '" . $_SESSION['question13'] . "', '" . $_SESSION['question14'] . "', '" . $_SESSION['question15'] . "', 
            '" . $_SESSION['question16'] . "', '" . $_SESSION['question17'] . "', '" . $_SESSION['question18'] . "', 
            '" . $_SESSION['question19'] . "', '" . $_SESSION['question20'] . "'
        )";

        // บันทึกข้อมูล
        $result3 = mysqli_query($conn, $sql4);

        if ($result3) {
            $_SESSION['data_inserted'] = true;
            header("location:result.php");
            exit(0);
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    
} else {
    echo "ข้อมูลไม่ครบถ้วน กรุณากรอกข้อมูลให้ครบทุกหน้า";
}
?>