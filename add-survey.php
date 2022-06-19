<?php include 'modules/add-survey/add-survey-start.php'; ?>
<?php include 'modules/add-survey/add-survey-processing.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Добавление опроса</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'modules/general/header.php' ?>
    <main>
        <form method="POST">
            <?php include 'modules/add-survey/survey-content.php' ?>
            <div class="buttons-card">
                <input type="submit" name="cancel" value="Отмена">
                <input type="submit" name="confirm" value="Добавить">
            </div>
        </form>
    </main>
    <?php include 'modules/general/footer.php' ?>
</body>

</html>