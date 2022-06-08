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
    <?php include 'modules/db-connection.php' ?>
    <?php include 'modules/header.php'; ?>
    <main>
        <section class="title-section">
            <h1>Актуальные новости. <span id=date></span></h1>
            <!-- <div class="search">
                <img src="/images/search-icon.png" alt="">
                <span>Что ищем?</span>
            </div> -->
            <?php include 'modules/logout.php'; ?>
        </section>
        <section class="main-news">
            <h2>Главные события:</h2>
            <div class="cards">
                <?php
                $newsq = mysqli_query($connection, "SELECT * FROM news WHERE PRIORITY!=0 ORDER BY PRIORITY");
                while ($news = mysqli_fetch_object($newsq)) :
                    $albumq = mysqli_query($connection, "SELECT * FROM album WHERE AlbumID=$news->AlbumID");
                    $album = mysqli_fetch_object($albumq);

                    $artistq = mysqli_query($connection, "SELECT * from artist JOIN albumartist ON albumartist.ArtistID=artist.ArtistID WHERE albumartist.AlbumID=$album->AlbumID");
                    $artistObj = mysqli_fetch_object($artistq);

                    $albImgq = mysqli_query($connection, "SELECT ImgPath FROM albumimage WHERE AlbumID=$news->AlbumID");
                    $albImgObj = mysqli_fetch_object($albImgq);

                    $artImgq = mysqli_query($connection, "SELECT ImgPath FROM artistimage WHERE ArtistID=$artistObj->ArtistID AND IsMain IS TRUE");
                    $artImgObj = mysqli_fetch_object($artImgq); ?>
                    <div class="medium-card">
                        <div class="mc-album">
                            <img src="<?php echo $albImgObj->ImgPath ?>" alt="">
                            <a href="/album.php?albumid=<?php echo $album->AlbumID ?>" class="mc-title"><?php echo $album->Title ?></a>
                        </div>
                        <div class="mc-artist">
                            <img src="<?php echo $artImgObj->ImgPath ?>" alt="">
                            <a href="/artist.php?artistid=<?php echo $artistObj->ArtistID ?>"><?php echo $artistObj->Name ?></a>
                        </div>
                        <?php
                        if ($isAdmin) : ?>
                            <form action="" method="POST">
                                <input type="hidden" name="formname" value="<?php echo $news->NewsID ?>">
                                <textarea class="edit-field" name="edit-text"><?php echo $news->Info ?></textarea>
                                <div class="news-control">
                                    <button class="save-btn" type="submit" name="save-card">
                                        <img src="/images/save.png" alt="">
                                    </button>
                                    <button class="delete-btn" type="submit" name="delete-card">
                                        <img src="/images/delete.png" alt="">
                                    </button>
                                </div>
                            </form>
                        <?php
                        else : ?>
                            <p class="mc-description"><?php echo $news->Info ?></p>
                        <?php
                        endif; ?>
                    </div>
                <?php
                endwhile;
                if ($isAdmin) : ?>
                    <div class="medium-card">
                        <form class="add-form" action="" method="POST" name="add-news">
                            <Label>Выберите альбом:</Label>
                            <select name="album" id="album">
                                <?php
                                $albumsq = mysqli_query($connection, "SELECT * FROM album");
                                while ($albumSelected = mysqli_fetch_object($albumsq)) : ?>
                                    <option value="<?php echo $albumSelected->AlbumID ?>">
                                        <?php echo $albumSelected->Title ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                            <Label>Введите текст новости:</Label>
                            <textarea class="news-text-add" name="news-text-add" id="news-text"></textarea>
                            <input name="add-news" type="submit" value="Добавить">
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <section class="last-news">
            <h2>Из последнего:</h2>
            <div class="ln-cards">
                <?php
                $lastAlbumsq = mysqli_query($connection, "SELECT AlbumID,Title FROM album ORDER BY AlbumID DESC LIMIT 8");
                while ($lastAlbum = mysqli_fetch_object($lastAlbumsq)) :
                    $lastAlbImgq = mysqli_query($connection, "SELECT ImgPath FROM albumimage WHERE AlbumID=$lastAlbum->AlbumID");
                    $lastAlbImgObj = mysqli_fetch_object($lastAlbImgq); ?>
                    <div class="little-card">
                        <img src="<?php echo $lastAlbImgObj->ImgPath ?>" alt="">
                        <p><?php echo $lastAlbum->Title ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    </main>
    <?php include 'modules/footer.php'; ?>
    <?php
    if (isset($_POST["save-card"])) :
        $info = $_POST["edit-text"];
        $id = intval($_POST["formname"]);
        $updateq = mysqli_query($connection, "UPDATE news SET Info='$info' WHERE NewsID=$id");
        echo "<meta http-equiv='refresh' content='0'>";
    elseif (isset($_POST["delete-card"])) :
        $info = $_POST["edit-text"];
        $id = intval($_POST["formname"]);
        $deleteq = mysqli_query($connection, "DELETE FROM news WHERE NewsID=$id");
        echo "<meta http-equiv='refresh' content='0'>";
    endif;
    if (isset($_POST["add-news"])) :
        $albumid = $_POST["album"];
        $text = $_POST["news-text-add"];
        $priorityq = mysqli_query($connection, "SELECT MAX(PRIORITY) as value FROM news");
        $priorityObj = mysqli_fetch_object($priorityq);
        $maxPriority = $priorityObj->value;
        $addnewsq = mysqli_query($connection, "INSERT INTO news(AlbumID, Info, Priority) VALUES($albumid,'$text',$maxPriority)");
        echo "<meta http-equiv='refresh' content='0'>";
    endif;
    mysqli_close($connection); ?>
</body>

</html>