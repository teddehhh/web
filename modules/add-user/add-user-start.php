<?php
include 'modules/database/conn.php';
session_start();

// check user logged in
if (!isset($_SESSION[SESSION_LOGEDID]) || $_SESSION[SESSION_LOGEDID] == FALSE) :
    header('Location: login.php');
    exit();
endif;

if ($_SESSION[SESSION_ROLEID] != RL_HR) :
    header('Location: index.php');
    exit();
endif;

$EDIT  = isset($_POST['userid']);
