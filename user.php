<?php include 'modules/user/user-start.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="css/style.css" />
    <script src="js/statts-export.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'modules/general/header.php' ?>
    <main>
        <div class="user-container">
            <div class="container-header">
                <span class="container-title">Персональная информация</span>
            </div>
            <?php include 'modules/user/user-info-generate.php'; ?>
        </div>
        <div class="stat-container">
            <div class="container-header">
                <span class="container-title">Статистика</span>
                <button onclick="exportToExcel()">
                    <img class="download-stats" src="/images/download.png" alt="">
                </button>
            </div>
            <?php include 'modules/user/stats-generate.php'; ?>
        </div>
        <div class="history-container">
            <div class="container-header">
                <span class="container-title">История</span>
            </div>
            <?php include 'modules/user/history-generate.php'; ?>
        </div>
    </main>
    <?php include 'modules/general/footer.php' ?>
</body>

</html>