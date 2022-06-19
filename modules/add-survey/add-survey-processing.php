<?php
if (isset($_POST['confirm'])) :
    $stm = $connection->prepare('INSERT INTO survey(title, description, timeend) values(?,?,?)');
    $stm->bind_param("sss", $_POST['title'], $_POST['desc'], $_POST['date']);
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
