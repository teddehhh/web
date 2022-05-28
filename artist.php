<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rise Against</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <script async src='js/artist.js'></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&display=swap" rel="stylesheet"> 
</head>
<body>
    <?php include 'header.php';?>
    <main>
        <section class="title-section">
            <h1>Rise Against</h1>
            <div class="search">
                <img src="images/search-icon.png" alt="">
                <span>Что ищем?</span>
            </div>
        </section>
        <section class="artist">
            <div class="artist-albums">
                <h2>Альбомы артиста:</h2>
                <div class="albums-cards">
                    <div class="little-card">
                        <img src="/images/albums/frtwte.jpg" alt="">
                        <p>For Those That Wish to Exist</p>
                    </div>
                    <div class="little-card">
                        <img src="/images/albums/LMTFNoEternityInGold.jpg" alt="">
                        <p>No Eternity in Gold</p>
                    </div>
                    <a href="/album.php" class="little-card">
                        <img src="/images/albums/ng.jpg" alt="">
                        <p>Nowhere Generation</p>
                    </a>
                </div>
            </div>
            <section class="artist-info">
                <ul id=collage>
                    <li id=first-img><img src="images/artists/rise.jpg" alt=""></li>
                    <li id=second-img><img src="images/artists/rise2.jpg" alt=""></li>
                </ul>
                <table class="ai-table">
                    <caption>Информация об артисте</caption>
                    <tr>
                        <th>Дата рождения/основания:</th>
                        <td>1 декабря, 1999</td>
                    </tr>
                    <tr>
                        <th>Страна:</th>
                        <td>США</td>
                    </tr>
                    <tr>
                        <th>Жанры:</th>
                        <td>Панк-рок; мелодик-хардкор; хардкор-панк</td>
                    </tr>
                    <tr>
                        <th>Состав группы:</th>
                        <td>Тим Макилрот;
                            Джо Принсипи;
                            Брэндон Барнс;
                            Зак Блэр</td>
                    </tr>
                </table>
            </section>
        </section>
    </main>
    <?php include 'footer.php';?>
</body>
</html>