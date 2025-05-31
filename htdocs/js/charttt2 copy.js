const ctx2_1 = document.getElementById('pie_chart2_1').getContext('2d');
const pie_chart2_1 = new Chart(ctx2_1, {  
    type: 'doughnut',
    data: {
        labels: Array.isArray(genderData) ? genderData.map(item => item.gender) : [],
        datasets: [{
            label: 'จำนวน (คน)',
            data: Array.isArray(genderData) ? genderData.map(item => Number(item.count) || 0) : [],
            backgroundColor: [
                'rgba(255, 99, 132)',
                'rgba(54, 162, 235)',
                'rgba(75, 192, 192)',
            ],
            borderColor: ['rgba(255, 255, 255, 1)'],
            borderWidth: 3,
            hoverOffset: 20,
            hoverBorderColor: 'rgba(255, 255, 255, 1)',
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    color: '#000000',
                    font: { family: "'Prompt', sans-serif", size: 14 },
                    boxWidth: 20, boxHeight: 20
                }
            },
            title: {
                display: true,
                text: 'กราฟที่ 1 : การกระจายตามเพศ',
                color: '#000000',
                font: { family: "'Prompt', sans-serif", size: 16 },
                padding: 20
            },
            tooltip: {
                callbacks: {
                    label: function (context) {
                        const total = Array.isArray(context.dataset?.data) 
                            ? context.dataset.data.reduce((acc, val) => acc + val, 0) 
                            : 0;

                        const value = Number(context.raw) || 0;
                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : "0.0"; // แสดง 0.0 แทน null
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
        }
    },
    plugins: [ChartDataLabels] // ✅ เพิ่ม Plugin datalabels
});
