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
            $albums = mysqli_query($connection, "SELECT album.AlbumID, Title, ImgPath FROM album JOIN albumimage ON albumimage.AlbumID=album.AlbumID ORDER BY ReleaseDate DESC");
            while ($album = mysqli_fetch_object($albums)) : ?>
                <a class="little-card" href="album.php?albumid=<?php echo $album->AlbumID ?>">
                    <img src="<?php echo $album->ImgPath; ?>" alt="">
                    <p><?php echo $album->Title; ?></p>
                </a>
            <?php endwhile; ?>
            <?php
            if ($isAdmin) : ?>
                <div class="medium-card">
                    <span class="add-form-title">Добавление альбома</span>
                    <form class="add-form" method="POST" name="add-album" enctype="multipart/form-data">
                        <div class="add-field">
                            <label>Название:</label>
                            <input class="edit-input" type="text" name="title">
                        </div>
                        <div class="add-field">
                            <Label>Музыкант:</Label>
                            <select name="artistid" id="artistid">
                                <?php
                                $artistq = mysqli_query($connection, "SELECT * FROM artist");
                                while ($artistSelected = mysqli_fetch_object($artistq)) : ?>
                                    <option value="<?php echo $artistSelected->ArtistID ?>">
                                        <?php echo $artistSelected->Name ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="add-field">
                            <Label>Жанр:</Label>
                            <select name="genreid" id="genreid">
                                <?php
                                $genresq = mysqli_query($connection, "SELECT * FROM genre");
                                while ($genreSelected = mysqli_fetch_object($genresq)) : ?>
                                    <option value="<?php echo $genreSelected->GenreID ?>">
                                        <?php echo $genreSelected->Name ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="add-field">
                            <Label>Студия:</Label>
                            <select name="studioid" id="studioid">
                                <?php
                                $studioq = mysqli_query($connection, "SELECT * FROM studio");
                                while ($studioSelected = mysqli_fetch_object($studioq)) : ?>
                                    <option value="<?php echo $studioSelected->StudioID ?>">
                                        <?php echo $studioSelected->Name ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="add-field">
                            <Label>Дата выхода:</Label>
                            <input type="date" name="releasedate">
                        </div>
                        <div class="add-field">
                            <Label>Фотография:</Label>
                            <input type="file" name="img">
                        </div>
                        <div class="add-field">
                            <input name="add-album" type="submit" value="Добавить">
                        </div>
                    </form>
                </div>
            <?php endif; ?>
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
    <?php
    if (isset($_POST["add-album"])) :
        $title = $_POST["title"];
        $releasedate = $_POST["releasedate"];
        $genreid = $_POST["genreid"];
        $studioid = $_POST["studioid"];
        $artistid = $_POST["artistid"];
        $imgName = $_FILES["img"]["name"];
        $dirPath = "images/albums/";
        $fileName = uniqid();
        $ext = ".jpg";
        $fullname = $dirPath . $fileName . $ext;

        $addalbq = mysqli_query($connection, "INSERT INTO album(Title, ReleaseDate, GenreID, StudioID) VALUES('$title','$releasedate',$genreid,$studioid)");
        $albumid = mysqli_insert_id($connection);
        $albart=mysqli_query($connection,"INSERT INTO albumartist(AlbumID, ArtistID) VALUES($albumid, $artistid)");
        move_uploaded_file($_FILES["img"]["tmp_name"], $fullname);
        $addimgq = mysqli_query($connection, "INSERT INTO albumimage(AlbumID, ImgPath) VALUES($albumid,'$fullname')");
        echo "<meta http-equiv='refresh' content='0'>";
    endif;
    mysqli_close($connection); ?>
</body>

</html>