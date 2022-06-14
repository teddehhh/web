<?php
include 'modules/database/conn.php';
session_start();

if (!isset($_SESSION[SESSION_LOGEDID]) || $_SESSION[SESSION_LOGEDID] == FALSE) :
    header('Location: login.php');
    exit();
endif;

$stm = $connection->prepare('SELECT surname, user_info.name, patronymic, birthday, email, subdivision.name AS subdivision FROM user_info JOIN subdivision ON subdivision.subdivisionID=user_info.subdivisionid WHERE userid=?');
$stm->bind_param("i", $_SESSION[SESSION_USERID]);
$stm->execute();
$stm->bind_result($surname, $name, $patronymic, $birthday, $email, $subdivision);
$stm->fetch();
$stm->free_result();
