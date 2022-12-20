function validateForm() {
  const addMin = 5;

  let date = document.getElementById("date");
  let time = document.getElementById("time");
  let inputTimestamp = new Date(date.value + " " + time.value);

  let currentTime = new Date();
  currentTime.setTime(currentTime.getTime() + addMin * 60000);

  if (currentTime > inputTimestamp) {
    alert("Укажите позднее время");
    return false;
  }

  return true;
}
