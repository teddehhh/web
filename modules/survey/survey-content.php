<?php
include 'modules/database/conn.php';
session_start();

if (!isset($_SESSION[SESSION_LOGEDID]) || $_SESSION[SESSION_LOGEDID] == FALSE) :
    header('Location: login.php');
    exit();
endif;

$stm_ispassed = $connection->prepare('SELECT COUNT(*) AS COUNT FROM user_survey WHERE UserID=? AND SurveyID=?');
$stm_ispassed->bind_param("ii", $_SESSION[SESSION_USERID], $_GET['surveyid']);
$stm_ispassed->execute();
$stm_ispassed->bind_result($ispassed);
$stm_ispassed->fetch();
$stm_ispassed->free_result();

if ($ispassed == TRUE) :
    header('Location: index.php');
    exit();
endif;


$stm_survey = $connection->prepare('SELECT title, description FROM survey WHERE surveyid=?');
$stm_survey->bind_param("i", $_GET['surveyid']);
$stm_survey->execute();
$stm_survey->bind_result($title, $description);
$stm_survey->fetch();
$stm_survey->free_result();

$stm_questions = $connection->prepare('SELECT questionid, infotypeid, answertypeid, text, mediapath FROM question WHERE surveyid=?');
$stm_questions->bind_param("i", $_GET['surveyid']);
$stm_questions->execute();
$res_questions = $stm_questions->get_result();
$stm_questions->free_result();
