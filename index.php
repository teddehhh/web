<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Новости</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <script async src='js/index.js'></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&display=swap" rel="stylesheet"> 
</head>
<body>
    <?php 
        $connection=@mysqli_connect("localhost","muspublic","","music") or die("Соединение не удалось");
    ?>
    <?php include 'header.php';?>
    <main>
        <section class="title-section">
            <h1>Актуальные новости. <span id=date></span></h1>
            <div class="search">
                <img src="/images/search-icon.png" alt="">
                <span>Что ищем?</span>
            </div>
        </section>
        <section class="main-news">
            <h2>Главные события:</h2>
            <div class="cards">
                <?php
                    $newsq=mysqli_query($connection,"SELECT * FROM news WHERE PRIORITY!=0 ORDER BY PRIORITY");
                    while($news=mysqli_fetch_object($newsq)):
                        $albumq=mysqli_query($connection,"SELECT * FROM album WHERE AlbumID=$news->AlbumID");
                        $album=mysqli_fetch_object($albumq);

                        $artistq=mysqli_query($connection,"SELECT * from artist JOIN albumartist ON albumartist.ArtistID=artist.ArtistID WHERE albumartist.AlbumID=$album->AlbumID");
                        $artistObj=mysqli_fetch_object($artistq);

                        $albImgq=mysqli_query($connection,"SELECT ImgPath FROM AlbumImage WHERE AlbumID=$news->AlbumID");
                        $albImgObj=mysqli_fetch_object($albImgq);

                        $artImgq=mysqli_query($connection,"SELECT ImgPath FROM ArtistImage WHERE ArtistID=$artistObj->ArtistID AND IsMain IS TRUE");
                        $artImgObj=mysqli_fetch_object($artImgq);
                        ?>
                        <div class="medium-card">
                            <div class="mc-album">
                                <img src="<?php echo $albImgObj->ImgPath?>" alt="">
                                <a href="/album.php?albumid=<?php echo $album->AlbumID?>" class="mc-title"><?php echo $album->Title?></a>
                            </div>
                            <div class="mc-artist">
                                <img src="<?php echo $artImgObj->ImgPath?>" alt="">
                                <a href="/artist.php?artistid=<?php echo $artistObj->ArtistID?>"><?php echo $artistObj->Name?></a>
                            </div>
                            <p class="mc-description"><?php echo $news->Info?></p>
                        </div>
                <?php endwhile?>
            </div>
        </section>
        <section class="last-news">
            <h2>Из последнего:</h2>
            <div class="ln-cards">
                <?php
                    $lastAlbumsq=mysqli_query($connection,"SELECT AlbumID,Title FROM album ORDER BY AlbumID DESC LIMIT 8");
                    while($lastAlbum=mysqli_fetch_object($lastAlbumsq)):
                        $lastAlbImgq=mysqli_query($connection,"SELECT ImgPath FROM AlbumImage WHERE AlbumID=$lastAlbum->AlbumID");
                        $lastAlbImgObj=mysqli_fetch_object($lastAlbImgq);
                        ?>
                        <div class="little-card">
                            <img src="<?php echo $lastAlbImgObj->ImgPath?>" alt="">
                            <p><?php echo $lastAlbum->Title?></p>
                        </div>
                    <?php endwhile;?>
            </div>
        </section>
    </main>
    <?php include 'footer.php';?>
    <?php mysqli_close($connection)?>
</body>
</html>