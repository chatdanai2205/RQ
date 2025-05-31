let currentScoreLevel = 'รวม'; // ค่าเริ่มต้น
// ฟังก์ชันในการกำหนดสีตามค่า value
function getColor(value) {
    if (value < 55) {
        return 'rgba(255, 99, 132, 1)'; // สีแดง
    } else if (value >= 55 && value <= 69) {
        return 'rgba(255, 206, 86, 1)'; // สีเหลือง
    } else {
        return 'green'; // สีเขียว
    }
}
function updateChart(level) {
    currentScoreLevel = level; 

    let genderDataForUpdate = [];
    let yearDataForUpdate = [];
    let departmentDataForUpdate = [];
    let gender_1DataForUpdate = [];
    let department_1DataForUpdate = [];
    let chronic_disease_1DataForUpdate = [];
    let fam_status_1DataForUpdate = [];
    let fam_earn_1DataForUpdate = [];
    let course_1DataForUpdate = [];
    let maxSuggestedValue = 80; // กำหนดค่าพื้นฐานให้เป็น 80
    let backgroundColor = '#8dc4ff';

    if (level === 'รวม') {
        genderDataForUpdate = genderData.map(item => item.count);
        yearDataForUpdate = yearData.map(item => item.count);
        departmentDataForUpdate = departmentData.map(item => item.count);
        gender_1DataForUpdate = gender_1.map(item => (item.avg_total_score !== undefined && item.avg_total_score !== null ? parseFloat(item.avg_total_score).toFixed(1) : "0.0"));
        department_1DataForUpdate = department_1.map(item => (item.avg_total_score !== undefined && item.avg_total_score !== null ? parseFloat(item.avg_total_score).toFixed(1) : "0.0"));
        chronic_disease_1DataForUpdate = chronic_disease_1.map(item => (item.avg_total_score !== undefined && item.avg_total_score !== null ? parseFloat(item.avg_total_score).toFixed(1) : "0.0"));
        fam_status_1DataForUpdate = fam_status_1.map(item => (item.avg_total_score !== undefined && item.avg_total_score !== null ? parseFloat(item.avg_total_score).toFixed(1) : "0.0"));
        fam_earn_1DataForUpdate = fam_earn_1.map(item => (item.avg_total_score !== undefined && item.avg_total_score !== null ? parseFloat(item.avg_total_score).toFixed(1) : "0.0"));
        course_1DataForUpdate = course_1.map(item => (item.avg_total_score !== undefined && item.avg_total_score !== null ? parseFloat(item.avg_total_score).toFixed(1) : "0.0"));
        
        // คำนวณค่า maxSuggestedValue สำหรับกรณี 'รวม'
        maxSuggestedValue = Math.max(
            ...chronic_disease_1DataForUpdate,
            ...fam_status_1DataForUpdate,
            ...fam_earn_1DataForUpdate,
            ...course_1DataForUpdate,
            maxSuggestedValue // ค่าเริ่มต้น
        );
    } else {
        let keySuffix = level === 'ต่ำกว่าเกณฑ์' ? 'below_normal_total_score' :
                        level === 'ปกติ' ? 'normal_total_score' :
                        level === 'สูงกว่าเกณฑ์' ? 'above_normal_total_score' : 'total_score';
        
        genderDataForUpdate = genderScoreData.map(item => (Number(item[keySuffix]) || 0));
        yearDataForUpdate = yearScoreData.map(item => (Number(item[keySuffix]) || 0));
        departmentDataForUpdate = departmentScoreData.map(item => (Number(item[keySuffix]) || 0));
        gender_1DataForUpdate = gender_1.map(item => parseFloat(Number(item[`avg_${keySuffix}`] || 0)).toFixed(1));
        department_1DataForUpdate = department_1.map(item => parseFloat(Number(item[`avg_${keySuffix}`] || 0)).toFixed(1));
        chronic_disease_1DataForUpdate = chronic_disease_1.map(item => parseFloat(Number(item[`avg_${keySuffix}`] || 0)).toFixed(1));
        fam_status_1DataForUpdate = fam_status_1.map(item => parseFloat(Number(item[`avg_${keySuffix}`] || 0)).toFixed(1));
        fam_earn_1DataForUpdate = fam_earn_1.map(item => parseFloat(Number(item[`avg_${keySuffix}`] || 0)).toFixed(1));
        course_1DataForUpdate = course_1.map(item => parseFloat(Number(item[`avg_${keySuffix}`] || 0)).toFixed(1));
        
        // คำนวณค่า maxSuggestedValue สำหรับกรณีที่เลือก level
        maxSuggestedValue = Math.max(
            ...chronic_disease_1DataForUpdate,
            ...fam_status_1DataForUpdate,
            ...fam_earn_1DataForUpdate,
            ...course_1DataForUpdate,
            maxSuggestedValue // ค่าเริ่มต้น
        );
    }
    if (pie_chart5_1?.data?.datasets[0]) {
        pie_chart5_1.data.datasets[0].backgroundColor = backgroundColor; // เปลี่ยนสีพื้นหลัง
        pie_chart5_1.data.datasets[0].datalabels = {
            color: gender_1DataForUpdate.map(value => getColor(value))  // กำหนดสีให้กับแต่ละ datalabels
        };
        pie_chart5_1.options.scales.y.suggestedMax = maxSuggestedValue;

        pie_chart5_1.update();
    }
    
    if (pie_chart7_1?.data?.datasets[0]) {
        pie_chart7_1.data.datasets[0].backgroundColor = backgroundColor; // เปลี่ยนสีพื้นหลัง
        pie_chart7_1.data.datasets[0].datalabels = {
            color: department_1DataForUpdate.map(value => getColor(value))  // กำหนดสีให้กับแต่ละ datalabels
        };
        pie_chart7_1.options.scales.x.suggestedMax = maxSuggestedValue;
        pie_chart7_1.update();
    }
    
    if (pie_chart8_1?.data?.datasets[0]) {
        pie_chart8_1.data.datasets[0].backgroundColor = backgroundColor; // เปลี่ยนสีพื้นหลัง
        pie_chart8_1.data.datasets[0].datalabels = {
            color: chronic_disease_1DataForUpdate.map(value => getColor(value))  // กำหนดสีให้กับแต่ละ datalabels
        };
        pie_chart8_1.options.scales.y.suggestedMax = maxSuggestedValue;
        pie_chart8_1.update();
    }
    
    if (pie_chart9_1?.data?.datasets[0]) {
        pie_chart9_1.data.datasets[0].backgroundColor = backgroundColor; // เปลี่ยนสีพื้นหลัง
        pie_chart9_1.data.datasets[0].datalabels = {
            color: fam_status_1DataForUpdate.map(value => getColor(value))  // กำหนดสีให้กับแต่ละ datalabels
        };
        pie_chart9_1.options.scales.y.suggestedMax = maxSuggestedValue;
        pie_chart9_1.update();
    }
    
    if (pie_chart11_1?.data?.datasets[0]) {
        pie_chart11_1.data.datasets[0].backgroundColor = backgroundColor; // เปลี่ยนสีพื้นหลัง
        pie_chart11_1.data.datasets[0].datalabels = {
            color: fam_earn_1DataForUpdate.map(value => getColor(value))  // กำหนดสีให้กับแต่ละ datalabels
        };
        pie_chart11_1.options.scales.y.suggestedMax = maxSuggestedValue;
        pie_chart11_1.update();
    }
    
    if (pie_chart13_1?.data?.datasets[0]) {
        pie_chart13_1.data.datasets[0].backgroundColor = backgroundColor; // เปลี่ยนสีพื้นหลัง
        pie_chart13_1.data.datasets[0].datalabels = {
            color: course_1DataForUpdate.map(value => getColor(value))  // กำหนดสีให้กับแต่ละ datalabels
        };
        pie_chart13_1.options.scales.y.suggestedMax = maxSuggestedValue;
        pie_chart13_1.update();
    }    

    console.log("currentScoreLevel: ", currentScoreLevel); // ตรวจสอบค่าของ currentScoreLevel
    console.log("maxSuggestedValue: ", maxSuggestedValue); // ตรวจสอบค่าของ maxSuggestedValue
    console.log("backgroundColor: ", backgroundColor); // ตรวจสอบค่า backgroundColor

    updateMultipleCharts(genderDataForUpdate, 
        yearDataForUpdate, departmentDataForUpdate, 
        gender_1DataForUpdate, department_1DataForUpdate, 
        chronic_disease_1DataForUpdate, fam_status_1DataForUpdate, 
        fam_earn_1DataForUpdate, course_1DataForUpdate);
    updateTooltipPercentage(level);
}



// ฟังก์ชันเพื่อกำหนดสีตามประเภทคะแนน (ใช้ getColorByCategory)
function getColorByCategory(value, category){
    if (category === 'all') {
        if (value < 55) {
            return 'rgba(255, 99, 132, 1)'; // สีแดง
        } else if (value >= 55 && value <= 69) {
            return 'rgba(255, 206, 86, 1)'; // สีเหลือง
        } else {
            return 'green'; // สีเขียว
        }
    } else if (category === 'pressure_tolerance') {
        if (value < 23) {
            return 'rgba(255, 99, 132, 1)';  // สีแดง
        }else if (value >= 23 && value <= 34) {
            return 'rgba(255, 206, 86, 1)';  // สีเหลือง
        }else return 'green';  // สีเขียว
    } else if (category === 'hope_and_support'){
        if (value < 14) {
            return 'rgba(255, 99, 132, 1)';  // สีแดง
        }else if (value >= 14 && value <= 19) {
            return 'rgba(255, 206, 86, 1)';  // สีเหลือง
        }else {
            return 'green';  // สีเขียว
        }
    } else if (category === 'overcoming_obstacles') {
        if (value < 13) {
            return 'rgba(255, 99, 132, 1)';  // สีแดง
        }else if (value >= 13 && value <= 18) { 
            return 'rgba(255, 206, 86, 1)';  // สีเหลือง
        }else {
            return 'green';  // สีเขียว
        }
    } else {
        if (value < 55) {
            return 'rgba(255, 99, 132, 1)'; // สีแดง
        } else if (value >= 55 && value <= 69) {
            return 'rgba(255, 206, 86, 1)'; // สีเหลือง
        } else {
            return 'green'; // สีเขียว
        }
    }
}

// ฟังก์ชัน updateChart1 ที่อัปเดตการแสดงผลสี
function updateChart1(level) {
    let gender_1DataForUpdate = [];
    let department_1DataForUpdate = [];
    let chronic_disease_1DataForUpdate = [];
    let fam_status_1DataForUpdate = [];
    let fam_earn_1DataForUpdate = [];
    let course_1DataForUpdate = [];

    const scoreMapping = {
        "รวม": "avg",
        "ต่ำกว่าเกณฑ์": "avg_below_normal",
        "ปกติ": "avg_normal",
        "สูงกว่าเกณฑ์": "avg_above_normal"
    };
    
    const categoryMapping = {
        "all": "total_score",
        "pressure_tolerance": "pressure_tolerance",
        "hope_and_support": "hope_and_support",
        "overcoming_obstacles": "overcoming_obstacles",
        "null": "total_score"  // กรณี category เป็น null จะเป็น total_score
    };

    console.log("currentScoreLevel: ", currentScoreLevel); // ตรวจสอบค่าของ currentScoreLevel
    let scoreKey = scoreMapping[currentScoreLevel] || "avg";  // กำหนด scoreKey ตาม currentScoreLevel
    console.log("scoreKey after mapping: ", scoreKey); // ตรวจสอบค่าของ scoreKey
    let categoryKey = categoryMapping[level] || "total_score";  // กำหนด categoryKey ตาม level หรือใช้ total_score ถ้าเป็น null
    console.log("categoryKey: ", categoryKey); // ตรวจสอบค่าของ categoryKey

    
    let maxSuggestedValue;
    let backgroundColor;
    let label; // เพิ่มตัวแปร label
    
    // กำหนดค่า maxSuggestedValue, backgroundColor, และ label ตามประเภท
        if (currentScoreLevel === "รวม" || currentScoreLevel === "ต่ำกว่าเกณฑ์" || currentScoreLevel === "ปกติ" || currentScoreLevel === "สูงกว่าเกณฑ์") {
            switch (categoryKey) {
                case "total_score":
                    maxSuggestedValue = 80;
                    backgroundColor = '#8dc4ff'; // สีฟ้าสำหรับ total_score
                    label = 'คะแนนเฉลี่ยรวม'; // เพิ่ม label สำหรับ total_score
                    break;
                case "pressure_tolerance":
                    maxSuggestedValue = 40;
                    backgroundColor = '#ffd18d'; // สีส้มสำหรับ pressure_tolerance
                    label = 'คะแนนเฉลี่ยด้านความอดทน'; // เพิ่ม label สำหรับ pressure_tolerance
                    break;
                case "hope_and_support":
                    maxSuggestedValue = 20;
                    backgroundColor = 'hsl(342, 100%, 77%)'; // สีส้มสำหรับ hope_and_support
                    label = 'คะแนนเฉลี่ยด้านกำลังใจ'; // เพิ่ม label สำหรับ hope_and_support
                    break;
                case "overcoming_obstacles":
                    maxSuggestedValue = 20;
                    backgroundColor = '#a8e6a3'; // สีเขียวสำหรับ overcoming_obstacles
                    label = 'คะแนนเฉลี่ยด้านการต่อสู้'; // เพิ่ม label สำหรับ overcoming_obstacles
                    break;
                default:
                    maxSuggestedValue = 80;  // ค่าเริ่มต้นสำหรับกรณีอื่น ๆ
                    backgroundColor = '#8dc4ff'; // สีฟ้าสำหรับกรณีอื่น ๆ
                    label = 'คะแนนเฉลี่ยรวม'; // เพิ่ม label สำหรับกรณีอื่น ๆ
                    break;
            }
        } else {
            // กรณีที่ไม่ตรงกับประเภทที่กำหนด
            maxSuggestedValue = 80;
            backgroundColor = '#8dc4ff'; // สีฟ้าสำหรับค่าเริ่มต้น
            label = 'คะแนนเฉลี่ยรวม'; // เพิ่ม label สำหรับค่าเริ่มต้น
        }

        console.log("maxSuggestedValue: ", maxSuggestedValue); // ตรวจสอบค่าของ maxSuggestedValue
        console.log("backgroundColor: ", backgroundColor); // ตรวจสอบค่า backgroundColor
        console.log("label: ", label); // ตรวจสอบค่า label
        console.log("categoryKey:", categoryKey);
        

    
    // ฟังก์ชันแปลงค่าถ้าไม่ใช่ตัวเลข
    function safeParseFloat(value) {
        return isNaN(parseFloat(value)) ? 0 : parseFloat(value);
    }

    // แปลงค่าต่างๆ ตามระดับคะแนน
    gender_1DataForUpdate = gender_1.map(item => safeParseFloat(item[`${scoreKey}_${categoryKey}`]).toFixed(1));
    department_1DataForUpdate = department_1.map(item => safeParseFloat(item[`${scoreKey}_${categoryKey}`]).toFixed(1));
    chronic_disease_1DataForUpdate = chronic_disease_1.map(item => safeParseFloat(item[`${scoreKey}_${categoryKey}`]).toFixed(1));
    fam_status_1DataForUpdate = fam_status_1.map(item => safeParseFloat(item[`${scoreKey}_${categoryKey}`]).toFixed(1));
    fam_earn_1DataForUpdate = fam_earn_1.map(item => safeParseFloat(item[`${scoreKey}_${categoryKey}`]).toFixed(1));
    course_1DataForUpdate = course_1.map(item => safeParseFloat(item[`${scoreKey}_${categoryKey}`]).toFixed(1));

    // สร้างข้อมูลสีที่อัปเดตตามคะแนน
    let genderColors = gender_1DataForUpdate.map(value => getColorByCategory(value, level));
    let departmentColors = department_1DataForUpdate.map(value => getColorByCategory(value, level));
    let chronicDiseaseColors = chronic_disease_1DataForUpdate.map(value => getColorByCategory(value, level));
    let famStatusColors = fam_status_1DataForUpdate.map(value => getColorByCategory(value, level));
    let famEarnColors = fam_earn_1DataForUpdate.map(value => getColorByCategory(value, level));
    let courseColors = course_1DataForUpdate.map(value => getColorByCategory(value, level));

    // อัปเดตกราฟด้วยสีที่เลือกตามคะแนน (อัปเดตที่ backgroundColor และ borderColor)
    if (pie_chart5_1?.data?.datasets[0]) {
        pie_chart5_1.data.datasets[0].data = gender_1DataForUpdate;
        pie_chart5_1.data.datasets[0].label = label;
        pie_chart5_1.data.datasets[0].backgroundColor = backgroundColor;
        pie_chart5_1.data.datasets[0].datalabels = {
            color: genderColors  // อัปเดตสีของ datalabels
        };
        pie_chart5_1.options.scales.y.suggestedMax = maxSuggestedValue;
        pie_chart5_1.update();
    }
    

    if (pie_chart7_1?.data?.datasets[0]) {
        pie_chart7_1.data.datasets[0].data = department_1DataForUpdate;
        pie_chart7_1.data.datasets[0].label = label;
        pie_chart7_1.data.datasets[0].backgroundColor = backgroundColor;
        pie_chart7_1.data.datasets[0].datalabels = {
            color: departmentColors  // อัปเดตสีของ datalabels
        };
        pie_chart7_1.options.scales.x.suggestedMax = maxSuggestedValue;
        pie_chart7_1.update();
    }

    if (pie_chart8_1?.data?.datasets[0]) {
        pie_chart8_1.data.datasets[0].data = chronic_disease_1DataForUpdate;
        pie_chart8_1.data.datasets[0].label = label;
        pie_chart8_1.data.datasets[0].backgroundColor = backgroundColor;
        pie_chart8_1.data.datasets[0].datalabels = {
            color: chronicDiseaseColors  // อัปเดตสีของ datalabels
        };
        pie_chart8_1.options.scales.y.suggestedMax = maxSuggestedValue;
        pie_chart8_1.update();
    }

    if (pie_chart9_1?.data?.datasets[0]) {
        pie_chart9_1.data.datasets[0].data = fam_status_1DataForUpdate;
        pie_chart9_1.data.datasets[0].label = label;
        pie_chart9_1.data.datasets[0].backgroundColor = backgroundColor;
        pie_chart9_1.data.datasets[0].datalabels = {
            color: famStatusColors  // อัปเดตสีของ datalabels
        };
        pie_chart9_1.options.scales.y.suggestedMax = maxSuggestedValue;
        pie_chart9_1.update();
    }

    if (pie_chart11_1?.data?.datasets[0]) {
        pie_chart11_1.data.datasets[0].data = fam_earn_1DataForUpdate;
        pie_chart11_1.data.datasets[0].label = label;
        pie_chart11_1.data.datasets[0].backgroundColor = backgroundColor;
        pie_chart11_1.data.datasets[0].datalabels = {
            color: famEarnColors  // อัปเดตสีของ datalabels
        };
        pie_chart11_1.options.scales.y.suggestedMax = maxSuggestedValue;
        pie_chart11_1.update();
    }

    if (pie_chart13_1?.data?.datasets[0]) {
        pie_chart13_1.data.datasets[0].data = course_1DataForUpdate;
        pie_chart13_1.data.datasets[0].label = label;
        pie_chart13_1.data.datasets[0].backgroundColor = backgroundColor;
        pie_chart13_1.data.datasets[0].datalabels = {
            color: courseColors  // อัปเดตสีของ datalabels
        };
        pie_chart13_1.options.scales.y.suggestedMax = maxSuggestedValue;
        pie_chart13_1.update();
    }
    updateTooltipPercentage(currentScoreLevel);

}



function updateMultipleCharts(genderDataForUpdate, 
    yearDataForUpdate, departmentDataForUpdate, 
    gender_1DataForUpdate, department_1DataForUpdate, 
    chronic_disease_1DataForUpdate, fam_status_1DataForUpdate, 
    fam_earn_1DataForUpdate, course_1DataForUpdate = []) {

    const chartsToUpdate = [
        { chart: pie_chart2_1, data: genderDataForUpdate },
        { chart: pie_chart3_1, data: yearDataForUpdate },
        { chart: pie_chart4_1, data: departmentDataForUpdate },
        { chart: pie_chart5_1, data: gender_1DataForUpdate },
        { chart: pie_chart7_1, data: department_1DataForUpdate },
        { chart: pie_chart8_1, data: chronic_disease_1DataForUpdate },
        { chart: pie_chart9_1, data: fam_status_1DataForUpdate },
        { chart: pie_chart11_1, data: fam_earn_1DataForUpdate },
        { chart: pie_chart13_1, data: course_1DataForUpdate }
    ];

    chartsToUpdate.forEach(({ chart, data }) => {
        if (chart?.data?.datasets[0]) {
            chart.data.datasets[0].data = data;
            chart.update();
        }
    });
}

function updateTooltipPercentage(level) {
    // เลือกข้อมูลที่ตรงกับระดับ (level) ที่เลือก
    let data = [];
    
    if (level === 'รวม') {
        data = genderScoreData.map(item => Number(item.total_score) || 0); 
    } else if (level === 'ต่ำกว่าเกณฑ์') {
        data = genderScoreData.map(item => Number(item.below_normal_total_score) || 0);  
    } else if (level === 'ปกติ') {
        data = genderScoreData.map(item => Number(item.normal_total_score) || 0);  
    } else if (level === 'สูงกว่าเกณฑ์') {
        data = genderScoreData.map(item => Number(item.above_normal_total_score) || 0); 
    }

    const total = data.reduce((acc, val) => acc + val, 0);  // คำนวณผลรวมของ data โดยตรง

    // ดีบักการแสดงผลรวม
    console.log("Total:", total);
    console.log("Data:", data);

    function generateTooltip(context) {
        const value = context.raw;  // ใช้ค่าจาก context.raw โดยไม่ต้องแปลงใหม่
        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0.0;  // คำนวณเปอร์เซ็นต์ใหม่
        // ดีบักการคำนวณเปอร์เซ็นต์
        console.log("Value:", value, "Percentage:", percentage);
        return `${context.label}: ${value} (${percentage}%)`;  // คืนค่าผลลัพธ์ที่มีเปอร์เซ็นต์
    }

    // อัปเดต tooltip ของกราฟที่เกี่ยวข้อง
    [pie_chart2_1, pie_chart3_1, pie_chart4_1].forEach(chart => {
        if (chart?.options?.plugins?.tooltip) {
            chart.options.plugins.tooltip.callbacks = { label: generateTooltip };  // ตั้งค่าฟังก์ชัน callback ใหม่
            chart.update();  // อัปเดตกราฟหลังจากการเปลี่ยนแปลง
        }
    });
}


