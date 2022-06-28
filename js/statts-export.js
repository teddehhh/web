var data;

window.onload = () => {
  document.body.addEventListener("click", (e) => {});
  var values = document.getElementsByClassName("stat-value");
  var headers = document.getElementsByClassName("stat-about");

  function splitArrays(headers, values) {
    let arr = [];
    for (let i = 0; i < values.length; i++) {
      arr.push([headers[i].outerText, values[i].outerText]);
    }
    return arr;
  }
  data = splitArrays(headers, values);
};

exportToExcel = function () {
  var csvString = "";
    csvString+="Параметр, значение\n";
  data.forEach(function (rowItem, rowIndex) {
    rowItem.forEach(function (colItem, colIndex) {
      csvString += colItem + ",";
    });
      csvString+="\n";
  });

  console.log(decodeURIComponent(csvString));
  var x = document.createElement("a");
  x.setAttribute("href", "data:text/csv; charset=utf-8, " + csvString);
  x.setAttribute("download", "statts.csv");
  document.body.appendChild(x);
  x.click();
};
