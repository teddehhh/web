<?php
include 'modules/database/conn.php';
session_start();

if (!isset($_SESSION[SESSION_LOGEDID]) || $_SESSION[SESSION_LOGEDID] == FALSE) :
    header('Location: login.php');
    exit();
endif;

//USER
// user info
$stm = $connection->prepare('SELECT surname, user_info.name, patronymic, birthday, email, subdivision.name AS subdivision, user_info.subdivisionid FROM user_info JOIN subdivision ON subdivision.subdivisionID=user_info.subdivisionid WHERE userid=?');
$stm->bind_param("i", $_SESSION[SESSION_USERID]);
$stm->execute();
$stm->bind_result($surname, $name, $patronymic, $birthday, $email, $subdivision, $subdivisionid);
$stm->fetch();
$stm->free_result();

switch ($_SESSION[SESSION_ROLEID]):
    case RL_HR:
        $status = 'Администратор';
        break;
    case RL_MANAGER:
        $status = 'Руководитель подразделения';
        break;
    case RL_EMPLOYEE:
        $status = 'Сотрудник компании';
        break;
endswitch;

//STATTS
$statts = array();
// count surveys
$stm = $connection->prepare('SELECT COUNT(*) FROM user_survey WHERE userid=?');
$stm->bind_param("i", $_SESSION[SESSION_USERID]);
$stm->execute();
$stm->bind_result($count_surveys);
$stm->fetch();
$stm->free_result();
array_push($statts, ['пройденных опросов', $count_surveys]);

// favorite emoji
$stm = $connection->prepare('SELECT answer.MediaPath, COUNT(answer.MediaPath) as count FROM answer JOIN user_answer ON user_answer.AnswerID=answer.AnswerID WHERE answer.InfoTypeID=? AND user_answer.UserID=? GROUP BY answer.MediaPath ORDER BY count DESC LIMIT 1');
$typeid = INFO_EMOJI;
$stm->bind_param("ii", $typeid, $_SESSION[SESSION_USERID]);
$stm->execute();
$stm->bind_result($emoji_code, $emoji_count);
$stm->fetch();
$stm->free_result();
$emoji_code = $emoji_code == null ? '-' : $emoji_code;
array_push($statts, ['часто используемый смайлик', $emoji_code]);

// avg time
$stm = $connection->prepare('SELECT AVG(TIMESTAMPDIFF(SECOND, DateTimeStart, DateTimeEnd)) AS AVG FROM user_survey WHERE UserID=?');
$stm->bind_param("i", $_SESSION[SESSION_USERID]);
$stm->execute();
$stm->bind_result($avg_sec);
$stm->fetch();
$stm->free_result();
$min = intdiv($avg_sec, 60);
$sec = $avg_sec % 60;
array_push($statts, ['среднее время прохождения опроса', $avg_sec]);
if ($_SESSION[SESSION_ROLEID] != RL_EMPLOYEE) :
    // employees count
    $stm = $connection->prepare('WITH added_row_num as (SELECT user_info.UserID FROM user_survey JOIN user_info on user_info.UserID=user_survey.UserID WHERE user_info.SubdivisionID=? GROUP BY user_info.UserID) SELECT COUNT(*) as count FROM added_row_num');
    $stm->bind_param("i", $subdivisionid);
    $stm->execute();
    $stm->bind_result($employee_count);
    $stm->fetch();
    $stm->free_result();
    array_push($statts, ['количество активных сотрудников', $employee_count]);

    if ($_SESSION[SESSION_ROLEID] == RL_HR) :
        // the best subdivision
        $res = $connection->query('SELECT subdivision.Name FROM user_survey JOIN user_info ON user_info.UserID=user_survey.UserID JOIN subdivision ON subdivision.SubdivisionID=user_info.SubdivisionID ORDER BY subdivision.SubdivisionID LIMIT 1');
        $row = $res->fetch_object();
        $subdiv_name = !isset($row->Name) ? '-' : $row->Name;
        $res->free_result();
        array_push($statts, ['самое активное подразделение', $subdiv_name]);

        // times of day
        $times = array([0, 6], [6, 12], [12, 18], [18, 24]);
        $times_counts = array();
        $stm = $connection->prepare('SELECT COUNT(*) AS count FROM user_survey WHERE hour(DateTimeEnd) >= ? AND hour(DateTimeEnd) < ?');
        foreach ($times as $time) :
            $stm->bind_param("ii", $time[0], $time[1]);
            $stm->execute();
            $stm->bind_result($count);
            $stm->fetch();
            array_push($times_counts, $count);
            $stm->free_result();
        endforeach;
        $time_of_day = '';
        $max_count = max($times_counts);
        if ($max_count == 0) :
            $time_of_day = '-';
        else :
            switch (max($times_counts)):
                case $times_counts[0]:
                    $time_of_day = 'ночь';
                    break;
                case $times_counts[1]:
                    $time_of_day = 'утро';
                    break;
                case $times_counts[2]:
                    $time_of_day = 'день';
                    break;
                case $times_counts[3]:
                    $time_of_day = 'вечер';
                    break;
            endswitch;
        endif;
        array_push($statts, ['частое время суток прохождения опросов', $time_of_day]);
    endif;
endif;
//HISTORY
// getting history
$stm = $connection->prepare('SELECT survey.surveyid, DATE(DateTimeEnd)AS Date, Title, TIMESTAMPDIFF(SECOND, DateTimeStart, DateTimeEnd) as Time FROM user_survey JOIN survey ON survey.SurveyID=user_survey.SurveyID WHERE user_survey.UserID=? GROUP BY survey.SurveyID');
$stm->execute([$_SESSION[SESSION_USERID]]);
$stm->bind_result($surveyid, $date, $title, $time);
$stm->store_result();
$res_count = $stm->num_rows;
