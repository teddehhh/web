<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Artist</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <script async src='js/artist.js'></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'modules/header.php'; ?>
    <?php include 'modules/db-connection.php'; ?>
    <main>
        <section class="title-section">
            <?php
            $artistid = $_GET['artistid'];
            $artistq = mysqli_query($connection, "SELECT * FROM artist WHERE ArtistID=$artistid");
            $artistObj = mysqli_fetch_object($artistq); ?>
            <h1><?php echo $artistObj->Name; ?></h1>
            <!-- <div class="search">
                <img src="images/search-icon.png" alt="">
                <span>Что ищем?</span>
            </div> -->
            <?php include 'modules/logout.php'; ?>
        </section>
        <section class="artist">
            <div class="artist-albums">
                <h2>Альбомы артиста:</h2>
                <div class="albums-cards">
                    <?php
                    $albumsq = mysqli_query($connection, "SELECT album.AlbumID, Title, ImgPath FROM albumartist JOIN album ON albumartist.AlbumID=album.albumID JOIN albumimage on albumimage.AlbumID=album.AlbumID WHERE albumartist.ArtistID=$artistid");
                    while ($album = mysqli_fetch_object($albumsq)) : ?>
                        <a class="little-card" href="album.php?albumid=<?php echo $album->AlbumID ?>" ?>
                            <img src="<?php echo $album->ImgPath ?>" alt="">
                            <p><?php echo $album->Title ?></p>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>
            <section class="artist-info">
                <ul id=collage>
                    <?php
                    $imgsq = mysqli_query($connection, "SELECT ImgPath FROM artistimage WHERE ArtistID=$artistid AND IsMain=TRUE");
                    $mainimg = mysqli_fetch_object($imgsq); ?>
                    <li id=first-img><img src="<?php echo $mainimg->ImgPath ?>" alt=""></li>
                    <?php
                    $artimages = mysqli_query($connection, "SELECT ImgPath FROM artistimage WHERE ArtistID=$artistid AND IsMain=FALSE");
                    while ($img = mysqli_fetch_object($artimages)) : ?>
                        <li class="second-img"><img src="<?php echo $img->ImgPath ?>" alt=""></li>
                    <?php endwhile; ?>
                </ul>
                <?php if ($isAdmin) : ?>
                    <form action="" method="POST">
                    <?php endif; ?>
                    <table class="ai-table">
                        <caption>Информация об артисте</caption>
                        <tr>
                            <?php
                            $countryq = mysqli_query($connection, "SELECT * FROM country WHERE CountryID=$artistObj->CountryID");
                            $countryObj = mysqli_fetch_object($countryq);
                            $genresq = mysqli_query($connection, "SELECT DISTINCT Name FROM genre 
                                                                            JOIN albumartist ON albumartist.ArtistID=$artistObj->ArtistID 
                                                                            JOIN album ON album.AlbumID=albumartist.AlbumID
                                                                            WHERE genre.GenreID=album.GenreID LIMIT 3"); ?>
                            <th>Дата рождения/основания:</th>
                            <td><?php
                                if ($isAdmin) : ?>
                                    <input type="date" name="birthday" value="<?php echo $artistObj->Birthday ?>">
                                <?php
                                else :
                                    echo $artistObj->Birthday ?>
                            </td>
                        <?php endif; ?>
                        </tr>
                        <tr>
                            <th>Страна:</th>
                            <td><?php echo $countryObj->Name ?></td>
                        </tr>
                        <tr>
                            <th>Жанры:</th>
                            <td><?php
                                while ($genre = mysqli_fetch_object($genresq)) : ?>
                                    <?php echo $genre->Name ?>
                                <?php endwhile; ?>
                            </td>
                        </tr>
                    </table>
                    <?php if ($isAdmin) : ?>
                        <button class="save-btn-info" name="save" type="submit">Сохранить</button>
                    </form>
                <?php endif; ?>
            </section>
        </section>
    </main>
    <?php include 'modules/footer.php'; ?>
    <?php if (isset($_POST["save"])) :
        $birthday = $_POST["birthday"];
        $artistid = $_GET["artistid"];
        $updateq = mysqli_query($connection, "UPDATE artist SET Birthday='$birthday' WHERE ArtistID=$artistid");
        echo "<meta http-equiv='refresh' content='0'>";
    endif;
    mysqli_close($connection); ?>
</body>

</html>