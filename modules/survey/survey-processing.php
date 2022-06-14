<?php
if (isset($_POST['confirm'])) :

    if (count($_POST) + count($_FILES) - 1 == $questions_count) :
        try {
            $null = null;
            $stm_user_answers = $connection->prepare('INSERT INTO user_answer(userid, questionid, answerid,text,mediapath) values(?, ?, ?, ?, ?)');
            for ($i = 1; $i <= $questions_count; $i++) :
                $type_question = $questions_info[$i - 1][1];
                switch ($type_question):
                    case 1:
                        $stm_user_answers->bind_param("iiiii", $_SESSION[SESSION_USERID], $questions_info[$i - 1][0], $_POST[$i], $null, $null);
                        $stm_user_answers->execute();
                        break;
                    case 2:
                        foreach ($_POST[$i] as $answerid) :
                            $stm_user_answers->bind_param("iiiii", $_SESSION[SESSION_USERID], $questions_info[$i - 1][0], $answerid, $null, $null);
                            $stm_user_answers->execute();
                        endforeach;
                        break;
                    case 5:
                        $stm_user_answers->bind_param("iiisi", $_SESSION[SESSION_USERID], $questions_info[$i - 1][0], $null, $_POST[$i], $null);
                        $stm_user_answers->execute();
                        break;
                    default:
                        $stm_user_answers->bind_param("iiiis", $_SESSION[SESSION_USERID], $questions_info[$i - 1][0], $null, $null, $_FILES[$i]['name']);
                        $stm_user_answers->execute();
                        break;
                endswitch;
            endfor;
            $datetimestart = date('Y-m-d G:i:s', time());
            $stm_user_answers->free_result();
            $stm_user_survey = $connection->prepare('INSERT INTO user_survey(userid, surveyid, datetimestart) VALUES(?,?,?)');
            $stm_user_survey->bind_param("iis", $_SESSION[SESSION_USERID], $_GET['surveyid'], $datetimestart);
            $stm_user_survey->execute();
            $stm_user_survey->free_result();
            header('Location: survey-complete.php');
        } catch (Exception $e) {
            echo $e;
        }
    endif;
endif;
