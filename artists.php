<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Музыканты</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'modules/db-connection.php' ?>
    <?php include 'modules/header.php'; ?>
    <?php
    if (isset($_POST["logout"])) :
        session_start();
        $_SESSION = array();
        header("Location:login.php");
    endif;
    ?>
    <main>
        <section class="title-section">
            <h1>Музыканты</h1>
            <!-- <div class="search">
                <img src="/images/search-icon.png" alt="">
                <span>Что ищем?</span>
            </div> -->
            <?php include 'modules/logout.php'; ?>
        </section>
        <section class="artists">
            <?php
            $artists = mysqli_query($connection, "SELECT artist.ArtistID, Name, ImgPath FROM artist JOIN artistimage ON artistimage.ArtistID=artist.ArtistID WHERE IsMain=TRUE");
            while ($artist = mysqli_fetch_object($artists)) : ?>
                <a class="artist-card" href="artist.php?artistid=<?php echo $artist->ArtistID; ?>">
                    <img src="<?php echo $artist->ImgPath; ?>" alt="">
                    <p><?php echo $artist->Name; ?></p>
                </a>
            <?php endwhile; ?>
        </section>
        <!-- <section class="pages-bar">
            <a href="#" class="page">1</a>
            <a href="#" class="page">2</a>
            <a href="#" class="page">3</a>
            <a href="#" class="page">4</a>
            <a href="#" class="page">5</a>
            <a href="#" class="page">6</a>
            <a href="#" class="page">7</a>
            <a href="#" class="page">8</a>
        </section> -->
    </main>
    <?php include 'modules/footer.php'; ?>
</body>

</html>