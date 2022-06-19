<?php
// getting general data of survey
$stm = $connection->prepare('SELECT title, description, timeend FROM survey WHERE surveyid=?');
$stm->bind_param("i", $_GET['surveyid']);
$stm->execute();
$stm->bind_result($title, $description, $timeend);
$stm->fetch();
$stm->free_result();

// getting questions info
$stm = $connection->prepare('SELECT questionid, infotypeid, answertypeid, text, mediapath FROM question WHERE surveyid=?');
$stm->bind_param("i", $_GET['surveyid']);
$stm->execute();
$res_questions = $stm->get_result();
$stm->free_result();

$questions_count = 0;
$questions_data = array();

// writing questions
while ($row = $res_questions->fetch_assoc()) :
    $questions_count++;
    $stm = $connection->prepare('SELECT answerid, infotypeid, text, mediapath FROM answer WHERE questionid=? ORDER BY answerid');
    $stm->bind_param("i", $row['questionid']);
    $stm->execute();
    $res_answers = $stm->get_result();
    array_push($questions_data, [$row['questionid'], $row['infotypeid'], $row['answertypeid'], $row['text'], $row['mediapath'], $res_answers, $questions_count]);
    $stm->free_result();
endwhile;

// saving datetime of tab launch
date_default_timezone_set('Asia/Yekaterinburg');
$datetimestart = date('Y-m-d G:i:s', time());
