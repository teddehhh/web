function getWeekDay(date){
    let days = ['Понедельник','Вторник','Среда','Четверг','Пятница','Суббота','Воскресенье'];
    let codesMonths = [1,4,4,0,2,5,0,3,6,1,4,6];
    let codeMonth = codesMonths[date.getMonth()-1];
    let codeYear = (6+date.getYear()%100 + Math.floor(date.getYear()%100/4))%7;
    return days[(date.getDate()+codeMonth+codeYear)%7];
}

function getMonth(date){
    let month = date.getMonth() + 1;
    let monthStr = date.toLocaleString('ru', {month:'short'});
    if(month == 5)
    return 'Мая';
    if(month == 8 || month == 3)
        return monthStr+'a';
    return monthStr.replace('ь','я');
}

function getDate(){
    let date = new Date();
    return getWeekDay(date)+', '+ date.getDate() + ' ' + getMonth(date);
}

window.onload = () =>{
    document.all.date.innerText = getDate();
}