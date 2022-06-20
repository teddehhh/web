<?php
if (isset($_POST['confirm'])) :
    // checking all answers on questions
    if (count($_POST) + count($_FILES) - 2 == $questions_count) :
        // writing all answers in database
        $null = null;
        $stm = $connection->prepare('INSERT INTO user_answer(userid, questionid, answerid,text,mediapath) values(?, ?, ?, ?, ?)');
        for ($i = 1; $i <= $questions_count; $i++) :
            $type_question = $questions_data[$i - 1][2];
            switch ($type_question):
                case 1:
                    $stm->bind_param("iiiii", $_SESSION[SESSION_USERID], $questions_data[$i - 1][0], $_POST[$i], $null, $null);
                    $stm->execute();
                    break;
                case 2:
                    foreach ($_POST[$i] as $answerid) :
                        $stm->bind_param("iiiii", $_SESSION[SESSION_USERID], $questions_data[$i - 1][0], $answerid, $null, $null);
                        $stm->execute();
                    endforeach;
                    break;
                case 5:
                    $stm->bind_param("iiisi", $_SESSION[SESSION_USERID], $questions_data[$i - 1][0], $null, $_POST[$i], $null);
                    $stm->execute();
                    break;
                default:
                    $stm->bind_param("iiiis", $_SESSION[SESSION_USERID], $questions_data[$i - 1][0], $null, $null, $_FILES[$i]['name']);
                    $stm->execute();
                    break;
            endswitch;
        endfor;
        $stm->free_result();
        // record that the user has completed the survey
        $stm = $connection->prepare('INSERT INTO user_survey(userid, surveyid, datetimestart) VALUES(?,?,?)');
        $stm->bind_param("iis", $_SESSION[SESSION_USERID], $_GET['surveyid'], $_POST['datetimestart']);
        $stm->execute();
        $stm->free_result();
        header('Location: survey-complete.php');
    endif;
elseif (isset($_POST['save'])) :
    $stm = $connection->prepare('UPDATE survey SET title=?, description=?, timeend=? WHERE surveyid=?');
    $stm->bind_param("sssi", $_POST['title'], $_POST['desc'], $_POST['date'], $_GET['surveyid']);
    $stm->execute();
    $stm->free_result(); ?>
    <meta http-equiv="refresh" content="1">
<?php
elseif (isset($_POST['delete'])) :
    $stm = $connection->prepare('DELETE FROM question WHERE questionid=?');
    $stm->execute([$_POST['delete']]);
    $stm->free_result(); ?>
    <meta http-equiv="refresh" content="1">
<?php
elseif (isset($_POST['add-question'])) :
    $stm = $connection->prepare('INSERT INTO question(title,infotypeid,answertypeid,mediapath) values(?,?,?,?)');
    $stm->bind_param("siii", $_POST['add-question-title'],);

elseif (isset($_POST['cancel'])) :
    header('Location: index.php');
endif;
