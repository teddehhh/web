<?php include 'modules/index/index-start.php'; ?>
<?php include 'modules/index/survey-processing.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Главная</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'modules/general/header.php' ?>
    <main>
        <h1>Главная</h1>
        <?php include 'modules/index/welcome-generate.php'; ?>
        <?php include 'modules/index/add-survey-section.php'; ?>
        <div class="surveys-section">
            <?php include 'modules/index/surveys-generate.php'; ?>
        </div>
    </main>
    <?php include 'modules/general/footer.php' ?>
    <script src="js/index.js"></script>
</body>

</html>