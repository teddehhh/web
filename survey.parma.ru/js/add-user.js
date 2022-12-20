function fieldProc(field, status) {
  field.style.backgroundColor = field.type == "date" ? "#fff" : "#181e29";
  if (!field.value) {
    field.style.backgroundColor = "#ff7b7b";
    status.pass = false;
  }
  return;
}

function formValidation() {
  let status = { pass: true };

  let imgpath = document.getElementById("user-img");
  let surname = document.getElementById("surname");
  let name = document.getElementById("name");
  let patronymic = document.getElementById("patronymic");
  let birthday = document.getElementById("birthday");
  let email = document.getElementById("email");
  let username = document.getElementById("username");
  let old_password = document.getElementById("old-password");
  let password = document.getElementById("password");
  let password_check = document.getElementById("password-check");

  if (imgpath != null) fieldProc(imgpath, status);
  fieldProc(surname, status);
  fieldProc(name, status);
  fieldProc(patronymic, status);
  fieldProc(birthday, status);
  fieldProc(email, status);
  if (username != null) fieldProc(username, status);
  if (old_password == null || (old_password != null && old_password.value)) {
    if (password != null) fieldProc(password, status);
    if (password_check != null) fieldProc(password_check, status);
  }

  if (!status.pass) {
    alert("Проверьте выделенные поля или выберите изображение!");
    return false;
  }

  if (password.value != password_check.value) {
    alert("Введены разные пароли!");
    return false;
  }

  return true;
}

function previewImg(event) {
  if (event.target.files.length > 0) {
    let src = URL.createObjectURL(event.target.files[0]);
    let preview = document.getElementById("preview");
    preview.src = src;
  }
}

document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll("input, textarea").forEach(function (e) {
    if (e.type == "file") {
      if (e.filename === "")
        e.filename = window.localStorage.getItem(e.name, e.filename);
    } else if (e.type != "password") {
      if (e.value === "")
        e.value = window.localStorage.getItem(e.name, e.value);
    }
    e.addEventListener("input", function () {
      if (e.type == "file") window.localStorage.setItem(e.name, e.filename);
      else if (e.type != "password")
        window.localStorage.setItem(e.name, e.value);
    });
  });
});

window.onload = function () {
  localStorage.clear();
};
