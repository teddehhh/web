<?php
include 'modules/database/conn.php';
session_start();

// check user logged in
if (!isset($_SESSION[SESSION_LOGEDID]) || $_SESSION[SESSION_LOGEDID] == FALSE) :
    header('Location: login.php');
    exit();
endif;

$res = $connection->query('SELECT surveyid, title, timeend FROM survey ORDER BY survey.TimeEnd');
