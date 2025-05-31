document.querySelectorAll('.likert-btn').forEach(button => {
    button.addEventListener('click', function () {
        const questionName = this.getAttribute('name');
        const value = this.getAttribute('value');
        
        // อัพเดทค่าที่เลือกใน input[type="hidden"] ของคำถามนั้น
        const hiddenInput = document.querySelector(`input[name="${questionName}"]`);
        if (hiddenInput) {
            hiddenInput.value = value;
        }

        // ยกเลิกการเลือกปุ่มอื่นๆ ในแถวเดียวกัน
        const buttonsInRow = this.closest('tr').querySelectorAll('.likert-btn');
        buttonsInRow.forEach(btn => btn.classList.remove('selected')); // ลบคลาส 'selected' จากปุ่มทั้งหมดในแถว

        // ทำให้ปุ่มนี้เป็นที่เลือก
        this.classList.add('selected'); // เพิ่มคลาส 'selected' ให้กับปุ่มที่ถูกคลิก
    });
});
const nextButtons = document.querySelectorAll('.next-btn');

nextButtons.forEach(button => {
    button.addEventListener('click', function () {
        const hiddenInputs = document.querySelectorAll('input[type="hidden"]');
        let allAnswered = true;

        hiddenInputs.forEach(input => {
            if (!input.value) {
                allAnswered = false;
            }
        });

        if (allAnswered) {
            // เอาคำตอบทั้งหมด (เป็นข้อความ) มาเก็บใน array
            const answersText = [];
            document.querySelectorAll('.likert-btn.selected').forEach(btn => {
                answersText.push(btn.textContent.trim());
            });

            // นับความถี่ของแต่ละคำตอบ (ข้อความ)
            const freqText = {};
            answersText.forEach(ans => {
                freqText[ans] = (freqText[ans] || 0) + 1;
            });

            // หาค่าความถี่สูงสุด
            const maxRepeatText = Math.max(...Object.values(freqText));
            const repeatRatioText = maxRepeatText / answersText.length;

            if (repeatRatioText >= 0.8) {
                alert("คุณเลือกคำตอบแบบเดียวกันซ้ำเกิน 80% ระบบจะล้างคำตอบ คุณสามารถเริ่มตอบใหม่ เพื่อให้ระบบสามารถประเมินพลังสุขภาพจิตของคุณได้อย่างมีประสิทธิภาพ");

                // ล้างค่าและ class ปุ่มที่เลือก
                hiddenInputs.forEach(input => input.value = "");
                document.querySelectorAll(".likert-btn").forEach(btn => btn.classList.remove("selected"));

                return;
            }

            // ถ้าไม่พบ pattern ซ้ำ -> ส่งฟอร์ม
            document.getElementById('myForm1').submit();
        } else {
            alert(`กรุณาตอบคำถามให้ครบทุกข้อก่อนกด "ถัดไป"`);
        }
    });
});