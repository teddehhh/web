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
    <?php include 'header.php';?>
    <main>
        <?php
            $connection;
            $isAdmin = false;
            session_start();
            if(isset($_SESSION["role"])){
                $connection=@mysqli_connect("localhost","musadmin1","1","music") or die("Соединение не удалось");
                $isAdmin = true;
            }
            else{
                $connection=@mysqli_connect("localhost","muspublic","","music") or die("Соединение не удалось");
            }
        ?>
        <section class="title-section">
            <?php
                $id=$_GET['artistid'];
                $artistq=mysqli_query($connection,"SELECT * FROM artist WHERE ArtistID=$id");
                $artistObj=mysqli_fetch_object($artistq);
            ?>
            <h1><?php echo $artistObj->Name?></h1>
            <div class="search">
                <img src="images/search-icon.png" alt="">
                <span>Что ищем?</span>
            </div>
        </section>
        <section class="artist">
            <div class="artist-albums">
                <h2>Альбомы артиста:</h2>
                <div class="albums-cards">
                    <?php
                        $albumsq=mysqli_query($connection, "SELECT Title, ImgPath FROM albumartist JOIN Album ON albumartist.AlbumID=album.AlbumID JOIN albumimage on albumimage.AlbumID=album.AlbumID WHERE albumartist.ArtistID=$id");
                        while($album=mysqli_fetch_object($albumsq)):
                            ?>
                            <a class="little-card">
                                <img src="<?php echo $album->ImgPath?>" alt="">
                                <p><?php echo $album->Title?></p>
                            </a>
                        <?php endwhile;?>
                </div>
            </div>
            <section class="artist-info">
                <ul id=collage>
                    <?php
                        $imgsq=mysqli_query($connection, "SELECT ImgPath FROM artistimage WHERE ArtistID=$id AND IsMain=TRUE");
                        $mainimg=mysqli_fetch_object($imgsq);
                        ?>
                        <li id=first-img><img src="<?php echo $mainimg->ImgPath?>" alt=""></li>
                        <?php
                            $artimages=mysqli_query($connection,"SELECT ImgPath FROM artistimage WHERE ArtistID=$id AND IsMain=FALSE");
                            while($img=mysqli_fetch_object($artimages)):
                                ?>
                                <li id=second-img><img src="<?php echo $img->ImgPath?>" alt=""></li>
                            <?php endwhile;?>
                </ul>
                <?php if($isAdmin):
                        ?><form action="" method="POST">
                    <?php endif;?>
                <table class="ai-table">
                    <caption>Информация об артисте</caption>
                    <tr>
                        <?php 
                            $countryq=mysqli_query($connection,"SELECT * FROM Country WHERE CountryID=$artistObj->CountryID");
                            $countryObj=mysqli_fetch_object($countryq);
                            $genresq=mysqli_query($connection,"SELECT DISTINCT Name FROM Genre 
                                                                            JOIN AlbumArtist ON AlbumArtist.ArtistID=$artistObj->ArtistID 
                                                                            JOIN Album ON Album.AlbumID=AlbumArtist.AlbumID
                                                                            WHERE Genre.GenreID=Album.GenreID LIMIT 3");
                            ?>
                        <th>Дата рождения/основания:</th>
                        <td><?php
                                if($isAdmin):?>
                                    <input type="date" name="birthday" value="<?php echo $artistObj->Birthday?>">
                                    <?php
                                else:
                                    echo $artistObj->Birthday?></td>
                            <?php endif;?>
                    </tr>
                    <tr>
                        <th>Страна:</th>
                        <td><?php echo $countryObj->Name?></td>
                    </tr>
                    <tr>
                        <th>Жанры:</th>
                        <td><?php
                                while($genre=mysqli_fetch_object($genresq)):
                                    ?>
                                    <?php echo $genre->Name?>
                                <?php endwhile;?>
                        </td>
                    </tr>
                </table>
                <?php if($isAdmin):?>
                        <button class="save-btn" name="save" type="submit">Сохранить</button>
                        </form>
                <?php endif;?>
            </section>
        </section>
    </main>
    <?php include 'footer.php';?>
    <?php if(isset($_POST["save"])):
                $birthday=$_POST["birthday"];
                $artistid=$_GET["artistid"];
                $updateq=mysqli_query($connection,"UPDATE Artist SET Birthday='$birthday' WHERE ArtistID=$artistid"); 
                echo "<meta http-equiv='refresh' content='0'>";
            endif;
            mysqli_close($connection);?>
</body>
</html>