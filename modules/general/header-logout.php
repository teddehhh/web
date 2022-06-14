<?php
if (isset($_POST['logout'])) :
    session_start();
    $_SESSION = array();
    header('Location: login.php');
endif;
