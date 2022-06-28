<?php
if (isset($_POST['edit'])) :
    header('Location: survey.php?surveyid=' . $_POST['surveyid'] . '&edit');
elseif (isset($_POST['delete'])) :
    $stm = $connection->prepare('DELETE FROM survey WHERE surveyid=?');
    $stm->execute([$_POST['surveyid']]);
    $stm = $connection->query("DROP EVENT IF EXISTS timeendSurvey_{$_POST['surveyid']}");
    echo "<meta http-equiv='refresh' content='0'>";
elseif (isset($_POST['upload'])) :
    $stm = $connection->prepare('UPDATE survey SET isarchived=FALSE WHERE surveyid=?');
    $stm->execute([$_POST['surveyid']]);
    $stm = $connection->query("CREATE EVENT timeendSurvey_{$_POST['surveyid']} ON SCHEDULE AT '{$_POST['timeend']}' DO UPDATE survey SET isarchived=TRUE WHERE surveyid={$_POST['surveyid']}");

    $stm = $connection->prepare('SELECT title FROM survey WHERE surveyid=?');
    $stm->execute([$_POST['surveyid']]);
    $res = $stm->get_result();
    $row = $res->fetch_assoc();
    $title = $row['title'];
    $stm->free_result();

    $subject = 'Опубликован новый опрос!';
    $message = 'На сайте доступен новый опрос. Тема - ' . $title . '. Срок завершения - ' . date('Y-m-d H:i', strtotime($_POST['timeend']));
    $headers = 'From: Parma.Surveys <the.teddehhh@gmail.com>';
    $res = $connection->query('SELECT email FROM user_info JOIN users ON users.userid=user_info.userid WHERE roleid!=1');
    $to = '';
    while ($row = $res->fetch_assoc()) :
        $to .= $to == '' ? $row['email'] : ',' . $row['email'];
    endwhile;
    if ($to != '') :
        mail($to, $subject, $message, $headers);
    endif;
    echo "<meta http-equiv='refresh' content='0'>";
elseif (isset($_POST['unload'])) :
    $stm = $connection->prepare('UPDATE survey SET isarchived=TRUE WHERE surveyid=?');
    $stm->execute([$_POST['surveyid']]);
    $stm = $connection->query("DROP EVENT IF EXISTS timeendSurvey_{$_POST['surveyid']}");
    echo "<meta http-equiv='refresh' content='0'>";
endif;
