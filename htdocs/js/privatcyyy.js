const startBtn = document.querySelector('.btn1')
const popupInfo = document.querySelector('.popup-info')
const exitBtn = document.querySelector('.exit-btn')
const container = document.querySelector('section')
const header = document.querySelector('.header')
const nav= document.querySelector('#navbar')

startBtn.onclick = () =>{
    popupInfo.classList.add('active');
    container.classList.add('active');
    header.classList.add('active');
    nav.classList.add('hidden'); // ซ่อน navbar
}
exitBtn.onclick = () =>{
    popupInfo.classList.remove('active');
    container.classList.remove('active');
    header.classList.remove('active');
    nav.classList.remove('hidden'); // แสดง navbar กลับมา
}
