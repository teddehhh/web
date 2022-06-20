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

if (isset($_GET['edit'])) :
    $EDIT = TRUE;
else :
    $EDIT = FALSE;
    // check if user already passed the survey
    $stm = $connection->prepare('SELECT COUNT(*) AS COUNT FROM user_survey WHERE UserID=? AND SurveyID=?');
    $stm->bind_param("ii", $_SESSION[SESSION_USERID], $_GET['surveyid']);
    $stm->execute();
    $stm->bind_result($ispassed);
    $stm->fetch();
    $stm->free_result();

    if ($ispassed == TRUE) :
        if (!isset($_POST[RESULTS_MODE])) :
            header('Location: survey-complete.php');
            exit();
        endif;
    endif;
endif;
