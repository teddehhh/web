<?php
include 'modules/database/conn.php';
session_start();

if (!isset($_SESSION[SESSION_LOGEDID]) || $_SESSION[SESSION_LOGEDID] == FALSE) :
    header('Location: login.php');
    exit();
endif;

$stm = $connection->prepare('SELECT name, subdivisionid FROM user_info WHERE userid=?');
$stm->bind_param("i", $_SESSION[SESSION_USERID]);
$stm->execute();
$stm->bind_result($name, $subdivid);
$stm->fetch();
$stm->free_result();
$_SESSION[SESSION_SUBDIVID] = $subdivid;
date_default_timezone_set('Asia/Yekaterinburg');
$hour = date('G', time());
$times = array([0, 6, 'Доброй ночи, '], [6, 12, 'Доброе утро, '], [12, 18, 'Добрый день, '], [18, 24, 'Добрый вечер, ']);
foreach ($times as $time) :
    if ($hour >= $time[0] && $hour < $time[1]) :
        $welcome = $time[2];
        break;
    endif;
endforeach;

if ($_SESSION[SESSTION_ROLEID] == RL_HR) :
    $res = $connection->query('SELECT surveyid, title, description from survey WHERE surveyid AND IsArchived!=TRUE');
else :
    $stm = $connection->prepare('SELECT surveyid, title, description from survey WHERE surveyid NOT IN (SELECT surveyid from user_survey WHERE userid=?) AND isarchived=FALSE');
    $stm->bind_param("i", $_SESSION[SESSION_USERID]);
    $stm->execute();
    $res = $stm->get_result();
    $stm->free_result();
endif;
mysqli_close($connection);
