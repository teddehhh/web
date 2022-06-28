<?php
if (isset($_POST['register'])) :
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stm = $connection->prepare('SELECT COUNT(*) as count FROM users WHERE username=?');
    $stm->bind_param("s", $_POST['username']);
    $stm->execute();
    $res = $stm->get_result();
    $row = $res->fetch_assoc();
    $count = $row['count'];
    if ($count != 0) : ?>
        <script>
            alert('Указанное имя пользователя занято');
        </script>
    <?php
    else :
        $salt = bin2hex(random_bytes(5));
        $salted_password = $salt . $password;
        $hash = password_hash($salted_password, PASSWORD_DEFAULT);

        $stm = $connection->prepare('INSERT INTO users(username,hash,salt,roleid) values(?,?,?,?)');
        $stm->bind_param("sssi", $_POST['username'], $hash, $salt, $_POST['role']);
        $stm->execute();
        $res = $connection->query('SELECT LAST_INSERT_ID() as id');
        $row = $res->fetch_assoc();
        $id = $row['id'];
        $stm->free_result();

        $dir = 'images/users/';
        $fileName = uniqid();
        $ext = ".jpg";
        $fullname = $dir . $fileName . $ext;
        move_uploaded_file($_FILES["user-img"]["tmp_name"], $fullname);
        $mediapath = $fileName . $ext;

        $stm = $connection->prepare('INSERT INTO user_info(userid,name,surname,patronymic,subdivisionid,birthday,email,imgpath) values(?,?,?,?,?,?,?,?)');
        $stm->bind_param("isssisss", $id, $_POST['name'], $_POST['surname'], $_POST['patronymic'], $_POST['subdiv'], $_POST['birthday'], $_POST['email'], $mediapath);
        $stm->execute();
        $stm->free_result();

        header('location: users.php');
    endif;
elseif (isset($_POST['save'])) :
    $stm = $connection->prepare('SELECT COUNT(*) as count FROM users WHERE username=? AND userid!=?');
    $stm->bind_param("si", $_POST['username'], $_POST['userid']);
    $stm->execute();
    $res = $stm->get_result();
    $row = $res->fetch_assoc();
    $count = $row['count'];
    if ($count != 0) : ?>
        <script>
            alert('Указанное имя пользователя занято');
        </script>
        <?php
    elseif ($_POST['old-password'] != '') :
        $old_password = $_POST['old-password'];

        $stm = $connection->prepare('SELECT hash, salt FROM users WHERE userid=?');
        $stm->execute([$_POST['userid']]);
        $res = $stm->get_result();
        $row = $res->fetch_assoc();

        if (password_verify($row['salt'] . $old_password, $row['hash'])) :
            $password = $_POST['password'];
            $salt = bin2hex(random_bytes(5));
            $salted_password = $salt . $password;
            $hash = password_hash($salted_password, PASSWORD_DEFAULT);

            if (isset($_POST['role'])) :
                $stm = $connection->prepare('UPDATE users SET username=?, roleid=?, hash=?,salt=? WHERE userid=?');
                $stm->bind_param("sissi", $_POST['username'], $_POST['role'], $hash, $salt, $_POST['userid']);
                $stm->execute();

                $stm = $connection->prepare('UPDATE user_info SET surname=?, name=?, patronymic=?,birthday=?,subdivisionid=?,email=? WHERE userid=?');
                $stm->bind_param("ssssisi", $_POST['surname'], $_POST['name'], $_POST['patronymic'], $_POST['birthday'], $_POST['subdiv'], $_POST['email'], $_POST['userid']);
            else :
                $stm = $connection->prepare('UPDATE users SET username=?, hash=?,salt=? WHERE userid=?');
                $stm->bind_param("sssi", $_POST['username'], $hash, $salt, $_POST['userid']);
                $stm->execute();

                $stm = $connection->prepare('UPDATE user_info SET surname=?, name=?, patronymic=?,birthday=?,subdivisionid=?,email=? WHERE userid=?');
                $stm->bind_param("ssssisi", $_POST['surname'], $_POST['name'], $_POST['patronymic'], $_POST['birthday'], $_POST['subdiv'], $_POST['email'], $_POST['userid']);
            endif;

            $stm->execute();
            header('location: users.php');
        else : ?>
            <script>
                alert('Введен неверный старый пароль');
            </script>
<?php
        endif;
    else :
        if (isset($_POST['role'])) :
            $stm = $connection->prepare('UPDATE users SET username=?, roleid=? WHERE userid=?');
            $stm->bind_param("sii", $_POST['username'], $_POST['role'], $_POST['userid']);
            $stm->execute();

            $stm = $connection->prepare('UPDATE user_info SET surname=?, name=?, patronymic=?,birthday=?,subdivisionid=?,email=? WHERE userid=?');
            $stm->bind_param("ssssisi", $_POST['surname'], $_POST['name'], $_POST['patronymic'], $_POST['birthday'], $_POST['subdiv'], $_POST['email'], $_POST['userid']);
        else :
            $stm = $connection->prepare('UPDATE users SET username=? WHERE userid=?');
            $stm->bind_param("si", $_POST['username'], $_POST['userid']);
            $stm->execute();

            $stm = $connection->prepare('UPDATE user_info SET surname=?, name=?, patronymic=?,birthday=?,subdivisionid=?,email=? WHERE userid=?');
            $stm->bind_param("ssssisi", $_POST['surname'], $_POST['name'], $_POST['patronymic'], $_POST['birthday'], $_POST['subdiv'], $_POST['email'], $_POST['userid']);
        endif;

        $stm->execute();
        header('location: users.php');
    endif;
endif;
