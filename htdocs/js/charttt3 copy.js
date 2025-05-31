const ctx3_1 = document.getElementById('pie_chart3_1').getContext('2d');

const pie_chart3_1 = new Chart(ctx3_1, {
    type: 'doughnut',
    data: {
        labels: yearData.map(item => item.year),
        datasets: [{
            label: 'จำนวน (คน)',
            data: yearData.map(item => item.count),
            backgroundColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)',
            ],
            borderColor: [
                'rgba(255, 255, 255, 1)'
            ],
            borderWidth: 3,
            hoverOffset: 20,
            hoverBorderColor: 'rgba(255, 255, 255, 1)',  // เปลี่ยนสี border เมื่อ hover
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // ปิดการคงสัดส่วนเพื่อปรับขนาด
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    color: '#00000', // เปลี่ยนสีตัวหนังสือที่นี่
                    font: {
                        family: "'Prompt', sans-serif",
                        size: 14 // ขนาดตัวหนังสือ
                    },
                    boxWidth: 20, // ขนาดของ box ใน legend
                    boxHeight: 20, // ความสูงของ box
                }
            },
            title: {
                display: true,
                text: 'กราฟที่ 2 : การกระจายตามชั้นปี',
                color: '#00000', // เปลี่ยนสีของชื่อกราฟที่นี่
                font: {
                    family: "'Prompt', sans-serif",
                    size: 16 // ขนาดตัวหนังสือ
                },
            },
            tooltip: {
                callbacks: {
                    // ปรับแต่งข้อความที่แสดงใน tooltip
                    label: function (context) {
                        const total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                        const value = context.raw;
                        const percentage = ((value / total) * 100).toFixed(1);
                        return `${context.label}: ${value} คน (${percentage}%)`; 
                    }
                }
            },
            datalabels: {  // ✅ เพิ่ม datalabels
                anchor: 'center',    // จัดข้อความให้อยู่ตรงกลาง
                align: 'center',     // จัดข้อความในตำแหน่งที่เหมาะสม
                color: '#000',       // สีตัวหนังสือ
                font: {
                    weight: 'bold',
                    size: 14
                },anchor: 'end',
                padding: 5,          // เพิ่มระยะห่างจากกราฟ
                formatter: (value, context) => {
                    const total = Array.isArray(context.dataset?.data) 
                        ? context.dataset.data.reduce((acc, val) => acc + val, 0) 
                        : 0;

                    // ถ้าผลลัพธ์เป็น 0 ก็จะไม่แสดง
                    if (total === 0 || value === 0) {
                        return ''; // ไม่แสดงอะไรถ้าค่าเป็น 0
                    }
                    
                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) + '%' : null;
                    return percentage || ''; // ถ้าเป็น null ก็จะไม่แสดง
                }              
            }
        },
        layout: {
            padding: {
                left: 10,  // ระยะห่างจากขอบซ้าย
                right: 10, // ระยะห่างจากขอบขวา
                top: 10,   // ระยะห่างจากขอบบน
                bottom: 10  // ระยะห่างจากขอบล่าง
            }
        }
    },
    plugins: [ChartDataLabels] // ✅ เพิ่ม Plugin datalabels
});

