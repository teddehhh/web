<?php
include 'modules/database/conn.php';

session_start();
$_SESSION[SESSION_LOGEDID] = FALSE;

if (isset($_POST['signin'])) :
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stm = $connection->prepare('SELECT userid, hash, salt, roleid FROM users WHERE username=?');
    $stm->bind_param("s", $username);
    $stm->execute();
    $stm->bind_result($userid, $hash, $salt, $roleid);
    $stm->fetch();

    if ($hash == null) :
        $_SESSION[SESSION_ERROR] = UNKNOWN_USER;
    else :
        if (password_verify($salt . $password, $hash)) :
            $_SESSION[SESSION_USERID] = $userid;
            $_SESSION[SESSION_ROLEID] = $roleid;
            $_SESSION[SESSION_LOGEDID] = TRUE;
            header('Location: index.php');
        else :
            $_SESSION[SESSION_ERROR] = WRONG_USER_OR_PASS;
        endif;
    endif;
endif;
