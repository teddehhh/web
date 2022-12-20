<?php include 'modules/add-survey/add-survey-start.php'; ?>
<?php include 'modules/add-survey/add-survey-processing.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Создание опроса</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'modules/general/header.php' ?>
    <main>
        <h1>Создание опроса</h1>
        <form method="POST" onsubmit="return validateForm();">
            <?php include 'modules/add-survey/survey-content.php' ?>
            <div class="buttons-card">
                <a class="cancel-link" href="index.php">Отмена</a>
                <input type="submit" name="confirm" value="Создать">
            </div>
        </form>
    </main>
    <?php include 'modules/general/footer.php' ?>
    <script src="js/add-survey.js"></script>
</body>

</html>