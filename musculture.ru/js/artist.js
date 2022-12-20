var opacity = 0;
ChangeOpacity();

function ChangeOpacity() {
  var img = document.getElementsByClassName("second-img");
  if (img == null) return;
  img[0].style.opacity = opacity;
  opacity = opacity ? 0 : 1;
  setTimeout(ChangeOpacity, 7000);
}
