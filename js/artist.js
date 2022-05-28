var opacity = 0;
ChangeOpacity();

function ChangeOpacity(){
    var img = document.getElementById("second-img");
    img.style.opacity = opacity;
    opacity = opacity ? 0 : 1;
    setTimeout(ChangeOpacity, 7000);
}