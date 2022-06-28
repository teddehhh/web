<?php include 'modules/users/users-start.php'; ?>
<?php include 'modules/users/users-get-data.php'; ?>
<?php include 'modules/users/users-processing.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Пользователи</title>
    <link rel="stylesheet" href="css/style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'modules/general/header.php' ?>
    <main>
        <h1>Управление пользователями</h1>
        <?php include 'modules/users/add-user-section.php'; ?>
        <div class="results-container">
            <?php include 'modules/users/table-generate.php'; ?>
        </div>
    </main>
    <?php include 'modules/general/footer.php' ?>
</body>

</html>