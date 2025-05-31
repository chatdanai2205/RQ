const ctx4_1 = document.getElementById('pie_chart4_1').getContext('2d');
const pie_chart4_1 = new Chart(ctx4_1, {
    type: 'pie',
    data: {
        labels: departmentData.map(item => item.department.length > 12 ? item.department.substring(0, 12) + '...' : item.department),
        datasets: [{
            label: 'จำนวน (คน)',
            data: departmentData.map(item => item.count),
            backgroundColor: [
                '#4B0082', '#1E90FF', '#FFCE56', '#FF6384', '#999966', '#FF9F40', '#C9CBCF'
            ],
            borderColor: '#ffffff',
            borderWidth: 2,
            hoverOffset: 10
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    color: '#000',
                    font: { family: "'Arial', sans-serif", size: 14 }
                }
            },
            title: {
                display: true,
                text: 'กราฟที่ 3 : การกระจายตามภาควิชา',
                font: {
                    family: "'Prompt', sans-serif",
                    size: 18
                },
                color: '#000'
            },
            tooltip: {
                enabled: true, // ✅ เปิดให้แสดง Tooltip
                callbacks: {
                    title: function(tooltipItems) {
                        let index = tooltipItems[0].dataIndex;
                        return departmentData[index].department; // แสดงชื่อเต็ม
                    },
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
        }
    },
    plugins: [ChartDataLabels] // ✅ เพิ่ม Plugin datalabels
});