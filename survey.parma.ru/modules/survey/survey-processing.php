<?php
if (isset($_POST['confirm'])) :
    // checking all answers on questions
    // writing all answers in database
    $null = null;
    $stm = $connection->prepare('INSERT INTO user_answer(userid, questionid, answerid, text, mediapath) values(?, ?, ?, ?, ?)');
    for ($i = 1; $i <= $questions_count; $i++) :
        $type_question = $questions_data[$i - 1][2];
        switch ($type_question):
            case ANSWER_SINGLE:
                $stm->bind_param("iiiii", $_SESSION[SESSION_USERID], $questions_data[$i - 1][0], $_POST[$i], $null, $null);
                $stm->execute();
                break;
            case ANSWER_MULTIPLE:
                foreach ($_POST[$i] as $answerid) :
                    $stm->bind_param("iiiii", $_SESSION[SESSION_USERID], $questions_data[$i - 1][0], $answerid, $null, $null);
                    $stm->execute();
                endforeach;
                break;
            case ANSWER_TEXT:
                $stm->bind_param("iiisi", $_SESSION[SESSION_USERID], $questions_data[$i - 1][0], $null, $_POST[$i], $null);
                $stm->execute();
                break;
            case ANSWER_IMG:
                $dir = 'images/user_answers/';
                $fileName = uniqid();
                $ext = ".jpg";
                $fullname = $dir . $fileName . $ext;
                move_uploaded_file($_FILES[$i]["tmp_name"], $fullname);
                $mediapath = $fileName . $ext;
                $stm->bind_param("iiiis", $_SESSION[SESSION_USERID], $questions_data[$i - 1][0], $null, $null, $mediapath);
                $stm->execute();
                break;
            case ANSWER_VIDEO:
                $dir = 'video/user_answers/';
                $fileName = uniqid();
                $ext = ".mp4";
                $fullname = $dir . $fileName . $ext;
                move_uploaded_file($_FILES[$i]["tmp_name"], $fullname);
                $mediapath = $fileName . $ext;
                $stm->bind_param("iiiis", $_SESSION[SESSION_USERID], $questions_data[$i - 1][0], $null, $null, $mediapath);
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
elseif (isset($_POST['save'])) :
    $stm = $connection->prepare('UPDATE survey SET title=?, description=?, timeend=? WHERE surveyid=?');
    $datetime =  $_POST['date'] . ' ' . $_POST['time'];
    $stm->bind_param("sssi", $_POST['title'], $_POST['desc'], $datetime, $_GET['surveyid']);
    $stm->execute();
    $stm->free_result();

    if (isset($_POST['questionsid'])) :
        $stm = $connection->prepare('UPDATE question SET text=? WHERE questionid=?');
        $questionsid = $_POST['questionsid'];
        $questionvalues = $_POST['question-title-input'];
        for ($i = 0; $i < count($questionsid); $i++) :
            $stm->bind_param("si", $questionvalues[$i], $questionsid[$i]);
            $stm->execute();
        endfor;
        $stm->free_result();
    endif;

    if (isset($_POST['answersid'])) :
        $stm = $connection->prepare('UPDATE answer SET text=? WHERE answerid=?');
        $answersid = $_POST['answersid'];
        $answervalues = $_POST['answer-text-input'];
        for ($i = 0; $i < count($answersid); $i++) :
            $stm->bind_param("si", $answervalues[$i], $answersid[$i]);
            $stm->execute();
        endfor;
        $stm->free_result();
    endif;
    header('location: index.php');
elseif (isset($_POST['delete'])) :
    $stm = $connection->prepare('DELETE FROM question WHERE questionid=?');
    $stm->execute([$_POST['delete']]);
    $stm->free_result(); ?>
    <meta http-equiv="refresh" content="1">
<?php
elseif (isset($_POST['add-question'])) :
    $stm = $connection->prepare('INSERT INTO question(surveyid,text,infotypeid,answertypeid,mediapath,emojiid) values(?,?,?,?,?,?)');
    switch ($_POST['add-question-addition']):
        case INFO_IMG:
            $dir = 'images/questions/';
            $fileName = uniqid();
            $ext = ".jpg";
            $fullname = $dir . $fileName . $ext;
            move_uploaded_file($_FILES["question-type-file"]["tmp_name"], $fullname);
            $mediapath = $fileName . $ext;
            $emojiid = null;
            break;
        case INFO_VIDEO:
            $dir = 'video/questions/';
            $fileName = uniqid();
            $ext = ".mp4";
            $fullname = $dir . $fileName . $ext;
            move_uploaded_file($_FILES["question-type-file"]["tmp_name"], $fullname);
            $mediapath = $fileName . $ext;
            $emojiid = null;
            break;
        case INFO_EMOJI:
            $emojiid = $_POST['question-type-emoji'];
            $mediapath = null;
            break;
        default:
            $mediapath = null;
            $emojiid = null;
            break;
    endswitch;
    $stm->bind_param("isiisi", $_GET['surveyid'], $_POST['add-question-title'], $_POST['add-question-addition'], $_POST['add-question-answer'], $mediapath, $emojiid);
    $stm->execute(); ?>
    <meta http-equiv="refresh" content="1">
<?php
elseif (isset($_POST['add-answer'])) :
    $stm = $connection->prepare('INSERT INTO answer(questionid, infotypeid, text, mediapath, emojiid) values(?,?,?,?,?)');
    $textname = 'answer-input-' . $_POST['add-answer'];
    $additionname = 'add-answer-addition-' . $_POST['add-answer'];
    $mediapathname = 'answer-type-file-' . $_POST['add-answer'];
    $emojiname = 'answer-type-emoji-' . $_POST['add-answer'];

    switch ($_POST[$additionname]):
        case INFO_IMG:
            $dir = 'images/answers/';
            $fileName = uniqid();
            $ext = ".jpg";
            $fullname = $dir . $fileName . $ext;
            move_uploaded_file($_FILES[$mediapathname]["tmp_name"], $fullname);
            $mediapath = $fileName . $ext;
            $emojiid = null;
            $text = null;
            break;
        case INFO_VIDEO:
            $dir = 'video/answers/';
            $fileName = uniqid();
            $ext = ".mp4";
            $fullname = $dir . $fileName . $ext;
            move_uploaded_file($_FILES[$mediapathname]["tmp_name"], $fullname);
            $mediapath = $fileName . $ext;
            $emojiid = null;
            $text = null;
            break;
        case INFO_EMOJI:
            $emojiid = $_POST[$emojiname];
            $mediapath = null;
            $text = null;
            break;
        default:
            $mediapath = null;
            $emojiid = null;
            $text = $_POST[$textname];
            break;
    endswitch;
    $stm->bind_param('iissi', $_POST['add-answer'], $_POST[$additionname], $text, $mediapath, $emojiid);
    $stm->execute();
    $stm->free_result();
?>
    <meta http-equiv="refresh" content="1">
<?php
elseif (isset($_POST['delete-answer'])) :
    $stm = $connection->prepare('DELETE FROM answer WHERE answerid=?');
    $stm->execute([$_POST['delete-answer']]); ?>
    <meta http-equiv="refresh" content="1">
<?php
elseif (isset($_POST['cancel'])) :
    header('Location: index.php');
endif;
