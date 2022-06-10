<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Nowhere Generation</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'modules/db-connection.php'; ?>
    <?php include 'modules/header.php'; ?>
    <main>
        <section class="title-section">
            <?php
            $albumid = $_GET["albumid"];
            $albumq = mysqli_query($connection, "SELECT Title, genre.Name as Genre, studio.Name as Studio, ReleaseDate, albumimage.ImgPath as AlbumImg, artist.Name as Artist, artistimage.ImgPath as ArtistImg, artist.ArtistID as ArtistID
                                                    FROM album
                                                    JOIN genre ON genre.GenreID=album.GenreID
                                                    JOIN studio ON studio.StudioID=album.StudioID
                                                    JOIN albumimage ON albumimage.AlbumID=album.AlbumID
                                                    JOIN albumartist ON albumartist.AlbumID=album.AlbumID
                                                    JOIN artist ON artist.ArtistID=albumartist.ArtistID
                                                    JOIN artistimage ON artistimage.ArtistID=artist.ArtistID
                                                    WHERE album.AlbumID=$albumid AND artistimage.IsMain=TRUE");
            $album = mysqli_fetch_object($albumq); ?>
            <h1><?php echo $album->Title; ?></h1>
            <!-- <div class="search">
                <img src="/images/search-icon.png" alt="">
                <span>Что ищем?</span>
            </div> -->
            <?php include 'modules/logout.php'; ?>
        </section>
        <section class="album">
            <div class="tracks">
                <h2>Треклист альбома:</h2>
                <table class="tl-table">
                    <tr>
                        <th id="th-num">#</th>
                        <th>Название</th>
                        <th>Длина</th>
                    </tr>
                    <?php
                    $tracksq = mysqli_query($connection, "SELECT Title, Num, Length FROM track WHERE AlbumID=$albumid");

                    function time_mask($val)
                    {
                        if ($val < 10) :
                            return "0" . $val;
                        endif;
                        return $val;
                    }

                    function get_time($time)
                    {
                        $min = intdiv($time, 60);
                        $sec = $time % 60;
                        return time_mask($min) . ":" . time_mask($sec);
                    }
                    while ($track = mysqli_fetch_object($tracksq)) : ?>
                        <tr>
                            <td class="tr-num"><?php echo $track->Num; ?></td>
                            <td class="tr-title"><?php echo $track->Title; ?></td>
                            <td class="tr-len"><?php echo get_time($track->Length); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
            <section class="album-info">
                <img src="<?php echo $album->AlbumImg; ?>" alt="">
                <a href="/artist.php?artistid=<?php echo $album->ArtistID; ?>" class="artist-link">
                    <div class="al-data">
                        <img src="<?php echo $album->ArtistImg; ?>" alt="">
                        <span><?php echo $album->Artist; ?></span>
                    </div>
                    <img src="/images/arrow.png" alt="">
                </a>
                <?php if ($isAdmin) : ?>
                    <form action="" method="POST">
                    <?php endif; ?>
                    <table class="ai-table">
                        <caption>Информация об альбоме</caption>
                        <tr>
                            <th>Дата выхода:</th>
                            <td><?php
                                if ($isAdmin) : ?>
                                    <input type="date" name="releasedate" value="<?php echo $album->ReleaseDate ?>">
                                <?php
                                else :
                                    echo $album->ReleaseDate; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Жанр:</th>
                            <td><?php echo $album->Genre; ?></td>
                        </tr>
                        <tr>
                            <th>Студия:</th>
                            <td><?php echo $album->Studio; ?></td>
                        </tr>
                        <tr>
                            <th>Продолжительность:</th>
                            <?php
                            $timeq = mysqli_query($connection, "SELECT SUM(Length) as GeneralLen FROM track WHERE AlbumID=$albumid");
                            $time = mysqli_fetch_object($timeq); ?>
                            <td><?php echo get_time($time->GeneralLen); ?></td>
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
        $releasedate = $_POST["releasedate"];
        $albumid = $_GET["albumid"];
        $updateq = mysqli_query($connection, "UPDATE album SET ReleaseDate='$releasedate' WHERE AlbumID=$albumid");
        echo "<meta http-equiv='refresh' content='0'>";
    endif;
    mysqli_close($connection); ?>
</body>

</html>