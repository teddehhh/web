<?php
if (isset($_POST['logout'])) :
    session_start();
    $_SESSION = array();
    session_destroy();
    header('Location: results.php');
    exit();
endif;