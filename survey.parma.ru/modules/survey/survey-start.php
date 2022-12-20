<?php
include 'modules/database/conn.php';
session_start();

// check user logged in
if (!isset($_SESSION[SESSION_LOGEDID]) || $_SESSION[SESSION_LOGEDID] == FALSE) :
    header('Location: login.php');
    exit();
endif;

// check survey existing
if (isset($_GET['surveyid'])) :
    $stm = $connection->prepare('SELECT COUNT(*) AS COUNT FROM survey WHERE surveyid=?');
    $stm->bind_param("i", $_GET['surveyid']);
    $stm->execute();
    $stm->bind_result($isexist);
    $stm->fetch();
    $stm->free_result();
    if (!$isexist) :
        header('Location: index.php');
    endif;
else :
    header('Location: index.php');
endif;

$EDIT = 0;
if (isset($_GET['edit'])) :
    $stm = $connection->prepare('SELECT isarchived FROM survey WHERE surveyid=?');
    $stm->bind_param("i", $_GET['surveyid']);
    $stm->execute();
    $res = $stm->get_result();
    $row = $res->fetch_assoc();
    if (!$row['isarchived']) :
        header('Location: index.php');
        exit();
    endif;
    $EDIT = TRUE;
elseif (!isset($_POST[RESULTS_MODE]) && !isset($_POST['logout'])) :
    $stm = $connection->prepare('SELECT isarchived FROM survey WHERE surveyid=?');
    $stm->bind_param("i", $_GET['surveyid']);
    $stm->execute();
    $res = $stm->get_result();
    $row = $res->fetch_assoc();
    if ($row['isarchived']) :
        header('Location: index.php');
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
        header('Location: survey-complete.php');
        exit();
    endif;
endif;
