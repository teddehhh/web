<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link rel="stylesheet" href="css/login-style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;600;700&display=swap" rel="stylesheet"> 
</head>
<body>
    <?php
        $connection=@mysqli_connect("localhost","root","pass4422","music") or die("Соединение не удалось!");
    ?>
    <section class="login">
        <h1>Вход для администрирования</h1>
        <section class="logo">
            <img src="/images/logo.png" alt="">
            <span>musculture</span>
        </section>
        <form action="" method="POST">
            <section class="fields">
                <input placeholder="Логин" type="text" name="username">
                <input placeholder="Пароль" type="password" name="password">
            </section>
            <section class="buttons">
                <a class="enter-btn" href="index.php"><span>&#8249;</span>Главная</a>
                <div class="side-buttons">
                    <button class="enter-btn" name="enter" type="submit">Вход</button>
                    <button class="enter-btn" name="reg" type="submit">Регистрация</button>
                </div>
            </section>
        </form>
        <?php
            if(isset($_POST['enter'])){
                if(empty($_POST['username']) or empty($_POST['password'])){
                    ?><span class="fault-msg">Проверьте введенные данные</span><?php
                    exit();
                }
                $username=$_POST['username'];
                $password=$_POST['password'];

                $dataq=mysqli_query($connection,"SELECT Hash, Salt FROM Users WHERE Username='$username'");
                $dataObj=mysqli_fetch_object($dataq);

                if($dataObj==null):
                    ?><span class="fault-msg">Пользователь не найден</span><?php
                    exit();
                endif;
                
                $actual_hash=$dataObj->Hash;
                $actual_salt=$dataObj->Salt;

                $actual_password=$actual_salt.$password;
                $cur_hash=password_hash($actual_password,PASSWORD_DEFAULT);

                if(password_verify($actual_password,$actual_hash)):
                    session_start();
                    $_SESSION["role"]="admin";
                    header("Location:index.php");
                else:
                    ?><span class='fault-msg'>Проверьте данные</span><?php
                endif;}
                elseif (isset($_POST['reg'])){
                if(empty($_POST['username']) or empty($_POST['password'])){
                    ?><span class="fault-msg">Проверьте введенные данные</span><?php
                    exit();
                }
                $username=$_POST['username'];
                $password=$_POST['password'];

                $salt=bin2hex(random_bytes(5));
                $salted_password=$salt.$password;
                $hash=password_hash($salted_password,PASSWORD_DEFAULT);
                
                if ($connection->query("INSERT INTO Users(username,salt,hash) VALUES('$username','$salt','$hash')")===TRUE):
                ?>  <span class="success-msg"><?php echo "Новый пользователь зарегистрирован";?></span>
                <?php
                else:
                ?>  <span class="fault-msg"><?php echo "Ошибка регистрации"?></span>
            <?php endif;
            }?>
    </section>
</body>
</html>