<?php include 'modules/results/results-start.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Результаты</title>
    <link rel="stylesheet" href="css/style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'modules/general/header.php' ?>
    <main>
        <h1>Результаты по опросам</h1>
        <div class="results-container">
            <?php include 'modules/results/results-generate.php'; ?>
        </div>
    </main>
    <?php include 'modules/general/footer.php' ?>
</body>

</html>