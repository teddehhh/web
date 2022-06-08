<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Альбомы</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'modules/db-connection.php' ?>
    <?php include 'modules/header.php'; ?>
    <main>
        <section class="title-section">
            <h1>Последние релизы</h1>
            <!-- <div class="search">
                <img src="/images/search-icon.png" alt="">
                <span>Что ищем?</span>
            </div> -->
            <?php include 'modules/logout.php'; ?>
        </section>
        <section class="albums">
            <?php
            $albums = mysqli_query($connection, "SELECT album.AlbumID, Title, ImgPath FROM album JOIN albumimage ON albumimage.AlbumID=album.AlbumID");
            while ($album = mysqli_fetch_object($albums)) : ?>
                <a class="little-card" href="album.php?albumid=<?php echo $album->AlbumID ?>">
                    <img src="<?php echo $album->ImgPath; ?>" alt="">
                    <p><?php echo $album->Title; ?></p>
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