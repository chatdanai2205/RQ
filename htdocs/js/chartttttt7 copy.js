const fullDepartmentNames = department_1.map(item => item.department); // เก็บชื่อเต็ม
const shortDepartmentNames = department_1.map(item => 
    item.department.length > 12 ? item.department.substring(0, 12) + '...' : item.department
); // เก็บชื่อย่อ

const ctx7_1 = document.getElementById('pie_chart7_1').getContext('2d');

const cfg7_1 = {
  type: 'bar',
  data: {
    labels: shortDepartmentNames, // ใช้ชื่อย่อบนกราฟ
    datasets: [{
        label: 'คะแนนเฉลี่ยรวม',
        data: department_1.map(item => item.avg_total_score),
        backgroundColor: '#8dc4ff',
        datalabels: {
          color: function(context) {
            const value = context.dataset.data[context.dataIndex];
            const category = context.dataset.label;
            return getColorByCategory(value, category);
          },
          font: {
            family: "'Prompt', sans-serif",
            size: 14,
          },
          formatter: function(value) {
            return Number(value).toFixed(1);
          },
          anchor: 'end',
          align: 'right',
        }
      }
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    indexAxis: 'y',
    plugins: {
      title: {
        display: true,
        color: '#00000',
        font: {
          family: "'Prompt', sans-serif",
          size: 16
        }
      },
      legend: {
        labels: {
          color: '#00000',
          font: {
            family: "'Prompt', sans-serif"
          },
          boxWidth: 20,
          boxHeight: 20,
        }
      },
      tooltip: {
        enabled: true,
        callbacks: {
          title: function(tooltipItems) {
            let index = tooltipItems[0].dataIndex;
            return fullDepartmentNames[index]; // ใช้ชื่อเต็มใน Tooltip
          },
          label: function(context) {
            return `คะแนนเฉลี่ย: ${context.raw}`;
          }
        }
      },
      datalabels: {
        anchor: 'end',
        align: 'right',
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
                text: 'คะแนนพลังสุขภาพจิต', // 🔹 กำหนดข้อความหมายเหตุที่แกน X
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
                text: 'ภาควิชา', // 🔹 กำหนดข้อความหมายเหตุที่แกน X
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
const pie_chart7_1 = new Chart(ctx7_1, cfg7_1);
