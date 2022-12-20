<?php include 'modules/add-user/add-user-start.php'; ?>
<?php include 'modules/add-user/add-user-get-data.php'; ?>
<?php include 'modules/add-user/add-user-processing.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'modules/general/header.php'; ?>
    <main>
        <?php include 'modules/add-user/add-user-title-generate.php'; ?>
        <?php include 'modules/add-user/add-user-generate-form.php'; ?>
    </main>
    <?php include 'modules/general/footer.php'; ?>
    <script src="js/add-user.js"></script>
</body>

</html>