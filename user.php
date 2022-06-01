<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="css/style.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet"> 
</head>
<body>
    <?php include 'header.php'?>
    <main>
        <div class="user-info">
            <span class="title-info">Персональная информация</span>
            <div class="info-card">
                <img src="/images/push.jpg" alt="">
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
        <div class="stat-info">
            <span class="title-info">Статистика</span>
            <div class="stat-cards">
                <div class="stat-card">
                    <img src="/images/count.png" alt="">
                    <p class="value-stat">14</p>
                    <p class="about-stat">пройденных опросов</p>
                </div>
                <div class="stat-card">
                    <img src="/images/smile.png" alt="">
                    <p class="value-stat">улитка</p>
                    <p class="about-stat">часто используемый смайлик</p>
                </div>
                <div class="stat-card">
                    <img src="/images/clock.png" alt="">
                    <p class="value-stat">4:42</p>
                    <p class="about-stat">среднее время прохождения опроса</p>
                </div>
                <div class="stat-card">
                    <img src="/images/group.png" alt="">
                    <p class="value-stat">рекламное подразделение</p>
                    <p class="about-stat">самое активное подразделение</p>
                </div>
            </div>
        </div>
        <div class="history-info">
            <span class="title-info">История</span>
            <div class="history-card">
                <table>
                    <tr>
                        <th>Дата</th>
                        <th>Название</th>
                        <th>Кол-во вопросов</th>
                        <th>Время</th>
                    </tr>
                    <tr class="row">
                        <td class="date-col">14.02.21</td>
                        <td>Удовлетворенность моральных потребностей</td>
                        <td>5</td>
                        <td class="time-col">5:20</td>
                    </tr>
                    <tr class="row">
                        <td class="date-col">14.02.21</td>
                        <td>Удовлетворенность моральных потребностей</td>
                        <td>5</td>
                        <td class="time-col">5:20</td>
                    </tr>
                    <tr class="row">
                        <td class="date-col">14.02.21</td>
                        <td>Удовлетворенность моральных потребностей</td>
                        <td>5</td>
                        <td class="time-col">5:20</td>
                    </tr>
                </table>
            </div>
        </div>
    </main>
    <?php include 'footer.php'?>
</body>
</html>