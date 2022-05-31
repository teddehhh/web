<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>
    <?php include 'header.php'?>
    <div class="user-info">
        <span>Персональная информация</span>
        <div class="info-card">
            <img src="" alt="">
            <ul>
                <li>
                    <p class="header-info">ФИО</p>
                    <p class="value-info">Александр Сергеевич Пушкин</p>
                </li>
                <li>
                    <p class="header-info">Подразделение</p>
                    <p class="value-info">Поэт</p>
                </li>
                <li>
                    <p class="header-info">Дата рождения</p>
                    <p class="value-info">26.05.1799</p>
                </li>
                <li>
                    <p class="header-info">Почта</p>
                    <input class="value-info input" type="text">
                </li>
            </ul>
        </div>
    </div>
    <div class="stat">
        <span>Статистика</span>
        <div class="container">
            <div class="stat-card">
                <img src="" alt="">
                <p class="value-stat">14</p>
                <p class="about-stat">пройденных опросов</p>
            </div>
            <div class="stat-card">
                <img src="" alt="">
                <p class="value-stat">улитка</p>
                <p class="about-stat">часто используемый смайлик</p>
            </div>
            <div class="stat-card">
                <img src="" alt="">
                <p class="value-stat">4:42</p>
                <p class="about-stat">среднее время прохождения опроса</p>
            </div>
            <div class="stat-card">
                <img src="" alt="">
                <p class="value-stat">рекламное подразделение</p>
                <p class="about-stat">самое активное подразделение</p>
            </div>
        </div>
    </div>
    <div class="history">
        <span>История</span>
        <div class="history-card">
            <table>
                <tr>
                    <th>Дата</th>
                    <th>Название</th>
                    <th>Кол-во опросов</th>
                    <th>Время</th>
                </tr>
                <tr>
                    <td>14.02.21</td>
                    <td>Удовлетворенность моральных потребностей</td>
                    <td>5</td>
                    <td>5:20</td>
                </tr>
                <tr>
                    <td>14.02.21</td>
                    <td>Удовлетворенность моральных потребностей</td>
                    <td>5</td>
                    <td>5:20</td>
                </tr>
                <tr>
                    <td>14.02.21</td>
                    <td>Удовлетворенность моральных потребностей</td>
                    <td>5</td>
                    <td>5:20</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>