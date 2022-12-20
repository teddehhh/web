function surveyControl(btn, timeend) {
  if (btn != "upload") return true;

  const addMin = 5;

  let surDateTime = new Date(timeend);

  let curDateTime = new Date();
  curDateTime.setTime(curDateTime.getTime() + addMin * 60000);

  if (surDateTime > curDateTime) return true;
  alert("Невозможно опубликовать запрос. Обновите время окончания запроса");
  return false;
}
