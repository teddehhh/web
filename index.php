<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Новости</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <script async src='/js/sIndex.js'></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&display=swap" rel="stylesheet"> 
</head>
<body>
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
                <div class="medium-card">
                    <div class="mc-album">
                        <img src="/images/albums/misser.png" alt="">
                        <p class="mc-title">Misery Sermon</p>
                    </div>
                    <div class="mc-artist">
                        <img src="/images/artists/sltopr.jpg" alt="">
                        <p>Slaughter to Prevail</p>
                    </div>
                    <p class="mc-description">Международный дебют российской дектор-команды.</p>
                </div>
                <div class="medium-card">
                    <div class="mc-album">
                        <img src="/images/albums/hfk.png" alt="">
                        <p class="mc-title">Hopeless Fountain Kingdom</p>
                    </div>
                    <div class="mc-artist">
                        <img src="/images/artists/halsey.jpg" alt="">
                        <p>Halsey</p>
                    </div>
                    <p class="mc-description">Стремительное взросление вчерашней тинейджер-звезды продолжается на ее втором релизе «Hopeless Fountain Kingdom».</p>
                </div>
                <div class="medium-card">
                    <div class="mc-album">
                        <img src="/images/albums/ng.jpg" alt="">
                        <a href="/album.php">Nowhere Generation</a>
                    </div>
                    <div class="mc-artist">
                        <img src="/images/artists/rise.jpg" alt="">
                        <a href="/artist.php">Rise Against</a>
                    </div>
                    <p class="mc-description">Прошло двадцать лет, а их революционный огонь все так же актуален и так же печально необходим, как и прежде.</p>
                </div>
                <div class="medium-card">
                    <div class="mc-album">
                        <img src="/images/albums/trinme.jpg" alt="">
                        <p class="mc-title">Trust in Me</p>
                    </div>
                    <div class="mc-artist">
                        <img src="/images/artists/Direct_2019.jpg" alt="">
                        <p>Direct</p>
                    </div>
                    <p class="mc-description">Trust In Me - это альбом в стиле “chillout” от Direct, Mr FijiWiji and Holly Drummond.</p>
                </div>
            </div>
        </section>
        <section class="last-news">
            <h2>Из последнего:</h2>
            <div class="ln-cards">
                <div class="little-card">
                    <img src="/images/albums/frtwte.jpg" alt="">
                    <p>For Those That Wish to Exist</p>
                </div>
                <div class="little-card">
                    <img src="/images/albums/LMTFNoEternityInGold.jpg" alt="">
                    <p>No Eternity in Gold</p>
                </div>
                <div class="little-card">
                    <img src="/images/albums/mcin5.jpg" alt="">
                    <p>Monstercat Instinct Vol.5</p>
                </div>
                <div class="little-card">
                    <img src="/images/albums/that'sspirit.jpg" alt="">
                    <p>That's Spirit</p>
                </div>
                <div class="little-card">
                    <img src="/images/albums/noise.jpg" alt="">
                    <p>N / O / I / S / E</p>
                </div>
                <div class="little-card">
                    <img src="/images/albums/hosh.jpg" alt="">
                    <p>Хошхоног</p>
                </div>
                <div class="little-card">
                    <img src="/images/albums/wind.jpg" alt="">
                    <p>Круг Ветров</p>
                </div>
                <div class="little-card">
                    <img src="/images/albums/wild-youth.jpg" alt="">
                    <p>Wild Youth</p>
                </div>
            </div>
        </section>
    </main>
    <?php include 'footer.php';?>
</body>
</html>