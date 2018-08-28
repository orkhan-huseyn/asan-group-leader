function clock() {
    var date = new Date();
    var HH = date.getHours();
    var mm = date.getMinutes();
    var ss = date.getSeconds();
    if (HH<10){
        HH = "0"+HH;
    }
    if (ss<10){
        ss = "0"+ss;
    }
    if (mm<10){
        mm = "0"+mm;
    }
    document.getElementById('clock').innerHTML = HH + ":"  + mm + ":" + ss;
}

setInterval(clock, 1000);