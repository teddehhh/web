<?php
// getting general data of survey
$stm = $connection->prepare('SELECT title, description, timeend FROM survey WHERE surveyid=?');
$stm->bind_param("i", $_GET['surveyid']);
$stm->execute();
$stm->bind_result($title, $description, $timeend);
$stm->fetch();
$stm->free_result();

// getting questions info
$stm = $connection->prepare('SELECT questionid, infotypeid, answertypeid, text, mediapath, emojiid FROM question WHERE surveyid=?');
$stm->bind_param("i", $_GET['surveyid']);
$stm->execute();
$res_questions = $stm->get_result();
$stm->free_result();

$questions_count = 0;
$questions_checkbox_count = 0;
$questions_data = array();

// writing questions
while ($row = $res_questions->fetch_assoc()) :
    $stm = $connection->prepare('SELECT answerid, infotypeid, text, mediapath, emojiid FROM answer WHERE questionid=? ORDER BY answerid');
    $stm->bind_param("i", $row['questionid']);
    $stm->execute();
    $res_answers = $stm->get_result();
    $emoji_code = '';

    if ($row['emojiid'] != null) :
        $stm = $connection->prepare('SELECT code FROM emoji WHERE emojiid=?');
        $stm->execute([$row['emojiid']]);
        $res_emoji = $stm->get_result();
        $row_emoji = $res_emoji->fetch_assoc();
        $emoji_code = $row_emoji['code'];
    endif;
    $questions_count++;
    if ($row['answertypeid'] == ANSWER_MULTIPLE) :
        $questions_checkbox_count++;
    endif;
    array_push($questions_data, [$row['questionid'], $row['infotypeid'], $row['answertypeid'], $row['text'], $row['mediapath'], $emoji_code, $res_answers, $questions_count]);
    $stm->free_result();
endwhile;

// saving datetime of tab launch
date_default_timezone_set('Asia/Yekaterinburg');
$datetimestart = date('Y-m-d G:i:s', time());

$mindate = new DateTime();
