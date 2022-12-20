<?php
if (isset($_POST['confirm'])) :
    $stm = $connection->prepare('INSERT INTO survey(title, description, timeend, isarchived) values(?,?,?,?)');
    $desc = $_POST['desc'];
    $isarchived = 1;
    $datetime = $_POST['date'] . ' ' . $_POST['time'];
    $stm->bind_param("sssi", $_POST['title'], $desc, $datetime, $isarchived);
    $stm->execute();
    $stm->free_result();
    $res = $connection->query('SELECT LAST_INSERT_ID() as id');
    $row = $res->fetch_assoc();
    $id = $row['id'];
    $stm->free_result();
    header('Location: survey.php?surveyid=' . $id . '&edit');
elseif (isset($_POST['cancel'])) :
    header('Location: index.php');
endif;
