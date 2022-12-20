function onSelectAddition(questionid) {
  let param = questionid == 0 ? "" : "-" + questionid;
  let selected = document.getElementById("add-question-addition" + param);
  let inputFile = document.getElementById("question-type-file" + param);
  let selectEmoji = document.getElementById("question-type-emoji" + param);
  let answerinput =
    questionid != 0 ? document.getElementById("answer-input" + param) : 0;
  switch (selected.value) {
    case "2":
      inputFile.style.display = "block";
      inputFile.accept = "image/*";
      selectEmoji.style.display = "none";
      if (questionid) answerinput.style.display = "none";
      inputFile.value = "";
      break;
    case "3":
      inputFile.style.display = "inline-block";
      inputFile.accept = "video/*";
      selectEmoji.style.display = "none";
      if (questionid) answerinput.style.display = "none";
      inputFile.value = "";
      break;
    case "4":
      selectEmoji.style.display = "inline-block";
      inputFile.style.display = "none";
      if (questionid) answerinput.style.display = "none";
      break;
    default:
      inputFile.style.display = "none";
      selectEmoji.style.display = "none";
      if (questionid) answerinput.style.display = "inline-block";
      break;
  }
}

function validateForm(isEdit, countQuestions, btn) {
  if (isEdit) {
    if (btn != "save") return true;
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

  let isNotAnswered = false;

  if (countQuestions == 0) isNotAnswered = true;

  for (let i = 1; i <= countQuestions && !isNotAnswered; i++) {
    let answersgroupRadio = document.getElementsByName(i);
    let answersgroupCheckbox = document.getElementsByName(i + "[]");

    let answersgroup =
      answersgroupRadio.length == 0 ? answersgroupCheckbox : answersgroupRadio;

    if (answersgroup.length == 0) {
      isNotAnswered = true;
      break;
    }

    switch (answersgroup[0].type) {
      case "radio":
        let answerExist = false;
        answersgroup.forEach((element) => {
          if (element.checked) {
            answerExist = true;
          }
        });
        isNotAnswered = !answerExist;
        break;
      case "file":
        if (answersgroup[0].filename == "") isNotAnswered = true;
        break;
      case "textarea":
        if (answersgroup[0].value == "") isNotAnswered = true;
        break;
    }
  }

  if (isNotAnswered) {
    alert("Вы ответили не на все вопросы!");
    return false;
  }
  return true;
}
