<?php include 'modules/general/header-logout.php'; ?>

<header>
    <div class="logo">
        <img src="images/logo.png" alt="">
    </div>
    <nav>
        <a href="index.php" class="navlink">Главная</a>
        <a href="user.php" class="navlink">Личный кабинет</a>
        <form method="POST">
            <button class="navlink" type="submit" name="logout">
                <img src="images/logout.png" alt="">
            </button>
        </form>
    </nav>
</header>