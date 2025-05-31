const startBtn = document.querySelector('.recomand-btn')
const popupInfo = document.querySelector('.popup-recomand')
const exitBtn = document.querySelector('.exit-btn')
const container = document.querySelector('.result')
const header = document.querySelector('.header')

startBtn.onclick = () =>{
    popupInfo.classList.add('active');
    container.classList.add('active');
    header.classList.add('active');
}
exitBtn.onclick = () =>{
    popupInfo.classList.remove('active');
    container.classList.remove('active');
    header.classList.remove('active');
}