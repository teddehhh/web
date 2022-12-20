<?php
include 'modules/config.php';
$connection = new mysqli(SERVER, USERNAME, PASSWORD, DATABASE);

if ($connection->connect_errno) :
    exit();
endif;
