const ctx11_1 = document.getElementById('pie_chart11_1').getContext('2d');

// กำหนดค่า configuration ของกราฟ
const cfg11_1 = {
  type: 'bar',
  data: {
    labels: fam_earn_1.map(item => item.fam_earn), // ชื่อเพศ
    datasets: [{
        label: 'คะแนนเฉลี่ยรวม',
        data: fam_earn_1.map(item => item.avg_total_score || 0), // เพิ่มค่าป้องกัน undefined
        backgroundColor: '#8dc4ff',
        datalabels: {
          color: function(context) {
            const value = context.dataset.data[context.dataIndex]; // ค่าของตัวเลขในแต่ละแท่ง
            const category = context.dataset.label;
            return getColorByCategory(value, category);
          },
          font: {
            family: "'Prompt', sans-serif",
            size: 14,
          },
          formatter: function(value) {
            // ตรวจสอบว่า value เป็นตัวเลข
            const numericValue = Number(value); // แปลงเป็นตัวเลข

            if (isNaN(numericValue)) {
              return '0'; // หากไม่ใช่ตัวเลข แสดง '0'
            }

            // ปรับจำนวนทศนิยมเป็น 1 ตำแหน่ง
            return numericValue.toFixed(1);
          },
          anchor: 'end', // ตำแหน่งของ datalabels
          align: 'top', // การจัดตำแหน่งข้อความ
        }
      }
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      title: {
        display: true,
        color: '#00000',
        font: {
          family: "'Prompt', sans-serif",
          size: 16 // ขนาดตัวหนังสือ
        }
      },
      legend: {
        labels: {
          color: '#00000', // กำหนดสีตัวหนังสือใน legend
          font: {
            family: "'Prompt', sans-serif"
          },
          boxWidth: 20, // ขนาดของ box ใน legend
          boxHeight: 20, // ความสูงของ box
        }
      },
      datalabels: {
        anchor: 'end', // จัดตำแหน่ง data labels
        align: 'top', // การจัดตำแหน่ง
        font: {
          family: "'Prompt', sans-serif",
          size: 14,
        }
      }
    },
    scales: {
        x: {
            title: {
                display: true,  // ✅ เปิดให้แสดงข้อความที่แกน X
                text: 'รายได้ของครอบครัว', // 🔹 กำหนดข้อความหมายเหตุที่แกน X
                color: '#000000', // สีของข้อความ
                font: {
                    family: "'Prompt', sans-serif",
                    size: 14, // ขนาดตัวอักษร
                    weight: 'bold' // ตัวหนา
                }
            },
        ticks: {
            color: '#00000', // กำหนดสีตัวอักษรในแกน X
            font: {
                family: "'Prompt', sans-serif"
            }
        },grid: {
            display: false
            },// ✅ ซ่อนเส้น Grid Line แกน X
        },
        y: {
            title: {
                display: true,  // ✅ เปิดให้แสดงข้อความที่แกน X
                text: 'คะแนนพลังสุขภาพจิต', // 🔹 กำหนดข้อความหมายเหตุที่แกน X
                color: '#000000', // สีของข้อความ
                font: {
                    family: "'Prompt', sans-serif",
                    size: 14, // ขนาดตัวอักษร
                    weight: 'bold' // ตัวหนา
                }
            },
        ticks: {
            color: '#00000' // กำหนดสีตัวอักษรในแกน Y
        },grid: {
            display: false
        },// ✅ ซ่อนเส้น Grid Line แกน X
          suggestedMax: 80 // กำหนดค่า max ที่แนะนำให้แสดงในแกน Y
        }
      }
  },
  plugins: [ChartDataLabels] // ✅ เพิ่ม Plugin datalabels
};

// สร้างกราฟ
const pie_chart11_1 = new Chart(ctx11_1, cfg11_1);