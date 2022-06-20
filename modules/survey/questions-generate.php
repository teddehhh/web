<?php
function generate_question_header($typequestionid, $text, $qmedia)
{ ?>
    <p class="question-title"><?php echo $text; ?></p>
    <?php
    switch ($typequestionid):
        case INFO_IMG: ?>
            <img class="question-header-media" src="<?php echo $qmedia; ?>" alt="">
        <?php
            break;
        case INFO_VIDEO: ?>
            <video class="question-header-media" src="<?php echo $qmedia; ?>" controls="controls"></video>
        <?php
            break;
        case INFO_EMOJI: ?>
            <p class="question-header-media"><?php echo $qmedia; ?>;</p>
    <?php
            break;
    endswitch;
    return;
};

function generate_answer_content($infotypeid, $text, $mediapath, $answers_count, $total_answers_count)
{ ?>
    <?php
    switch ($infotypeid):
        case INFO_EMOJI: ?>
            <span><?php echo $mediapath; ?>;</span>
        <?php
            break;
        case INFO_VIDEO: ?>
            <video class="answer-content-media" src="<?php echo $mediapath; ?>" controls="controls"></video>
        <?php
            break;
        case INFO_IMG: ?>
            <img class="answer-content-media" src="<?php echo $mediapath; ?>" alt="">
        <?php
            break;
        default:
        ?> <label for=""><?php echo $text ?></label>
    <?php
            break;
    endswitch; ?>
    <?php
    if ($answers_count != 0 && $total_answers_count != 0) :
        $value = $answers_count / $total_answers_count * 100; ?>
        <label class="percent" for=""><?php echo floor($value * 100) / 100; ?>%</label>
        <?php
    endif;
    return;
};

function generate_question_content($answertypeid, $res_answers, $count, $answers, $total_count_answers, $isEdit)
{
    switch ($answertypeid):
        case ANSWER_TEXT:
            if ($answers != []) :
                if ($total_count_answers != 0) :
                    foreach ($answers as $text) : ?>
                        <p class="answer-content-text"><?php echo $text; ?></p>
                    <?php
                    endforeach;
                else : ?>
                    <p class="answer-content-text"><?php echo $answers[0]; ?></p>
                <?php
                endif; ?>
            <?php
            else : ?>
                <textarea class="input-text" name="<?php echo $count; ?>" placeholder="Введите текст" id="<?php echo $count; ?>" maxlength="255"></textarea>
            <?php
            endif; ?>
            <?php
            break;
        case ANSWER_VIDEO:
            if ($answers != []) :
                if ($total_count_answers != 0) :
                    foreach ($answers as $video) : ?>
                        <video class="answer-content-media" src="test/video/<?php echo $video; ?>" controls="controls"></video>
                    <?php
                    endforeach;
                else : ?>
                    <video class="answer-content-media" src="test/video/<?php echo $answers[0]; ?>" controls="controls"></video>
                <?php
                endif; ?>
            <?php
            else : ?>
                <input class="input-file" type="file" accept="video/*" name="<?php echo $count; ?>" id="<?php echo $count; ?>">
            <?php
            endif; ?>
            <?php
            break;
        case ANSWER_IMG:
            if ($answers != []) :
                if ($total_count_answers != 0) :
                    foreach ($answers as $img) : ?>
                        <img class="answer-content-media" src="test/img/<?php echo $img; ?>" alt="">
                    <?php
                    endforeach;
                else : ?>
                    <img class="answer-content-media" src="test/img/<?php echo $answers[0]; ?>" alt="">
                <?php
                endif; ?>
            <?php
            else : ?>
                <input class="input-file" type="file" accept="image/*" name="<?php echo $count; ?>" id="<?php echo $count; ?>">
            <?php
            endif; ?>
        <?php
            break;
        default:
            $type = $answertypeid == ANSWER_SINGLE ? 'radio' : 'checkbox';
            $name_post = $answertypeid == ANSWER_SINGLE ? '' : '[]'; ?>
            <ul>
                <?php
                $count_answer = 0;
                while ($answer = $res_answers->fetch_assoc()) :
                    $checked = '';
                    $disabled = '';
                    if ($total_count_answers != 0 && $answers != []) : ?>
                        <li>
                            <?php
                            generate_answer_content($answer['infotypeid'], $answer['text'], $answer['mediapath'], $answers[$count_answer], $total_count_answers); ?>
                        </li>
                    <?php
                        $count_answer++;
                        continue;
                    elseif ($answers != []) :
                        if (in_array($answer['answerid'], $answers)) :
                            $checked = 'checked';
                        endif;
                        $disabled = 'disabled';
                    endif; ?>
                    <li>
                        <?php
                        if ($isEdit) :
                            $disabled = 'disabled';
                        endif;
                        ?>
                        <input <?php echo $checked; ?> <?php echo $disabled; ?> type="<?php echo $type; ?>" value="<?php echo $answer['answerid']; ?>" name="<?php echo $count . $name_post; ?>" id="<?php echo $count; ?>">
                        <?php
                        generate_answer_content($answer['infotypeid'], $answer['text'], $answer['mediapath'], 0, 0);
                        ?>
                    </li>
                <?php
                endwhile;
                ?>
            </ul>
    <?php
            break;
    endswitch;
    return;
};

function generate_question($questionid, $typequestionid, $answertypeid, $qtext, $qmedia, $res_answers, $count, $answers, $total_count_answers, $isEdit)
{ ?>
    <div class="question-card">
        <span class="question-card-num"><?php echo $count; ?></span>
        <div class="question-container">
            <div class="question-header">
                <?php
                generate_question_header($typequestionid, $qtext, $qmedia); ?>
            </div>
            <div class="question-answers">
                <?php
                generate_question_content($answertypeid, $res_answers, $count, $answers, $total_count_answers, $isEdit);
                ?>
            </div>
        </div>
        <?php
        if ($isEdit) : ?>
            <button type="submit" name="delete" value="<?php echo $questionid; ?>">
                <img class="survey-cmd" src="images/delete.png">
            </button>
        <?php
        endif; ?>
    </div>
<?php
    return;
};

// generating questions
foreach ($questions_data as $question) :
    $answers = array();
    $total_count_answers = 0;
    if (isset($_POST[RESULTS_MODE])) :
        switch ($_POST[RESULTS_MODE]):
            case MY_RES:
                $stm = $connection->prepare('SELECT answerid, text, mediapath FROM user_answer WHERE userid=? AND questionid=?');
                $stm->execute([$_SESSION[SESSION_USERID], $question[0]]);
                $res = $stm->get_result();
                $stm->free_result();
                while ($row = $res->fetch_assoc()) :
                    switch ($question[2]):
                        case ANSWER_TEXT:
                            $value = $row['text'];
                            break;
                        case ANSWER_IMG:
                            $value = $row['mediapath'];
                            break;
                        case ANSWER_VIDEO:
                            $value = $row['mediapath'];
                            break;
                        default:
                            $value = $row['answerid'];
                            break;
                    endswitch;
                    array_push($answers, $value);
                endwhile;
                break;
            case RES_SUBDIV:
                switch ($question[2]):
                    case ANSWER_TEXT:
                        $stm = $connection->prepare('SELECT text FROM user_answer JOIN user_info ON user_info.UserID=user_answer.UserID WHERE user_info.SubdivisionID=? AND user_answer.QuestionID=? ORDER BY RAND() LIMIT 3');
                        $stm->execute([$_SESSION[SESSION_SUBDIVID], $question[0]]);
                        $res = $stm->get_result();
                        $stm->free_result();
                        while ($row = $res->fetch_assoc()) :
                            array_push($answers, $row['text']);
                        endwhile;
                        $total_count_answers = 1;
                        break;
                    case ANSWER_IMG:
                        $stm = $connection->prepare('SELECT mediapath FROM user_answer JOIN user_info ON user_info.UserID=user_answer.UserID WHERE user_info.SubdivisionID=? AND user_answer.QuestionID=? ORDER BY RAND() LIMIT 3');
                        $stm->execute([$_SESSION[SESSION_SUBDIVID], $question[0]]);
                        $res = $stm->get_result();
                        $stm->free_result();
                        while ($row = $res->fetch_assoc()) :
                            array_push($answers, $row['mediapath']);
                        endwhile;
                        $total_count_answers = 1;
                        break;
                    case ANSWER_VIDEO:
                        $stm = $connection->prepare('SELECT mediapath FROM user_answer JOIN user_info ON user_info.UserID=user_answer.UserID WHERE user_info.SubdivisionID=? AND user_answer.QuestionID=? ORDER BY RAND() LIMIT 3');
                        $stm->execute([$_SESSION[SESSION_SUBDIVID], $question[0]]);
                        $res = $stm->get_result();
                        $stm->free_result();
                        while ($row = $res->fetch_assoc()) :
                            array_push($answers, $row['mediapath']);
                        endwhile;
                        $total_count_answers = 1;
                        break;
                    default:
                        //general count of answers on survey
                        $stm = $connection->prepare('SELECT COUNT(*) as count FROM user_answer JOIN user_info ON user_info.UserID=user_answer.UserID WHERE user_info.SubdivisionID=? AND user_answer.QuestionID=?');
                        $stm->execute([$_SESSION[SESSION_SUBDIVID], $question[0]]);
                        $res = $stm->get_result();
                        $stm->free_result();
                        $row = $res->fetch_assoc();
                        $total_count_answers = $row['count'];

                        $stm = $connection->prepare('SELECT answerid FROM answer WHERE QuestionID=?');
                        $stm->execute([$question[0]]);
                        $res = $stm->get_result();
                        $stm->free_result();

                        while ($row = $res->fetch_assoc()) :
                            $stm = $connection->prepare('SELECT COUNT(*) as count FROM user_answer JOIN user_info ON user_info.userid=user_answer.userid WHERE user_info.SubdivisionID=? AND answerid=?');
                            $stm->execute([$_SESSION[SESSION_SUBDIVID], $row['answerid']]);
                            $res_ans_count = $stm->get_result();
                            $stm->free_result();
                            $row_ans_users = $res_ans_count->fetch_assoc();
                            array_push($answers, $row_ans_users['count']);
                        endwhile;
                        break;
                endswitch;
                break;
            case RES_COMP:
                switch ($question[2]):
                    case ANSWER_TEXT:
                        $stm = $connection->prepare('SELECT text FROM user_answer JOIN user_info ON user_info.UserID=user_answer.UserID WHERE user_answer.QuestionID=? ORDER BY RAND() LIMIT 3');
                        $stm->execute([$question[0]]);
                        $res = $stm->get_result();
                        $stm->free_result();
                        while ($row = $res->fetch_assoc()) :
                            array_push($answers, $row['text']);
                        endwhile;
                        $total_count_answers = 1;
                        break;
                    case ANSWER_IMG:
                        $stm = $connection->prepare('SELECT mediapath FROM user_answer JOIN user_info ON user_info.UserID=user_answer.UserID WHERE user_answer.QuestionID=? ORDER BY RAND() LIMIT 3');
                        $stm->execute([$question[0]]);
                        $res = $stm->get_result();
                        $stm->free_result();
                        while ($row = $res->fetch_assoc()) :
                            array_push($answers, $row['mediapath']);
                        endwhile;
                        $total_count_answers = 1;
                        break;
                    case ANSWER_VIDEO:
                        $stm = $connection->prepare('SELECT mediapath FROM user_answer JOIN user_info ON user_info.UserID=user_answer.UserID WHERE user_answer.QuestionID=? ORDER BY RAND() LIMIT 3');
                        $stm->execute([$question[0]]);
                        $res = $stm->get_result();
                        $stm->free_result();
                        while ($row = $res->fetch_assoc()) :
                            array_push($answers, $row['mediapath']);
                        endwhile;
                        $total_count_answers = 1;
                        break;
                    default:
                        //general count of answers on survey
                        $stm = $connection->prepare('SELECT COUNT(*) as count FROM user_answer JOIN user_info ON user_info.UserID=user_answer.UserID WHERE user_answer.QuestionID=?');
                        $stm->execute([$question[0]]);
                        $res = $stm->get_result();
                        $stm->free_result();
                        $row = $res->fetch_assoc();
                        $total_count_answers = $row['count'];

                        $stm = $connection->prepare('SELECT answerid FROM answer WHERE QuestionID=?');
                        $stm->execute([$question[0]]);
                        $res = $stm->get_result();
                        $stm->free_result();

                        while ($row = $res->fetch_assoc()) :
                            $stm = $connection->prepare('SELECT COUNT(*) as count FROM user_answer JOIN user_info ON user_info.userid=user_answer.userid WHERE answerid=?');
                            $stm->execute([$row['answerid']]);
                            $res_ans_count = $stm->get_result();
                            $stm->free_result();
                            $row_ans_users = $res_ans_count->fetch_assoc();
                            array_push($answers, $row_ans_users['count']);
                        endwhile;
                        break;
                endswitch;
                break;
        endswitch;
    endif;
    generate_question($question[0], $question[1], $question[2], $question[3], $question[4], $question[5], $question[6], $answers, $total_count_answers, $EDIT);
endforeach;

if ($EDIT) :
    $res_answers = $connection->query('SELECT answertypeid, name FROM answer_type');
    $res_question_types = $connection->query('SELECT infotypeid, name FROM info_type');
?>
    <div class="question-card">
        <span class="question-card-num">+</span>
        <div class="question-container">
            <div class="question-header">
                <input type="text" placeholder="Введите текст вопроса" name="add-question-title">
            </div>
            <div class="question-answers">
                <ul>
                    <li>
                        <span>Дополнение к вопросу:</span>
                        <select name="" id="">
                            <?php
                            while ($row = $res_question_types->fetch_assoc()) :
                                $type_name = $row['infotypeid'] == 1 ? $row['name'] . ' (Без дополнения)' : $row['name']; ?>
                                <option value="<?php echo $row['infotypeid']; ?>">
                                    <?php echo $type_name; ?>
                                </option>
                            <?php
                            endwhile; ?>
                        </select>
                    </li>
                    <li>
                        <span>Тип ответа:</span>
                        <select name="answertype" id="answertype">
                            <?php
                            while ($row = $res_answers->fetch_assoc()) : ?>
                                <option value="<?php echo $row['answertypeid']; ?>">
                                    <?php echo $row['name']; ?>
                                </option>
                            <?php
                            endwhile;
                            ?>
                        </select>
                    </li>
                </ul>
            </div>
        </div>
        <button class="question-add-btn" type="submit" name="add-question">
            <img class="survey-cmd" src="images/add-plus.png">
        </button>
    </div>
    <div class="buttons-card">
        <input type="submit" name="cancel" value="Отмена">
        <input type="submit" name="save" value="Сохранить">
    </div>
<?php
elseif (!isset($_POST[RESULTS_MODE])) : ?>
    <div class="buttons-card">
        <input type="submit" name="cancel" value="Отмена">
        <input type="submit" name="confirm" value="Завершить">
    </div>
<?php
endif;
