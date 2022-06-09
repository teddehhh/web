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
            $artists = mysqli_query($connection, "SELECT artist.ArtistID, Name, ImgPath FROM artist JOIN artistimage ON artistimage.ArtistID=artist.ArtistID WHERE IsMain=TRUE ORDER BY ArtistID DESC");
            while ($artist = mysqli_fetch_object($artists)) : ?>
                <a class="artist-card" href="artist.php?artistid=<?php echo $artist->ArtistID; ?>">
                    <img src="<?php echo $artist->ImgPath; ?>" alt="">
                    <p><?php echo $artist->Name; ?></p>
                </a>
            <?php endwhile; ?>
            <?php
            if ($isAdmin) : ?>
                <div class="medium-card">
                    <span class="add-form-title">Добавление артиста</span>
                    <form class="add-form" method="POST" name="add-artist" enctype="multipart/form-data">
                        <div class="add-field">
                            <label>Имя:</label>
                            <input class="edit-input" type="text" name="name">
                        </div>
                        <div class="add-field">
                            <Label>Страна:</Label>
                            <select name="countryid" id="countryid">
                                <?php
                                $countriesq = mysqli_query($connection, "SELECT * FROM country");
                                while ($countrySelected = mysqli_fetch_object($countriesq)) : ?>
                                    <option value="<?php echo $countrySelected->CountryID ?>">
                                        <?php echo $countrySelected->Name ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="add-field">
                            <Label>Дата рождения:</Label>
                            <input type="date" name="birthday">
                        </div>
                        <div class="add-field">
                            <Label>Фотография:</Label>
                            <input type="file" name="imgname">
                        </div>
                        <div class="add-field">
                            <input name="add-artist" type="submit" value="Добавить">
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
    if (isset($_POST["add-artist"])) :
        $name = $_POST["name"];
        $countryid = $_POST["countryid"];
        $birthday = $_POST["birthday"];
        $imgName = $_FILES["imgname"]["name"];
        $dirPath = "images/artists/";
        $fileName = uniqid();
        $ext = ".jpg";
        $fullname = $dirPath . $fileName . $ext;

        $addartq = mysqli_query($connection, "INSERT INTO artist(Name, Birthday, CountryID) VALUES('$name','$birthday',$countryid)");
        $artistid = mysqli_insert_id($connection);
        move_uploaded_file($_FILES["imgname"]["tmp_name"], $fullname);
        $addimgq = mysqli_query($connection, "INSERT INTO artistimage(ArtistID, ImgPath) VALUES($artistid,'$fullname')");
        echo "<meta http-equiv='refresh' content='0'>";
    endif;
    mysqli_close($connection); ?>
</body>

</html>