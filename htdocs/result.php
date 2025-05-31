<?php
session_start();
require("dbconnect.php");

// ตรวจสอบว่า session มีการ insert ข้อมูลหรือไม่
if (!isset($_SESSION['data_inserted']) || $_SESSION['data_inserted'] !== true) {
    header("Location: index.php");
    exit;
}

// ตรวจสอบว่ามี session_id หรือไม่
if (!isset($_SESSION['session_id'])) {
    die("Session ไม่ถูกต้อง!");
}

$session_id = $_SESSION['session_id'];

try {
    // 1. ตรวจสอบ session และดึง user.id
    $sqlUser = "SELECT id FROM user WHERE session_id = ?";
    $stmtUser = $conn->prepare($sqlUser);
    $stmtUser->bind_param("s", $session_id);
    $stmtUser->execute();
    $resultUser = $stmtUser->get_result();

    if ($resultUser->num_rows === 0) {
        die("ไม่พบผู้ใช้ที่เชื่อมโยงกับ session นี้!");
    }

    $userData = $resultUser->fetch_assoc();
    $user_id = $userData['id'];  // <- ใช้อันนี้ค้นใน reserch.id

    // 2. ดึงข้อมูลจาก reserch โดยใช้ id ที่ตรงกับ user_id
    $sqlReserch = "SELECT * FROM reserch WHERE id = ?";
    $stmtReserch = $conn->prepare($sqlReserch);
    $stmtReserch->bind_param("i", $user_id);
    $stmtReserch->execute();
    $resultReserch = $stmtReserch->get_result();

    if ($resultReserch->num_rows === 0) {
        echo "ไม่พบข้อมูลแบบประเมินของคุณ!";
        exit;
    }
    // 3. ดึงข้อมูลจากตาราง user โดยใช้ user_id
    $sqlUserDetails = "SELECT * FROM user WHERE id = ?";
    $stmtUserDetails = $conn->prepare($sqlUserDetails);
    $stmtUserDetails->bind_param("i", $user_id);
    $stmtUserDetails->execute();
    $resultUserDetails = $stmtUserDetails->get_result();

    if ($resultUserDetails->num_rows === 0) {
        echo "ไม่พบข้อมูลผู้ใช้!";
        exit;
    }

    $rows = $resultReserch->fetch_all(MYSQLI_ASSOC);
    $userDetails = $resultUserDetails->fetch_assoc();

    // 3. วนลูปเพื่อคำนวณคะแนนและเก็บลงตาราง result
    foreach ($rows as $row) {
        $total_score = array_sum(array_slice($row, 2, 20)); // ข้าม id + user_id
        $total_score1 = array_sum(array_slice($row, 2, 10));
        $total_score2 = array_sum(array_slice($row, 12, 5));
        $total_score3 = array_sum(array_slice($row, 17, 5));

        $insertSql = "INSERT INTO result (id, total_score, pressure_tolerance, hope_and_support, overcoming_obstacles)
                      VALUES (?, ?, ?, ?, ?)
                      ON DUPLICATE KEY UPDATE 
                      total_score = VALUES(total_score), 
                      pressure_tolerance = VALUES(pressure_tolerance), 
                      hope_and_support = VALUES(hope_and_support), 
                      overcoming_obstacles = VALUES(overcoming_obstacles)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("idddd", $user_id, $total_score, $total_score1, $total_score2, $total_score3);
        $insertStmt->execute();
    }

    // เคลียร์ session หากต้องการ
    unset($_SESSION['data_inserted']);
    unset($_SESSION['session_id']);

} catch (Exception $e) {
    echo "❌ เกิดข้อผิดพลาด: " . $e->getMessage();
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

<body class="home-page">
    <!--  header -->
    <header class="header">
        <a href="index.php" class="logo"><i class="fa-solid fa-stethoscope"></i> แบบประเมินพลังสุขภาพจิต</a>
    
        <nav class="navbar">
            <div id="close-navbar" class="fas fa-times"></div>
            <a href="index.php" class="animated-link">หน้าหลัก</a>
            <a href="about.php" class="animated-link">About</a>
            <a href="dashboard.php" class="animated-link">Dashboard</a>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
        </div>
    </header>
    <!--  header -->
    
    <div class="result">
        <div class="icon">
            <i class="fa-solid fa-circle-user"></i>
        </div>
        <div class="point-mean">
        <div class="point">      
            <div class="point-mean">
                <h6 class="primary-text">ผลรวมคะแนนของท่าน คือ</h6>
                    <div class="number">
                        <?php
                            // ตรวจสอบค่า total_score1 และแสดงข้อความตามเกณฑ์
                            if ($total_score < 55) {
                                echo "<img src='image/bad.png' class='result-img' alt='Smile Image'><br>";
                                echo "<div class='point-result'><span style='color: red;'>$total_score </span>&nbsp;/ 80</div>";
                        } elseif ($total_score >= 55 && $total_score <= 69) {
                            echo "<img src='image/smile.png' class='result-img' alt='Smile Image'><br>";
                            echo "<div class='point-result'><span style='color: orange;'>$total_score </span>&nbsp;/ 80</div>";
                        } else {
                            echo "<img src='image/laugh.png' class='result-img' alt='Smile Image'><br>";
                            echo "<div class='point-result'><span style='color: green;'>$total_score </span>&nbsp;/ 80</div>";
                        }
                    ?>
                    <div class="primary-text">
                        <?php
                            if ($total_score < 55) {
                                echo "<span style='color: red;'>ต่ำกว่าเกณฑ์ปกติ</span>";
                            } elseif ($total_score >= 55 && $total_score <= 69) {
                                echo "<span style='color: orange;'>เกณฑ์ปกติ</span>";
                            } else {
                                echo "<span style='color: green;'>สูงกว่าเกณฑ์ปกติ</span>";
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="point-mean">
                <div class="user-details">
                    <?php
                        if ($resultUserDetails->num_rows > 0) {
                            // แสดงข้อมูลจากตาราง user
                            echo "<b>ID :</b> " . $user_id . "<br>";
                            echo "<b>เพศ :</b> " . htmlspecialchars($userDetails["gender"]) . "<br>";
                            echo "<b>ชั้นปี :</b> " . htmlspecialchars($userDetails["year"]) . "<br>";
                            echo "<b>ภาควิชา :</b> " . htmlspecialchars($userDetails["department"]) . "<br>";
                            echo "<b>โรคประจำตัว :</b> " . htmlspecialchars($userDetails["chronic_disease"]) . "<br>";
                            echo "<b>หลักสูตรตอบโจทย์กับความต้องการ :</b> " . htmlspecialchars($userDetails["course"]) . "<br>";
                            echo "<b>สถานภาพของบิดามารดาท่านในปัจจุบัน :</b> " . htmlspecialchars($userDetails["fam_status"]) . "<br>";
                            echo "<b>อาชีพหลักของหัวหน้าครอบครัว :</b> " . htmlspecialchars($userDetails["fam_career"]) . "<br>";
                            echo "<b>รายได้ครอบครัวต่อเดือน :</b> " . htmlspecialchars($userDetails["fam_earn"]) . "<br>";
                        } else {
                            echo "ไม่พบข้อมูลในฐานข้อมูล";
                        }
                    ?>
                </div>  
            </div>
        </div>
        <div class="point-mean">
            <div class="details">
                <div class="rating">
                    <h6 class="primary-text1">ด้านความทนต่อแรงกดดัน </h6>
                        <div class="point-chart">
                            <div class="outer1">
                                <div class ="number" >
                                <div id="score1"></div>
                                    <?php 
                                        $percentage = ($total_score1 / 40) * 100; 
                                        // ตรวจสอบค่า total_score1 และแสดงข้อความตามเกณฑ์
                                        if ($total_score1 < 23) {
                                            echo "<span style='color: red;'>" . number_format($percentage, 1) . "%</span>";
                                        } elseif ($total_score1 >= 23 && $total_score1 <= 34) {
                                            echo "<span style='color: orange;'>" . number_format($percentage, 1) . "%</span>";
                                        } else {
                                            echo "<span style='color: green;'>" . number_format($percentage, 1) . "%</span>";
                                        }
                                    ?>
                                    <div id="criteria">
                                        <?php 
                                            // ตรวจสอบค่า total_score1 และแสดงข้อความตามเกณฑ์
                                            if ($total_score1 < 23) {
                                                echo "<span style='color: red;'>ต่ำกว่าเกณฑ์ปกติ</span>";
                                            } elseif ($total_score1 >= 23 && $total_score1 <= 34) {
                                                echo "<span style='color: orange;'>เกณฑ์ปกติ</span>";
                                            } else {
                                                echo "<span style='color: green;'>สูงกว่าเกณฑ์ปกติ</span>";
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rating">
                        <h6 class="primary-text1">ด้านการมีหวังและกำลังใจ</h6>
                        <div class="point-chart">
                            <div class="outer2">
                                <div class ="number">
                                    <div id="score2"></div>
                                    <?php 
                                        $percentage1 = ($total_score2 / 20) * 100; 
                                        // ตรวจสอบค่า total_score1 และแสดงข้อความตามเกณฑ์
                                        if ($total_score2 < 14) {
                                            echo "<span style='color: red;'>" . number_format($percentage1, 1) . "%</span>";
                                        } elseif ($total_score2 >= 14 && $total_score2 <= 19) {
                                            echo "<span style='color: orange;'>" . number_format($percentage1, 1) . "%</span>";
                                        } else {
                                            echo "<span style='color: green;'>" . number_format($percentage1, 1) . "%</span>";
                                        }
                                    ?>
                                    <div id="criteria">
                                        <?php 
                                            // ตรวจสอบค่า total_score1 และแสดงข้อความตามเกณฑ์
                                            if ($total_score2 < 14) {
                                                echo "<span style='color: red;'>ต่ำกว่าเกณฑ์ปกติ</span>";
                                            } elseif ($total_score2 >= 14 && $total_score2 <= 19) {
                                                echo "<span style='color: orange;'>เกณฑ์ปกติ</span>";
                                            } else {
                                                echo "<span style='color: green;'>สูงกว่าเกณฑ์ปกติ</span>";
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rating">
                        <h6 class="primary-text1">ด้านการต่อสู้เอาชนะอุปสรรค</h6>
                        <div class="point-chart">
                            <div class="outer3">
                                <div class ="number">
                                    <div id="score3"></div>
                                    <?php 
                                        $percentage2 = ($total_score3 / 20) * 100; 
                                        // ตรวจสอบค่า total_score1 และแสดงข้อความตามเกณฑ์
                                        if ($total_score3 < 13) {
                                            echo "<span style='color: red; '>" . number_format($percentage2, 1) . "%</span>";
                                        } elseif ($total_score3 >= 13 && $total_score3 <= 18) {
                                            echo "<span style='color: orange;'>" . number_format($percentage2, 1) . "%</span>";
                                        } else {
                                            echo "<span style='color: green;'>" . number_format($percentage2, 1) . "%</span>";
                                        }
                                    ?>
                                <div id="criteria">
                                    <?php 
                                        // ตรวจสอบค่า total_score1 และแสดงข้อความตามเกณฑ์
                                        if ($total_score3 < 13) {
                                            echo "<span style='color: red;'>ต่ำกว่าเกณฑ์ปกติ</span>";
                                        } elseif ($total_score3 >= 13 && $total_score3 <= 18) {
                                            echo "<span style='color: orange;'>เกณฑ์ปกติ</span>";
                                        } else {
                                            echo "<span style='color: green;'>สูงกว่าเกณฑ์ปกติ</span>";
                                        }
                                    ?> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        </div>
        <a>หมายเหตุ: คะแนนของคุณจะแสดงเพียงครั้งเดียว กรุณาตรวจสอบหรือบันทึกหน้าจอก่อนออกจากหน้านี้</a><br>
        <div class="button" id="recomand-btn">
            <button class="recomand-btn"><i class="fa-solid fa-user-doctor"></i>&nbsp;คลิ๊กเพื่อดูคำแนะนำ</button>
        </div>
    </div>  
    <div class="recomand">              
        <div class="popup-recomand">
            <h2>คำแนะนำของท่าน</h2>
            <div id="goo">
            <?php 
                // ตรวจสอบค่า total_score1 และแสดงข้อความตามเกณฑ์
                if ($total_score >= 54 && $total_score <= 69 ) {
                    echo '<i class="fa-solid fa-map-pin"></i> ท่านจัดอยู่ในกลุ่มคนที่มีพลังสุขภาพจิตปกติทั่วไป ท่านอาจพัฒนาตนเอง โดยการแสวงหาความรู้เพื่อ เสริมสร้างพลังสุขภาพจิตให้คงอยู่<br>';
                    if ($total_score1 < 23 ) {
                        echo    '<i class="fa-solid fa-map-pin"></i> <strong> ด้านความทนต่อแรงกดดัน</strong> <br>
                            &nbsp;  ท่านสามารถพัฒนาศักยภาพด้านนี้ได้โดยฝึกควบคุมอารมณ์ตนเองให้มี 
                            สติและสงบโดยเริ่มต้นจากการควบคุมอารมณ์เมื่อเผชิญกับสถานการณ์เล็กน้อย ๆ ที่ทำให้เกิดความเครียดความผิดหวัง 
                            ฝึกหายใจเข้าออกช้า ๆ ลึก ๆ และคิดถึงสิ่งที่ยึดเหนี่ยวทางใจ<br>'; 
                    }if ($total_score2 < 14 ) {    
                        echo '<i class="fa-solid fa-map-pin"></i> <strong> ด้านกำลังใจ</strong> <br>
                            &nbsp;  ท่านสามารถพัฒนาศักยภาพด้านนี้ได้โดยคิดถึงสิ่งดีดีที่ท่านมีอยู่หมั่นพูดให้กำลังใจตนเอง 
                            เช่น เราต้องผ่านพ้นไปได้ชีวิตย่อมมีขึ้นมีลงคิดถึงโอกาสข้างหน้าหากฝ่าฟันจุดนี้ไปได้<br>';
                    }if ($total_score3 < 13 ) {
                        echo '<i class="fa-solid fa-map-pin"></i> <strong> ด้านการต่อสู้เอาชนะอุปสรรค</strong> <br>
                            &nbsp;  ท่านสามารถพัฒนาศักยภาพด้านนี้ได้โดยฝึกคิดหาทางออกในการแก้บัญหาเริ่มจากปัญหาเล็ก ๆ น้อย ๆ 
                            หาทางออกหาข้อดีข้อเสียในแต่ละวิธีการเลือกวิธีการที่ดีที่สุดและคิดหาวิธีการสำรองไว้เผื่อวิธีที่เลือกใช้ไม่ได้ผลการแก้ไขปัญหาได้สำเร็จจะช่วยให้ท่านเห็นว่าการแก้ไขปัญหาไม่ใช่เรื่องยาก 
                            และมีทักษะที่ดีในการแก้ปัญหาได้<br>';
                    }
                }elseif ($total_score > 69){
                    echo '<i class="fa-solid fa-map-pin"></i> ท่านจัดอยู่ในกลุ่มคนที่มีพลังพลังสุขภาพจิตดีเยี่ยมขอให้ท่านรักษาศักยภาพด้านนี้ไว้<br>';
                    if ($total_score1 < 23 ) {
                        echo    '<i class="fa-solid fa-map-pin"></i> <strong> ด้านความทนต่อแรงกดดัน</strong> <br>
                            &nbsp;  ท่านสามารถพัฒนาศักยภาพด้านนี้ได้โดยฝึกควบคุมอารมณ์ตนเองให้มี 
                            สติและสงบโดยเริ่มต้นจากการควบคุมอารมณ์เมื่อเผชิญกับสถานการณ์เล็กน้อย ๆ ที่ทำให้เกิดความเครียดความผิดหวัง 
                            ฝึกหายใจเข้าออกช้า ๆ ลึก ๆ และคิดถึงสิ่งที่ยึดเหนี่ยวทางใจ<br>'; 
                    }if ($total_score2 < 14 ) {    
                        echo '<i class="fa-solid fa-map-pin"></i> <strong> ด้านกำลังใจ</strong> <br>
                            &nbsp;  ท่านสามารถพัฒนาศักยภาพด้านนี้ได้โดยคิดถึงสิ่งดีดีที่ท่านมีอยู่หมั่นพูดให้กำลังใจตนเอง 
                            เช่น เราต้องผ่านพ้นไปได้ชีวิตย่อมมีขึ้นมีลงคิดถึงโอกาสข้างหน้าหากฝ่าฟันจุดนี้ไปได้<br>';
                    }if ($total_score3 < 13 ) {
                        echo '<i class="fa-solid fa-map-pin"></i> <strong> ด้านการต่อสู้เอาชนะอุปสรรค</strong> <br>
                            &nbsp;  ท่านสามารถพัฒนาศักยภาพด้านนี้ได้โดยฝึกคิดหาทางออกในการแก้บัญหาเริ่มจากปัญหาเล็ก ๆ น้อย ๆ 
                            หาทางออกหาข้อดีข้อเสียในแต่ละวิธีการเลือกวิธีการที่ดีที่สุดและคิดหาวิธีการสำรองไว้เผื่อวิธีที่เลือกใช้ไม่ได้ผลการแก้ไขปัญหาได้สำเร็จจะช่วยให้ท่านเห็นว่าการแก้ไขปัญหาไม่ใช่เรื่องยาก 
                            และมีทักษะที่ดีในการแก้ปัญหาได้<br>';
                    }
                }elseif ($total_score < 54){  
                    if ($total_score1 < 23 ) {
                        echo    '<i class="fa-solid fa-map-pin"></i> <strong> ด้านความทนต่อแรงกดดัน</strong> <br>
                            &nbsp;  ท่านสามารถพัฒนาศักยภาพด้านนี้ได้โดยฝึกควบคุมอารมณ์ตนเองให้มี 
                            สติและสงบโดยเริ่มต้นจากการควบคุมอารมณ์เมื่อเผชิญกับสถานการณ์เล็กน้อย ๆ ที่ทำให้เกิดความเครียดความผิดหวัง 
                            ฝึกหายใจเข้าออกช้า ๆ ลึก ๆ และคิดถึงสิ่งที่ยึดเหนี่ยวทางใจ<br>'; 
                    }if ($total_score2 < 14 ) {    
                        echo '<i class="fa-solid fa-map-pin"></i> <strong> ด้านกำลังใจ</strong> <br>
                            &nbsp;  ท่านสามารถพัฒนาศักยภาพด้านนี้ได้โดยคิดถึงสิ่งดีดีที่ท่านมีอยู่หมั่นพูดให้กำลังใจตนเอง 
                            เช่น เราต้องผ่านพ้นไปได้ชีวิตย่อมมีขึ้นมีลงคิดถึงโอกาสข้างหน้าหากฝ่าฟันจุดนี้ไปได้<br>';
                    }if ($total_score3 < 13 ) {
                        echo '<i class="fa-solid fa-map-pin"></i> <strong> ด้านการต่อสู้เอาชนะอุปสรรค</strong> <br>
                            &nbsp;  ท่านสามารถพัฒนาศักยภาพด้านนี้ได้โดยฝึกคิดหาทางออกในการแก้บัญหาเริ่มจากปัญหาเล็ก ๆ น้อย ๆ 
                            หาทางออกหาข้อดีข้อเสียในแต่ละวิธีการเลือกวิธีการที่ดีที่สุดและคิดหาวิธีการสำรองไว้เผื่อวิธีที่เลือกใช้ไม่ได้ผลการแก้ไขปัญหาได้สำเร็จจะช่วยให้ท่านเห็นว่าการแก้ไขปัญหาไม่ใช่เรื่องยาก 
                            และมีทักษะที่ดีในการแก้ปัญหาได้<br>';
                    }
                }
            ?> 
            </div>

            <div class="btn-recomand">
                <button class="recomand-btn exit-btn">Exit</button>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
    <script src="js/recommand.js"></script>
    <script>
    // รับค่าจาก PHP ด้วยการแทรกในโค้ด JavaScript
    let totalScore1 = <?php echo $total_score1; ?>; // รับค่า $total_score1 จาก PHP
    let totalScore2 = <?php echo $total_score2; ?>; // รับค่า $total_score2 จาก PHP
    let totalScore3 = <?php echo $total_score3; ?>; // รับค่า $total_score3 จาก PHP

    // คำนวณ progressEndValue โดยใช้สูตร progressEndValue = totalScore * (100 / 40)
    let progressEndValue1 = totalScore1 * (100 / 40);
    let progressEndValue2 = totalScore2 * (100 / 20);
    let progressEndValue3 = totalScore3 * (100 / 20);

    // เลือก element ที่จะแสดงผล
    let circularProgress1 = document.querySelector(".outer1"),
        progressValue1 = document.querySelector("#score1"),
        circularProgress2 = document.querySelector(".outer2"),
        progressValue2 = document.querySelector("#score2"),
        circularProgress3 = document.querySelector(".outer3"),
        progressValue3 = document.querySelector("#score3");

    // ฟังก์ชันเลือกสีตามคะแนน
    function getColor(score, thresholds) {
        if (score < thresholds.low) {
            return "#FF0000"; // สีแดง
        } else if (score >= thresholds.low && score <= thresholds.high) {
            return "#FFD700"; // สีเหลือง
        } else {
            return "#32CD32"; // สีเขียว
        }
    }

    // ฟังก์ชันสำหรับเพิ่มค่าความคืบหน้า
    function startProgress(circularProgress, progressValue, score, progressEndValue, thresholds) {
        let progressStartValue = 0; // เริ่มค่าความคืบหน้าที่ 0
        let speed = 20; // ความเร็วในการเพิ่มค่า (มิลลิวินาที)

        let progress = setInterval(() => {
            // เพิ่มค่าความคืบหน้า
            progressStartValue++;

            // เลือกสี
            let color = getColor(score, thresholds);

            // อัปเดตสีของวงกลม
            circularProgress.style.background = `conic-gradient(${color} ${progressStartValue * 3.6}deg, #ededed 0deg)`;

            // หยุดการทำงานเมื่อค่าความคืบหน้าและการแสดงผลถึงเป้าหมาย
            if (progressStartValue >= progressEndValue) {
                clearInterval(progress);
            }
        }, speed);
    }

    // เริ่มการทำงานของแต่ละโปรเกรส
    startProgress(circularProgress1, progressValue1, totalScore1, progressEndValue1, { low: 23, high: 34 });
    startProgress(circularProgress2, progressValue2, totalScore2, progressEndValue2, { low: 14, high: 19 });
    startProgress(circularProgress3, progressValue3, totalScore3, progressEndValue3, { low: 13, high: 18 });
    </script>
    
</body>
</html>