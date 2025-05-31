<?php
require("dbconnect.php");
$servername = "sql200.infinityfree.com";
$username = "if0_38080361"; // ชื่อผู้ใช้ฐานข้อมูล
$password = "e3Aiy9ZhKL1tN5"; // รหัสผ่านฐานข้อมูล
$dbname = "if0_38080361_test_rq"; // ชื่อฐานข้อมูล

try {
    // เชื่อมต่อกับฐานข้อมูล
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // ดึงข้อมูลสำหรับกราฟที่ 1: การแจกแจงคะแนนรวม และคะแนนในแต่ละด้าน
    $sqlall = "SELECT 
                SUM(CASE WHEN total_score < 55 THEN 1 ELSE 0 END) as below_normal_total_score,
                SUM(CASE WHEN total_score >= 55 AND total_score <= 69 THEN 1 ELSE 0 END) as normal_total_score,
                SUM(CASE WHEN total_score > 69 THEN 1 ELSE 0 END) as above_normal_total_score,
                
                SUM(CASE WHEN pressure_tolerance < 23 THEN 1 ELSE 0 END) as below_normal_pressure,
                SUM(CASE WHEN pressure_tolerance >= 23 AND pressure_tolerance <= 34 THEN 1 ELSE 0 END) as normal_pressure,
                SUM(CASE WHEN pressure_tolerance > 34 THEN 1 ELSE 0 END) as above_normal_pressure,
                
                SUM(CASE WHEN hope_and_support < 14 THEN 1 ELSE 0 END) as below_normal_hope,
                SUM(CASE WHEN hope_and_support >= 14 AND hope_and_support <= 19 THEN 1 ELSE 0 END) as normal_hope,
                SUM(CASE WHEN hope_and_support > 19 THEN 1 ELSE 0 END) as above_normal_hope,
                
                SUM(CASE WHEN overcoming_obstacles < 13 THEN 1 ELSE 0 END) as below_normal_obstacles,
                SUM(CASE WHEN overcoming_obstacles >= 13 AND overcoming_obstacles <= 18 THEN 1 ELSE 0 END) as normal_obstacles,
                SUM(CASE WHEN overcoming_obstacles > 18 THEN 1 ELSE 0 END) as above_normal_obstacles
            FROM result r
            JOIN user u ON r.id = u.id";
    $stmt = $conn->prepare($sqlall);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // ดึงข้อมูลสำหรับกราฟที่ 2: การแจกแจงจำนวนผู้ตอบแบบสอบถามตามเพศ
    $sqlGender1 = "SELECT gender, COUNT(*) as count
                FROM user u
                INNER JOIN result r ON u.id = r.id
                GROUP BY u.gender
                ORDER BY 
                    CASE 
                        WHEN u.gender = 'ชาย' THEN 1
                        WHEN u.gender = 'หญิง' THEN 2
                        WHEN u.gender = 'LGBTQA+' THEN 3
                    END";
    $stmt = $conn->prepare($sqlGender1);
    $stmt->execute();
    $genderData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ดึงจำนวนเพศแบ่งตามระดับคะแนน
    $sqlGenderScore = "SELECT u.gender, 
                    COUNT(r.id) as total_score,
                    SUM(CASE WHEN r.total_score < 55 THEN 1 ELSE 0 END) as below_normal_total_score,
                    SUM(CASE WHEN r.total_score >= 55 AND r.total_score <= 69 THEN 1 ELSE 0 END) as normal_total_score,
                    SUM(CASE WHEN r.total_score > 69 THEN 1 ELSE 0 END) as above_normal_total_score
                    FROM user u
                    INNER JOIN result r ON u.id = r.id
                    GROUP BY u.gender
                    ORDER BY 
                        CASE 
                            WHEN u.gender = 'ชาย' THEN 1
                            WHEN u.gender = 'หญิง' THEN 2
                            WHEN u.gender = 'LGBTQA+' THEN 3
                        END";
    $stmt = $conn->prepare($sqlGenderScore);
    $stmt->execute();
    $genderScoreData = $stmt->fetchAll(PDO::FETCH_ASSOC);


    // ดึงข้อมูลสำหรับกราฟที่ 3: การแจกแจงจำนวนผู้ตอบแบบสอบถามตามชั้นปี
    $sqlYear1 = "SELECT year, COUNT(*) as count
                FROM user u
                INNER JOIN result r ON u.id = r.id
                GROUP BY u.year 
                ORDER BY u.year ASC";
    $stmt = $conn->prepare($sqlYear1);
    $stmt->execute();
    $yearData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sqlYearScore = "SELECT u.year, 
                    SUM(CASE WHEN r.total_score < 55 THEN 1 ELSE 0 END) as below_normal_total_score,
                    SUM(CASE WHEN r.total_score >= 55 AND r.total_score <= 69 THEN 1 ELSE 0 END) as normal_total_score,
                    SUM(CASE WHEN r.total_score > 69 THEN 1 ELSE 0 END) as above_normal_total_score
                    FROM user u
                    INNER JOIN result r ON u.id = r.id
                    GROUP BY u.year 
                    ORDER BY u.year ASC";
    $stmt = $conn->prepare($sqlYearScore);
    $stmt->execute();
    $yearScoreData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ดึงข้อมูลสำหรับกราฟที่ 4: การแจกแจงจำนวนผู้ตอบแบบสอบถามตามสาขา
    $sqlDepartment1 = "SELECT department, COUNT(*) as count
                FROM user u
                INNER JOIN result r ON u.id = r.id
                GROUP BY department";
    $stmt = $conn->prepare($sqlDepartment1);
    $stmt->execute();
    $departmentData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sqlDepartmentScore = "SELECT u.department, 
                    SUM(CASE WHEN r.total_score < 55 THEN 1 ELSE 0 END) as below_normal_total_score,
                    SUM(CASE WHEN r.total_score >= 55 AND r.total_score <= 69 THEN 1 ELSE 0 END) as normal_total_score,
                    SUM(CASE WHEN r.total_score > 69 THEN 1 ELSE 0 END) as above_normal_total_score
                    FROM user u
                    INNER JOIN result r ON u.id = r.id
                    GROUP BY u.department
                    ORDER BY u.department ASC";
    $stmt = $conn->prepare($sqlDepartmentScore);
    $stmt->execute();
    $departmentScoreData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ดึงข้อมูลสำหรับกราฟที่ 5: ค่าเฉลี่ยคะแนนในแต่ละด้านแยกตามเพศ
    $sqlGender = "SELECT u.gender,
                    
                    -- คำนวณค่าเฉลี่ยของคะแนนรวมตามระดับคะแนน
                    AVG(r.total_score) AS avg_total_score,
                    AVG(r.pressure_tolerance) AS avg_pressure_tolerance,
                    AVG(r.hope_and_support) AS avg_hope_and_support,
                    AVG(r.overcoming_obstacles) AS avg_overcoming_obstacles,

                    -- คำนวณค่าเฉลี่ยของคะแนนรวมในแต่ละระดับ
                    AVG(CASE WHEN r.total_score < 55 THEN r.total_score ELSE NULL END) AS avg_below_normal_total_score,
                    AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.total_score ELSE NULL END) AS avg_normal_total_score,
                    AVG(CASE WHEN r.total_score > 69 THEN r.total_score ELSE NULL END) AS avg_above_normal_total_score,
                    -- คำนวณค่าเฉลี่ยของแต่ละด้านตามระดับคะแนน
                    AVG(CASE WHEN r.total_score < 55 THEN r.pressure_tolerance ELSE NULL END) AS avg_below_normal_pressure_tolerance,
                    AVG(CASE WHEN r.total_score < 55 THEN r.hope_and_support ELSE NULL END) AS avg_below_normal_hope_and_support,
                    AVG(CASE WHEN r.total_score < 55 THEN r.overcoming_obstacles ELSE NULL END) AS avg_below_normal_overcoming_obstacles,
                    
                    AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.pressure_tolerance ELSE NULL END) AS avg_normal_pressure_tolerance,
                    AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.hope_and_support ELSE NULL END) AS avg_normal_hope_and_support,
                    AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.overcoming_obstacles ELSE NULL END) AS avg_normal_overcoming_obstacles,

                    AVG(CASE WHEN r.total_score > 69 THEN r.pressure_tolerance ELSE NULL END) AS avg_above_normal_pressure_tolerance,
                    AVG(CASE WHEN r.total_score > 69 THEN r.hope_and_support ELSE NULL END) AS avg_above_normal_hope_and_support,
                    AVG(CASE WHEN r.total_score > 69 THEN r.overcoming_obstacles ELSE NULL END) AS avg_above_normal_overcoming_obstacles

                FROM 
                    user u
                INNER JOIN result r ON u.id = r.id
                GROUP BY 
                    u.gender
                ORDER BY 
                    CASE 
                        WHEN u.gender = 'ชาย' THEN 1
                        WHEN u.gender = 'หญิง' THEN 2
                        WHEN u.gender = 'LGBTQA+' THEN 3
                    END";
    $stmt = $conn->prepare($sqlGender);
    $stmt->execute();
    $GenderAVG = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ดึงข้อมูลสำหรับกราฟที่ 7: ค่าเฉลี่ยคะแนนในแต่ละด้านแยกตามสาขา
    $sqlDepartment = "SELECT u.department,
                    
                    -- คำนวณค่าเฉลี่ยของคะแนนรวมตามระดับคะแนน
                    AVG(r.total_score) AS avg_total_score,
                    AVG(r.pressure_tolerance) AS avg_pressure_tolerance,
                    AVG(r.hope_and_support) AS avg_hope_and_support,
                    AVG(r.overcoming_obstacles) AS avg_overcoming_obstacles,

                    -- คำนวณค่าเฉลี่ยของคะแนนรวมในแต่ละระดับ
                    AVG(CASE WHEN r.total_score < 55 THEN r.total_score ELSE NULL END) AS avg_below_normal_total_score,
                    AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.total_score ELSE NULL END) AS avg_normal_total_score,
                    AVG(CASE WHEN r.total_score > 69 THEN r.total_score ELSE NULL END) AS avg_above_normal_total_score,
                    -- คำนวณค่าเฉลี่ยของแต่ละด้านตามระดับคะแนน
                    AVG(CASE WHEN r.total_score < 55 THEN r.pressure_tolerance ELSE NULL END) AS avg_below_normal_pressure_tolerance,
                    AVG(CASE WHEN r.total_score < 55 THEN r.hope_and_support ELSE NULL END) AS avg_below_normal_hope_and_support,
                    AVG(CASE WHEN r.total_score < 55 THEN r.overcoming_obstacles ELSE NULL END) AS avg_below_normal_overcoming_obstacles,
                    
                    AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.pressure_tolerance ELSE NULL END) AS avg_normal_pressure_tolerance,
                    AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.hope_and_support ELSE NULL END) AS avg_normal_hope_and_support,
                    AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.overcoming_obstacles ELSE NULL END) AS avg_normal_overcoming_obstacles,

                    AVG(CASE WHEN r.total_score > 69 THEN r.pressure_tolerance ELSE NULL END) AS avg_above_normal_pressure_tolerance,
                    AVG(CASE WHEN r.total_score > 69 THEN r.hope_and_support ELSE NULL END) AS avg_above_normal_hope_and_support,
                    AVG(CASE WHEN r.total_score > 69 THEN r.overcoming_obstacles ELSE NULL END) AS avg_above_normal_overcoming_obstacles

                FROM 
                    user u
                INNER JOIN result r ON u.id = r.id
                GROUP BY 
                    u.department
                ORDER BY 
                    u.department ASC";
    $stmt = $conn->prepare($sqlDepartment);
    $stmt->execute();
    $DepartmentAVG = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ดึงข้อมูลสำหรับกราฟที่ 8: ค่าเฉลี่ยคะแนนในแต่ละด้านแยกตามการมีโรคประจำตัว
    $sqlChronic_disease = "SELECT u.chronic_disease,
                    -- คำนวณค่าเฉลี่ยของคะแนนรวมตามระดับคะแนน
                        AVG(r.total_score) AS avg_total_score,
                        AVG(r.pressure_tolerance) AS avg_pressure_tolerance,
                        AVG(r.hope_and_support) AS avg_hope_and_support,
                        AVG(r.overcoming_obstacles) AS avg_overcoming_obstacles,

                        -- คำนวณค่าเฉลี่ยของคะแนนรวมในแต่ละระดับ
                        AVG(CASE WHEN r.total_score < 55 THEN r.total_score ELSE NULL END) AS avg_below_normal_total_score,
                        AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.total_score ELSE NULL END) AS avg_normal_total_score,
                        AVG(CASE WHEN r.total_score > 69 THEN r.total_score ELSE NULL END) AS avg_above_normal_total_score,
                        -- คำนวณค่าเฉลี่ยของแต่ละด้านตามระดับคะแนน
                        AVG(CASE WHEN r.total_score < 55 THEN r.pressure_tolerance ELSE NULL END) AS avg_below_normal_pressure_tolerance,
                        AVG(CASE WHEN r.total_score < 55 THEN r.hope_and_support ELSE NULL END) AS avg_below_normal_hope_and_support,
                        AVG(CASE WHEN r.total_score < 55 THEN r.overcoming_obstacles ELSE NULL END) AS avg_below_normal_overcoming_obstacles,
                        
                        AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.pressure_tolerance ELSE NULL END) AS avg_normal_pressure_tolerance,
                        AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.hope_and_support ELSE NULL END) AS avg_normal_hope_and_support,
                        AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.overcoming_obstacles ELSE NULL END) AS avg_normal_overcoming_obstacles,

                        AVG(CASE WHEN r.total_score > 69 THEN r.pressure_tolerance ELSE NULL END) AS avg_above_normal_pressure_tolerance,
                        AVG(CASE WHEN r.total_score > 69 THEN r.hope_and_support ELSE NULL END) AS avg_above_normal_hope_and_support,
                        AVG(CASE WHEN r.total_score > 69 THEN r.overcoming_obstacles ELSE NULL END) AS avg_above_normal_overcoming_obstacles

                FROM 
                    user u
                INNER JOIN result r ON u.id = r.id
                GROUP BY 
                    u.chronic_disease
                ORDER BY 
                    u.chronic_disease";
    $stmt = $conn->prepare($sqlChronic_disease);
    $stmt->execute();
    $Chronic_diseaseAVG = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ดึงข้อมูลสำหรับกราฟที่ 9: ค่าเฉลี่ยคะแนนในแต่ละด้านแยกตามสถานะครอบครัว
    $sqlFam_status = "SELECT u.fam_status,
                    -- คำนวณค่าเฉลี่ยของคะแนนรวมตามระดับคะแนน
                    AVG(r.total_score) AS avg_total_score,
                        AVG(r.pressure_tolerance) AS avg_pressure_tolerance,
                        AVG(r.hope_and_support) AS avg_hope_and_support,
                        AVG(r.overcoming_obstacles) AS avg_overcoming_obstacles,

                        -- คำนวณค่าเฉลี่ยของคะแนนรวมในแต่ละระดับ
                        AVG(CASE WHEN r.total_score < 55 THEN r.total_score ELSE NULL END) AS avg_below_normal_total_score,
                        AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.total_score ELSE NULL END) AS avg_normal_total_score,
                        AVG(CASE WHEN r.total_score > 69 THEN r.total_score ELSE NULL END) AS avg_above_normal_total_score,
                        -- คำนวณค่าเฉลี่ยของแต่ละด้านตามระดับคะแนน
                        AVG(CASE WHEN r.total_score < 55 THEN r.pressure_tolerance ELSE NULL END) AS avg_below_normal_pressure_tolerance,
                        AVG(CASE WHEN r.total_score < 55 THEN r.hope_and_support ELSE NULL END) AS avg_below_normal_hope_and_support,
                        AVG(CASE WHEN r.total_score < 55 THEN r.overcoming_obstacles ELSE NULL END) AS avg_below_normal_overcoming_obstacles,
                        
                        AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.pressure_tolerance ELSE NULL END) AS avg_normal_pressure_tolerance,
                        AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.hope_and_support ELSE NULL END) AS avg_normal_hope_and_support,
                        AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.overcoming_obstacles ELSE NULL END) AS avg_normal_overcoming_obstacles,

                        AVG(CASE WHEN r.total_score > 69 THEN r.pressure_tolerance ELSE NULL END) AS avg_above_normal_pressure_tolerance,
                        AVG(CASE WHEN r.total_score > 69 THEN r.hope_and_support ELSE NULL END) AS avg_above_normal_hope_and_support,
                        AVG(CASE WHEN r.total_score > 69 THEN r.overcoming_obstacles ELSE NULL END) AS avg_above_normal_overcoming_obstacles

                FROM 
                    user u
                INNER JOIN result r ON u.id = r.id
                GROUP BY 
                    u.fam_status
                ORDER BY 
                    CASE 
                        WHEN u.fam_status = 'บิดามารดาอยู่ด้วยกัน' THEN 1
                        WHEN u.fam_status = 'บิดามารดาแยกกันอยู่' THEN 2
                        WHEN u.fam_status = 'บิดา และ/หรือ มารดาเสียชีวิต' THEN 3
                        ELSE 4
                    END";
    $stmt = $conn->prepare($sqlFam_status);
    $stmt->execute();
    $Fam_statusAVG = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ดึงข้อมูลสำหรับกราฟที่ 10: ค่าเฉลี่ยคะแนนในแต่ละด้านแยกตามอาชีพครอบครัว
    $sqlFam_careerAVG = "SELECT u.fam_career,
                    -- คำนวณค่าเฉลี่ยของคะแนนรวมตามระดับคะแนน
                    AVG(r.total_score) AS avg_total_score,
                    AVG(r.pressure_tolerance) AS avg_pressure_tolerance,
                    AVG(r.hope_and_support) AS avg_hope_and_support,
                    AVG(r.overcoming_obstacles) AS avg_overcoming_obstacles,

                    -- คำนวณค่าเฉลี่ยของคะแนนรวมในแต่ละระดับ
                    AVG(CASE WHEN r.total_score < 55 THEN r.total_score ELSE NULL END) AS avg_below_normal_total_score,
                    AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.total_score ELSE NULL END) AS avg_normal_total_score,
                    AVG(CASE WHEN r.total_score > 69 THEN r.total_score ELSE NULL END) AS avg_above_normal_total_score,
                    -- คำนวณค่าเฉลี่ยของแต่ละด้านตามระดับคะแนน
                    AVG(CASE WHEN r.total_score < 55 THEN r.pressure_tolerance ELSE NULL END) AS avg_below_normal_pressure_tolerance,
                    AVG(CASE WHEN r.total_score < 55 THEN r.hope_and_support ELSE NULL END) AS avg_below_normal_hope_and_support,
                    AVG(CASE WHEN r.total_score < 55 THEN r.overcoming_obstacles ELSE NULL END) AS avg_below_normal_overcoming_obstacles,
                    
                    AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.pressure_tolerance ELSE NULL END) AS avg_normal_pressure_tolerance,
                    AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.hope_and_support ELSE NULL END) AS avg_normal_hope_and_support,
                    AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.overcoming_obstacles ELSE NULL END) AS avg_normal_overcoming_obstacles,

                    AVG(CASE WHEN r.total_score > 69 THEN r.pressure_tolerance ELSE NULL END) AS avg_above_normal_pressure_tolerance,
                    AVG(CASE WHEN r.total_score > 69 THEN r.hope_and_support ELSE NULL END) AS avg_above_normal_hope_and_support,
                    AVG(CASE WHEN r.total_score > 69 THEN r.overcoming_obstacles ELSE NULL END) AS avg_above_normal_overcoming_obstacles

                FROM 
                    user u
                INNER JOIN result r ON u.id = r.id
                GROUP BY 
                    u.fam_career
                ORDER BY 
                    u.fam_career";
    $stmt = $conn->prepare($sqlFam_careerAVG);
    $stmt->execute();
    $Fam_careerAVG = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ดึงข้อมูลสำหรับกราฟที่ 11: ค่าเฉลี่ยคะแนนในแต่ละด้านแยกตามรายได้ครอบครัว
    $sqlFam_earnAVG = "SELECT u.fam_earn,
                            -- คำนวณค่าเฉลี่ยของคะแนนรวมตามระดับคะแนน
                    AVG(r.total_score) AS avg_total_score,
                    AVG(r.pressure_tolerance) AS avg_pressure_tolerance,
                    AVG(r.hope_and_support) AS avg_hope_and_support,
                    AVG(r.overcoming_obstacles) AS avg_overcoming_obstacles,

                    -- คำนวณค่าเฉลี่ยของคะแนนรวมในแต่ละระดับ
                    AVG(CASE WHEN r.total_score < 55 THEN r.total_score ELSE NULL END) AS avg_below_normal_total_score,
                    AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.total_score ELSE NULL END) AS avg_normal_total_score,
                    AVG(CASE WHEN r.total_score > 69 THEN r.total_score ELSE NULL END) AS avg_above_normal_total_score,
                    -- คำนวณค่าเฉลี่ยของแต่ละด้านตามระดับคะแนน
                    AVG(CASE WHEN r.total_score < 55 THEN r.pressure_tolerance ELSE NULL END) AS avg_below_normal_pressure_tolerance,
                    AVG(CASE WHEN r.total_score < 55 THEN r.hope_and_support ELSE NULL END) AS avg_below_normal_hope_and_support,
                    AVG(CASE WHEN r.total_score < 55 THEN r.overcoming_obstacles ELSE NULL END) AS avg_below_normal_overcoming_obstacles,
                    
                    AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.pressure_tolerance ELSE NULL END) AS avg_normal_pressure_tolerance,
                    AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.hope_and_support ELSE NULL END) AS avg_normal_hope_and_support,
                    AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.overcoming_obstacles ELSE NULL END) AS avg_normal_overcoming_obstacles,

                    AVG(CASE WHEN r.total_score > 69 THEN r.pressure_tolerance ELSE NULL END) AS avg_above_normal_pressure_tolerance,
                    AVG(CASE WHEN r.total_score > 69 THEN r.hope_and_support ELSE NULL END) AS avg_above_normal_hope_and_support,
                    AVG(CASE WHEN r.total_score > 69 THEN r.overcoming_obstacles ELSE NULL END) AS avg_above_normal_overcoming_obstacles

                FROM 
                    user u
                INNER JOIN result r ON u.id = r.id
                GROUP BY 
                    u.fam_earn
                ORDER BY 
                    CASE 
                        WHEN u.fam_earn = 'ต่ำกว่า 9,000 บาท' THEN 1
                        WHEN u.fam_earn = '9,001-20,000 บาท' THEN 2
                        WHEN u.fam_earn = '20,001-40,000 บาท' THEN 3
                        WHEN u.fam_earn = '40,001 บาทขึ้นไป' THEN 4
                        ELSE 5
                    END";
    $stmt = $conn->prepare($sqlFam_earnAVG);
    $stmt->execute();
    $Fam_earnAVG = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ดึงข้อมูลสำหรับกราฟที่ 12: ค่าเฉลี่ยคะแนนในแต่ละด้านแยกตามเกรดเฉลี่ย
    $sqlGpaAVG = "SELECT u.gpa,
                        -- คำนวณค่าเฉลี่ยของคะแนนรวมตามระดับคะแนน
                    AVG(r.total_score) AS avg_total_score,
                    AVG(r.pressure_tolerance) AS avg_pressure_tolerance,
                    AVG(r.hope_and_support) AS avg_hope_and_support,
                    AVG(r.overcoming_obstacles) AS avg_overcoming_obstacles,

                    -- คำนวณค่าเฉลี่ยของคะแนนรวมในแต่ละระดับ
                    AVG(CASE WHEN r.total_score < 55 THEN r.total_score ELSE NULL END) AS avg_below_normal_total_score,
                    AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.total_score ELSE NULL END) AS avg_normal_total_score,
                    AVG(CASE WHEN r.total_score > 69 THEN r.total_score ELSE NULL END) AS avg_above_normal_total_score,
                    -- คำนวณค่าเฉลี่ยของแต่ละด้านตามระดับคะแนน
                    AVG(CASE WHEN r.total_score < 55 THEN r.pressure_tolerance ELSE NULL END) AS avg_below_normal_pressure_tolerance,
                    AVG(CASE WHEN r.total_score < 55 THEN r.hope_and_support ELSE NULL END) AS avg_below_normal_hope_and_support,
                    AVG(CASE WHEN r.total_score < 55 THEN r.overcoming_obstacles ELSE NULL END) AS avg_below_normal_overcoming_obstacles,
                    
                    AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.pressure_tolerance ELSE NULL END) AS avg_normal_pressure_tolerance,
                    AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.hope_and_support ELSE NULL END) AS avg_normal_hope_and_support,
                    AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.overcoming_obstacles ELSE NULL END) AS avg_normal_overcoming_obstacles,

                    AVG(CASE WHEN r.total_score > 69 THEN r.pressure_tolerance ELSE NULL END) AS avg_above_normal_pressure_tolerance,
                    AVG(CASE WHEN r.total_score > 69 THEN r.hope_and_support ELSE NULL END) AS avg_above_normal_hope_and_support,
                    AVG(CASE WHEN r.total_score > 69 THEN r.overcoming_obstacles ELSE NULL END) AS avg_above_normal_overcoming_obstacles

                FROM 
                    user u
                INNER JOIN result r ON u.id = r.id
                GROUP BY 
                    u.gpa
                ORDER BY 
                    u.gpa";
    $stmt = $conn->prepare($sqlGpaAVG);
    $stmt->execute();
    $GpaAVG = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ดึงข้อมูลสำหรับกราฟที่ 13: ค่าเฉลี่ยคะแนนในแต่ละด้านแยกตามหลักสูตร
    $sqlCourseAVG = "SELECT u.course,
                        -- คำนวณค่าเฉลี่ยของคะแนนรวมตามระดับคะแนน
                    AVG(r.total_score) AS avg_total_score,
                    AVG(r.pressure_tolerance) AS avg_pressure_tolerance,
                    AVG(r.hope_and_support) AS avg_hope_and_support,
                    AVG(r.overcoming_obstacles) AS avg_overcoming_obstacles,

                    -- คำนวณค่าเฉลี่ยของคะแนนรวมในแต่ละระดับ
                    AVG(CASE WHEN r.total_score < 55 THEN r.total_score ELSE NULL END) AS avg_below_normal_total_score,
                    AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.total_score ELSE NULL END) AS avg_normal_total_score,
                    AVG(CASE WHEN r.total_score > 69 THEN r.total_score ELSE NULL END) AS avg_above_normal_total_score,
                    -- คำนวณค่าเฉลี่ยของแต่ละด้านตามระดับคะแนน
                    AVG(CASE WHEN r.total_score < 55 THEN r.pressure_tolerance ELSE NULL END) AS avg_below_normal_pressure_tolerance,
                    AVG(CASE WHEN r.total_score < 55 THEN r.hope_and_support ELSE NULL END) AS avg_below_normal_hope_and_support,
                    AVG(CASE WHEN r.total_score < 55 THEN r.overcoming_obstacles ELSE NULL END) AS avg_below_normal_overcoming_obstacles,
                    
                    AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.pressure_tolerance ELSE NULL END) AS avg_normal_pressure_tolerance,
                    AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.hope_and_support ELSE NULL END) AS avg_normal_hope_and_support,
                    AVG(CASE WHEN r.total_score BETWEEN 55 AND 69 THEN r.overcoming_obstacles ELSE NULL END) AS avg_normal_overcoming_obstacles,

                    AVG(CASE WHEN r.total_score > 69 THEN r.pressure_tolerance ELSE NULL END) AS avg_above_normal_pressure_tolerance,
                    AVG(CASE WHEN r.total_score > 69 THEN r.hope_and_support ELSE NULL END) AS avg_above_normal_hope_and_support,
                    AVG(CASE WHEN r.total_score > 69 THEN r.overcoming_obstacles ELSE NULL END) AS avg_above_normal_overcoming_obstacles

                FROM 
                    user u
                INNER JOIN result r ON u.id = r.id
                GROUP BY 
                    u.course
                ORDER BY 
                    u.course";
    $stmt = $conn->prepare($sqlCourseAVG);
    $stmt->execute();
    $CourseAVG = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>แบบประเมิน RQ</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <!-- Custom CSS Link -->
    <link rel="stylesheet" href="style28-5(1).css">

</head>
<p id="total-display"></p>
<body class="home-page">
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
    <div class="dashboard">
        <div class="message-box">
            <button class="box" id="box1" onclick="updateChart('รวม')">
                <div class="primary-text1"><i class="fa-solid fa-users"></i> จำนวนผู้ทำแบบประเมินทั้งหมด</div> 
                <h1 class="text1">
                    <?php
                        try {
                            // เขียน SQL Statement
                            $sql = "SELECT COUNT(*) as id FROM result r JOIN user u ON r.id = u.id";
                            $query = $conn->prepare($sql);
                            $query->execute();
                            $fetch = $query->fetch(); // ไม่ต้องส่งอาร์กิวเมนต์ที่ fetch()
                            // แสดงผลจำนวนคน
                            echo $fetch['id']; 
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage(); // หากเกิดข้อผิดพลาดจะมีการแสดง error
                        }
                    ?>
                    <a class="primary-text1"> คน</a>
                </h1>

                </h1>
                <button onclick="updateChart('all')" style="display:none; background: transparent; border: 0px;">คลิ๊กเพื่อดูเพิ่มเติม</button>
            </button>
            <button class="box" id="box2" style="color: #ff6384;" onclick="updateChart('ต่ำกว่าเกณฑ์')">
                <h1>
                    <div class="gauge" id="gauge1">
                        <div class="gauge__body" >
                            <div class="gauge__fill" style="background: rgb(223, 67, 29);"></div>
                            <div class="gauge__cover" style="background:rgb(255, 255, 255); color: rgb(223, 67, 29);;">
                                <?php
                                    if ($result) {
                                        $total_count = $result['below_normal_total_score'] + $result['normal_total_score'] + $result['above_normal_total_score'] ?? 0;
                                        echo ($total_count > 0) ? number_format(($result['below_normal_total_score'] / $total_count) * 100) . "%" : "ไม่มีข้อมูลเพื่อแสดงผล";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>    
                </h1>
                <div class="primary-text1"style="color: rgb(223, 67, 29);">
                    <?php 
                        echo "จำนวน ". $result['below_normal_total_score']. " คน";
                    ?>
                </div>
                <div class="primary-text1" style="color: rgb(223, 67, 29);">ต่ำกว่าเกณฑ์ปกติ</div>
                <a>คลิ๊กเพื่อดูเพิ่มเติม</a>
            </button>
            <button class="box" id="box3" style="color: rgba(255, 204, 0, 1);" onclick="updateChart('ปกติ')">
                <h1>
                    <div class="gauge" id="gauge2">
                        <div class="gauge__body" >
                            
                            <div class="gauge__fill" style="background: rgba(255, 204, 0, 1);"></div>
                            <div class="gauge__cover" style="background: rgb(255, 255, 255); color: rgba(255, 204, 0, 1);">
                                <?php
                                    if ($result) {
                                        $total_count = $result['below_normal_total_score'] + $result['normal_total_score'] + $result['above_normal_total_score'];
                                        echo ($total_count > 0) ? number_format(($result['normal_total_score'] / $total_count) * 100) . "%" : "ไม่มีข้อมูลเพื่อแสดงผล";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </h1>
                <div class="primary-text1"style="color: rgba(255, 204, 0, 1);">
                    <?php 
                        echo "จำนวน ". $result['normal_total_score']. " คน";
                    ?>
                </div>
                <div class="primary-text1" style="color: rgba(255, 204, 0, 1);">เกณฑ์ปกติ</div>
                <a>คลิ๊กเพื่อดูเพิ่มเติม</a>
            </button>
            <button class="box" id="box4" style="background: rgb(255, 255, 255); color:hsl(101, 81.10%, 45.70%);" onclick="updateChart('สูงกว่าเกณฑ์')">
                <h1>
                    <div class="gauge" id="gauge3">
                        <div class="gauge__body" >        
                            <div class="gauge__fill" style="background: rgb(81, 255, 0);"></div>
                            <div class="gauge__cover" style="background: hsl(0, 0.00%, 100.00%); color: hsl(101, 81.10%, 45.70%);">
                                <?php
                                    if ($result) {
                                        $total_count = $result['below_normal_total_score'] + $result['normal_total_score'] + $result['above_normal_total_score'];
                                        echo ($total_count > 0) ? number_format(($result['above_normal_total_score'] / $total_count) * 100) . "%" : "ไม่มีข้อมูลเพื่อแสดงผล";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>    
                </h1>
                <div class="primary-text1"style="color: hsl(101, 81.10%, 45.70%);">
                    <?php 
                        echo "จำนวน ". $result['above_normal_total_score']. " คน";
                    ?>
                </div>
                <div class="primary-text1" style="color: hsl(101, 81.10%, 45.70%);">สูงกว่าเกณฑ์ปกติ</div>
                <a>คลิ๊กเพื่อดูเพิ่มเติม</a>
            </button>
        </div>
        <div class="message-box">
            <div class="box">
                <div class="containered">
                    <script>
                        const genderData = <?php echo json_encode($genderData); ?>;
                        const genderScoreData = <?php echo json_encode($genderScoreData); ?>;
                    </script>
                    <canvas id="pie_chart2_1"></canvas>
                </div>
            </div>
            <div class="box">
                <div class="containered">
                    <script>
                        const yearData = <?php echo json_encode($yearData); ?>;
                        const yearScoreData = <?php echo json_encode($yearScoreData); ?>;
                    </script>
                    <canvas id="pie_chart3_1"></canvas>
                </div>
            </div>
            <div class="box">
                <div class="containered">
                <script>
                        const departmentData = <?php echo json_encode($departmentData); ?>;
                        const departmentScoreData = <?php echo json_encode($departmentScoreData); ?>;
                    </script>
                    <canvas id="pie_chart4_1"></canvas>
                </div>
            </div>
        </div>
        <div class="message-box">
            <div class="button-dash">
                <button onclick="updateChart1('all')" class="fill_btn" >คะแนนรวม</button>
                <button onclick="updateChart1('pressure_tolerance')" class="fill_btn" >ด้านความอดทน</button>
                <button onclick="updateChart1('hope_and_support')" class="fill_btn" >ด้านความกำลังใจ</button>
                <button onclick="updateChart1('overcoming_obstacles')" class="fill_btn" >ด้านการต่อสู้</button>
                <a>หมายเหตุ: สีของตัวเลขบนแท่งกราฟ <a style="color: red;">สีแดง</a> -> ผลคะแนนต่ำกว่าเกณฑ์ปกติ
                <a style="color: orange;">สีส้ม</a> -> ผลคะแนนอยู่ในเกณฑ์ปกติ
                <a style="color: green;">สีเขียว</a> -> ผลคะแนนสูงกว่าเกณฑ์ปกติ</a>
            </div>
        </div>
        <div class="message-box" >
            <div class="box">
                <h3>กราฟที่ 4 : คะแนนเฉลี่ยตามเพศ</h3> 
                <div class="containered" id="chart_5">
                    <script>
                        const gender_1 = <?php echo json_encode($GenderAVG); ?>;
                    </script>
                    <canvas id="pie_chart5_1"></canvas>
                </div>
            </div>    
            <div class="box" >
                <h3>กราฟที่ 5 : คะแนนเฉลี่ยตามภาควิชา</h3>
                <div class="containered" id="chart_7">
                    <script>
                        const department_1 = <?php echo json_encode($DepartmentAVG, JSON_UNESCAPED_UNICODE); ?>;
                    </script>
                    <canvas id="pie_chart7_1"></canvas>
                </div>
            </div>
            <div class="box">
                <h3>กราฟที่ 6 : คะแนนเฉลี่ยตามโรคประจำตัว</h3> 
                <div class="containered" id="chart_8">
                    <script>
                        const chronic_disease_1 = <?php echo json_encode($Chronic_diseaseAVG, JSON_UNESCAPED_UNICODE); ?>;
                    </script>
                    <canvas id="pie_chart8_1"></canvas>
                </div>
            </div>
        </div>
        <div class="message-box">
            <div class="box">
                <h3>กราฟที่ 7 : คะแนนเฉลี่ยตามสสถานะครอบครัว</h3> 
                <div class="containered">
                    <script>
                        const fam_status_1 = <?php echo json_encode($Fam_statusAVG, JSON_UNESCAPED_UNICODE); ?>;
                    </script>
                    <canvas id="pie_chart9_1"></canvas>
                </div>
            </div>
            <div class="box">
                <h3>กราฟที่ 8 : คะแนนเฉลี่ยตามรายได้ของครอบครัว</h3> 
                <div class="containered">
                    <script>
                        const fam_earn_1 = <?php echo json_encode($Fam_earnAVG, JSON_UNESCAPED_UNICODE); ?>;
                    </script>
                    <canvas id="pie_chart11_1"></canvas>
                </div>
            </div>
            <div class="box">
                <h3>กราฟที่ 9 : คะแนนเฉลี่ยตามความคิดเห็นที่มีต่อหลักสูตร</h3> 
                <div class="containered">
                    <script>
                        const course_1 = <?php echo json_encode($CourseAVG, JSON_UNESCAPED_UNICODE); ?>;
                    </script>
                    <canvas id="pie_chart13_1"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script>
        function setGaugeValue(gauge, value) {
            if (value < 0 || value > 1) {
                return;
            }
            gauge.querySelector(".gauge__fill").style.transform = `rotate(${value / 2}turn)`;
        }

        document.addEventListener("DOMContentLoaded", function () {
            const gauge1 = document.querySelector("#gauge1");
            const gauge2 = document.querySelector("#gauge2");
            const gauge3 = document.querySelector("#gauge3");

            // ดึงค่าจาก PHP แล้วแปลงเป็นตัวเลข
            const belowNormalPercentage = <?= ($total_count > 0) ? ($result['below_normal_total_score'] / $total_count) : 0 ?>;
            const normalPercentage = <?= ($total_count > 0) ? ($result['normal_total_score'] / $total_count) : 0 ?>;
            const aboveNormalPercentage = <?= ($total_count > 0) ? ($result['above_normal_total_score'] / $total_count) : 0 ?>;

            // ตั้งค่าให้หมุน
            setGaugeValue(gauge1, belowNormalPercentage);
            setGaugeValue(gauge2, normalPercentage);
            setGaugeValue(gauge3, aboveNormalPercentage);
        });
    </script>

    <script src="js/charttrrrrrrttt.js"></script>
    <script src="js/charttt2 copy.js"></script>
    <script src="js/charttt3 copy.js"></script>
    <script src="js/charttt4 copy.js"></script>
    <script src="js/charttttt5 copy.js"></script>
    <script src="js/chartttttt7 copy.js"></script>
    <script src="js/chartttt8 copy.js"></script>
    <script src="js/charttttttt9 copy.js"></script>
    <script src="js/chartttt11 copy.js"></script>
    <script src="js/chartttt13 copy.js"></script>
    <script src="js/script.js"></script>
</body>
</html>