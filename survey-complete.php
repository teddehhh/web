<?php include 'modules/database/conn.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Опрос завершен</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'modules/general/header.php' ?>
    <main>
        <div class="survey-info">
            <h1>Вы молодец!</h1>
            <div class="survey-about">
                <p>Ваш ответ записан.</p>
            </div>
        </div>
    </main>
    <?php include 'modules/general/footer.php' ?>
</body>

</html>