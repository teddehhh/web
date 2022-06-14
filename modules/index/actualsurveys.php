<?php
include 'modules/database/conn.php';
session_start();

if (!isset($_SESSION[SESSION_LOGEDID]) || $_SESSION[SESSION_LOGEDID] == FALSE) :
    header('Location: login.php');
    exit();
endif;

$stm = $connection->prepare('SELECT surveyid, title, description from survey WHERE surveyid NOT IN (SELECT surveyid from user_survey WHERE userid=?) AND isarchived=FALSE');
$stm->bind_param("i", $_SESSION[SESSION_USERID]);
$stm->execute();
$res = $stm->get_result();
$stm->free_result();
mysqli_close($connection);
