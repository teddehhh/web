<?php include 'modules/survey/survey-start.php' ?>
<?php include 'modules/survey/survey-getdata.php' ?>
<?php include 'modules/survey/survey-processing.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Опрос</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include "modules/general/header.php"; ?>
    <main>
        <div class="survey-info">
            <?php include 'modules/survey/survey-header.php'; ?>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="datetimestart" value="<?php echo $datetimestart; ?>" />
            <?php include 'modules/survey/questions-generate.php'; ?>
        </form>
    </main>
    <?php include "modules/general/footer.php" ?>
</body>

</html>