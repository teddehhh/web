<?php
include 'modules/database/conn.php';
session_start();

// check user logged in
if (!isset($_SESSION[SESSION_LOGEDID]) || $_SESSION[SESSION_LOGEDID] == FALSE) :
    header('Location: login.php');
    exit();
endif;

// check if user already passed the survey
$stm = $connection->prepare('SELECT COUNT(*) AS COUNT FROM user_survey WHERE UserID=? AND SurveyID=?');
$stm->bind_param("ii", $_SESSION[SESSION_USERID], $_GET['surveyid']);
$stm->execute();
$stm->bind_result($ispassed);
$stm->fetch();
$stm->free_result();

if ($ispassed == TRUE) :
    header('Location: index.php');
    exit();
endif;
