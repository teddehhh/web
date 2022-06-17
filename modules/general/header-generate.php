<?php
switch ($_SESSION[SESSION_USERID]):
    case RL_HR: ?>
        <a href="index.php" class="navlink">Панель управления</a>
        <a href="users-control.php" class="navlink">Пользователи</a>
    <?php break;
    case RL_MANAGER: ?>
        <a href="index.php" class="navlink">Главная</a>
        <a href="results.php" class="navlink">Результаты</a>
    <?php break;
    default: ?>
        <a href="index.php" class="navlink">Главная</a>
<?php
        break;
endswitch;
?>
<a href="user.php" class="navlink">Личный кабинет</a>
<form method="POST">
    <button class="navlink" type="submit" name="logout">
        <img src="images/logout.png" alt="">
    </button>
</form>