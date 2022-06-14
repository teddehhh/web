<?php include 'modules/user/user_info.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="css/style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'modules/general/header.php' ?>
    <main>
        <div class="user-container">
            <span class="container-title">Персональная информация</span>
            <?php include 'modules/user/info_card.php'; ?>
        </div>
        <div class="stat-container">
            <span class="container-title">Статистика</span>
            <?php include 'modules/user/stat-cards.php'; ?>
            <?php include 'modules/user/stats-generate.php'; ?>
        </div>
        <div class="history-container">
            <span class="container-title">История</span>
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
    </main>
    <?php include 'modules/general/footer.php' ?>
</body>

</html>