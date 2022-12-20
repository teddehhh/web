<?php
function generate_question_header($questionid, $answertypeid, $typequestionid, $text, $qmedia, $emojicode, $isEdit, $answersarr)
{
    if ($isEdit) :
        $answername = '';
        foreach ($answersarr as $answeritem) :
            if ($answeritem[0] == $answertypeid) :
                $answername = $answeritem[1];
                break;
            endif;
        endforeach; ?>
        <input type="hidden" name="questionsid[]" value="<?php echo $questionid; ?>">
        <input class="question-title-input" type="text" value="<?php echo $text; ?>" name="question-title-input[]">
        <div class="question-answer-type">
            <p><?php echo $answername; ?></p>
        </div>
    <?php
    else : ?>
        <p class="question-title"><?php echo $text; ?></p>
    <?php
    endif; ?>

    <?php
    switch ($typequestionid):
        case INFO_IMG: ?>
            <img class="question-header-media" src="images/questions/<?php echo $qmedia; ?>" alt="">
        <?php
            break;
        case INFO_VIDEO: ?>
            <video class="question-header-media" src="video/questions/<?php echo $qmedia; ?>" controls="controls"></video>
        <?php
            break;
        case INFO_EMOJI: ?>
            <p class="question-header-media">&#<?php echo $emojicode; ?>;</p>
    <?php
            break;
    endswitch;
    return;
};

function generate_answer_content($answerid, $infotypeid, $text, $mediapath, $emojicode, $answers_count, $total_answers_count, $isEdit)
{ ?>
    <div class="answer-container">
        <?php
        switch ($infotypeid):
            case INFO_EMOJI: ?>
                <span>&#<?php echo $emojicode; ?>;</span>
            <?php
                break;
            case INFO_VIDEO: ?>
                <video class="answer-content-media" src="video/answers/<?php echo $mediapath; ?>" controls="controls"></video>
            <?php
                break;
            case INFO_IMG: ?>
                <img class="answer-content-media" src="images/answers/<?php echo $mediapath; ?>" alt="">
                <?php
                break;
            default:
                if ($isEdit) : ?>
                    <input type="hidden" name="answersid[]" value="<?php echo $answerid; ?>">
                    <input class="answer-input" type="text" name="answer-text-input[]" value="<?php echo $text; ?>" autocomplete="off">
                <?php
                else : ?>
                    <label for=""><?php echo $text ?></label>
                <?php
                endif;
                ?>
            <?php
                break;
        endswitch;
        if ($isEdit) : ?>
            <button type="submit" value="<?php echo $answerid; ?>" name="delete-answer" onclick="this.form.submitted=this.value;" value="delete-answer">
                <img class="survey-cmd" src="images/remove-answer.png" alt="">
            </button>
    </div>
<?php
        endif; ?>
<?php
    if ($answers_count != 0 && $total_answers_count != 0) :
        $value = $answers_count / $total_answers_count * 100; ?>
    <label class="percent" for=""><?php echo floor($value * 100) / 100; ?>%</label>
    <?php
    endif;
    return;
};

function generate_question_content($questionid, $answertypeid, $res_answers, $count, $answers, $total_count_answers, $isEdit, $infotypes, $emojiarr)
{
    $disabled = $isEdit ? 'disabled="disabled"' : '';
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
            <textarea <?php echo $disabled; ?> class="input-text" name="<?php echo $count; ?>" placeholder="Введите текст" id="<?php echo $count; ?>" maxlength="255"></textarea>
        <?php
            endif; ?>
        <?php
            break;
        case ANSWER_VIDEO:
            $disabled = $isEdit ? 'disabled="disabled"' : '';
            if ($answers != []) :
                if ($total_count_answers != 0) :
                    foreach ($answers as $video) : ?>
                    <video class="answer-content-media" src="video/user_answers/<?php echo $video; ?>" controls="controls"></video>
                <?php
                    endforeach;
                else : ?>
                <video class="answer-content-media" src="video/user_answers/<?php echo $answers[0]; ?>" controls="controls"></video>
            <?php
                endif; ?>
        <?php
            else : ?>
            <input <?php echo $disabled; ?> class="input-file" type="file" accept="video/*" name="<?php echo $count; ?>" id="<?php echo $count; ?>">
        <?php
            endif; ?>
        <?php
            break;
        case ANSWER_IMG:
            if ($answers != []) :
                if ($total_count_answers != 0) :
                    foreach ($answers as $img) : ?>
                    <img class="answer-content-media" src="images/user_answers/<?php echo $img; ?>" alt="">
                <?php
                    endforeach;
                else : ?>
                <img class="answer-content-media" src="images/user_answers/<?php echo $answers[0]; ?>" alt="">
            <?php
                endif; ?>
        <?php
            else : ?>
            <input <?php echo $disabled; ?> class="input-file" type="file" accept="image/*" name="<?php echo $count; ?>" id="<?php echo $count; ?>">
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
                $emojicode = '';
                if ($answer['emojiid'] != null) :
                    foreach ($emojiarr as $emoji) :
                        if ($emoji[0] == $answer['emojiid']) :
                            $emojicode = $emoji[1];
                            break;
                        endif;
                    endforeach;
                endif;
                $checked = '';
                $disabled = '';
                if ($total_count_answers != 0 && $answers != []) : ?>
                    <li>
                        <?php
                        generate_answer_content($answer['answerid'], $answer['infotypeid'], $answer['text'], $answer['mediapath'], $emojicode, $answers[$count_answer], $total_count_answers, $isEdit); ?>
                    </li>
                <?php
                    $count_answer++;
                    continue;
                elseif ($answers != []) :
                    $disabled = 'disabled';
                    if (in_array($answer['answerid'], $answers)) :
                        $checked = 'checked';
                    endif;
                endif; ?>
                <li>
                    <?php
                    if ($isEdit) :
                        $disabled = 'disabled';
                    endif;
                    if ($disabled != '' && $checked != '') : if ($type == 'radio') : ?>
                            <img class="answered-input" src="images/answer-radio.png" alt="">
                        <?php
                        else : ?>
                            <img class="answered-input" src="images/answer-checkbox.png" alt="">
                        <?php
                        endif;

                    else : ?>
                        <input <?php echo $checked; ?> <?php echo $disabled; ?> type="<?php echo $type; ?>" value="<?php echo $answer['answerid']; ?>" name="<?php echo $count . $name_post; ?>">
                    <?php
                    endif;
                    ?>
                    <?php
                    generate_answer_content($answer['answerid'], $answer['infotypeid'], $answer['text'], $answer['mediapath'], $emojicode, 0, 0, $isEdit);
                    ?>
                </li>
            <?php
            endwhile;
            ?>
        </ul>
        <?php
            if ($isEdit) : ?>
            <div class="add-answer-container">
                <div class="answer-data-container">
                    <input class="answer-input" type="text" name="answer-input-<?php echo $questionid; ?>" id="answer-input-<?php echo $questionid; ?>" placeholder="Добавьте ответ" autocomplete="off" value="Ответ">
                    <select name="add-answer-addition-<?php echo $questionid; ?>" onchange="onSelectAddition(<?php echo $questionid; ?>)" id="add-question-addition-<?php echo $questionid; ?>">
                        <?php
                        foreach ($infotypes as $infotype) :
                            $selected = '';
                            $type_name = $infotype[1];
                            if ($infotype[0] == INFO_TEXT) :
                                $selected = "selected='selected'";
                            endif; ?>
                            <option <?php echo $selected; ?> value="<?php echo $infotype[0]; ?>">
                                <?php echo $type_name; ?>
                            </option>
                        <?php
                        endforeach; ?>
                    </select>
                    <input class="question-type-file" type="file" name="answer-type-file-<?php echo $questionid; ?>" id="question-type-file-<?php echo $questionid; ?>">
                    <select class="question-type-emoji" name="answer-type-emoji-<?php echo $questionid; ?>" id="question-type-emoji-<?php echo $questionid; ?>">
                        <?php
                        foreach ($emojiarr as $emoji) : ?>
                            <option value="<?php echo $emoji[0]; ?>">&#<?php echo $emoji[1]; ?>;</option>
                        <?php
                        endforeach; ?>
                    </select>
                </div>
                <button type="submit" value="<?php echo $questionid; ?>" name="add-answer" onclick="this.form.submitted=this.value;" value="add-answer">
                    <img class="survey-cmd" src="images/add-plus.png" alt="">
                </button>
            </div>
<?php
            endif;
            break;
    endswitch;
    return;
};

function generate_question($questionid, $typequestionid, $answertypeid, $qtext, $qmedia, $emojicode, $res_answers, $count, $answers, $total_count_answers, $isEdit, $infotypes, $emojiarr, $answersarr)
{ ?>
<div class="question-card">
    <span class="question-card-num"><?php echo $count; ?></span>
    <div class="question-container">
        <div class="question-header">
            <?php
            generate_question_header($questionid, $answertypeid, $typequestionid, $qtext, $qmedia, $emojicode, $isEdit, $answersarr); ?>
        </div>
        <div class="question-answers">
            <?php
            generate_question_content($questionid, $answertypeid, $res_answers, $count, $answers, $total_count_answers, $isEdit, $infotypes, $emojiarr);
            ?>
        </div>
    </div>
    <?php
    if ($isEdit) : ?>
        <button type="submit" name="delete" value="<?php echo $questionid; ?>" onclick="this.form.submitted=this.value;" value="delete-question">
            <img class="survey-cmd" src="images/delete.png">
        </button>
    <?php
    endif; ?>
</div>
<?php
    return;
};
//getting types of info, emoji and answer
$res_answers = $connection->query('SELECT answertypeid, name FROM answer_type');
$answersarr = array();
while ($row =  $res_answers->fetch_assoc()) :
    array_push($answersarr, [$row['answertypeid'], $row['name']]);
endwhile;

$res_question_types = $connection->query('SELECT infotypeid, name FROM info_type');
$infotypesarr = array();
while ($row = $res_question_types->fetch_assoc()) :
    array_push($infotypesarr, [$row['infotypeid'], $row['name']]);
endwhile;

$res_emoji = $connection->query('SELECT emojiid, code FROM emoji');
$emojiarr = array();
while ($row = $res_emoji->fetch_assoc()) :
    array_push($emojiarr, [$row['emojiid'], $row['code']]);
endwhile;

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
                if ($answers == []) :
                    array_push($answers, 0);
                endif;
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
    generate_question($question[0], $question[1], $question[2], $question[3], $question[4], $question[5], $question[6], $question[7], $answers, $total_count_answers, $EDIT, $infotypesarr, $emojiarr, $answersarr);
endforeach;

if ($EDIT) : ?>
    <div class="question-card">
        <span class="question-card-num">+</span>
        <div class="question-container">
            <div class="question-header">
                <input type="text" placeholder="Введите текст вопроса" name="add-question-title" autocomplete="off" value="Новый вопрос">
            </div>
            <div class="question-answers">
                <ul>
                    <li>
                        <span>Дополнение к вопросу:</span>
                        <select name="add-question-addition" id="add-question-addition" onchange="onSelectAddition(0)">
                            <?php
                            foreach ($infotypesarr as $infotype) :
                                $selected = '';
                                $type_name = $infotype[1];
                                if ($infotype[0] == INFO_TEXT) :
                                    $type_name = 'Без дополнений';
                                    $selected = "selected='selected'";
                                endif; ?>
                                <option <?php echo $selected; ?> value="<?php echo $infotype[0]; ?>">
                                    <?php echo $type_name; ?>
                                </option>
                            <?php
                            endforeach; ?>
                        </select>
                        <input class="question-type-file" type="file" name="question-type-file" id="question-type-file">
                        <select class="question-type-emoji" name="question-type-emoji" id="question-type-emoji">
                            <?php
                            foreach ($emojiarr as $emoji) : ?>
                                <option value="<?php echo $emoji[0]; ?>">&#<?php echo $emoji[1]; ?>;</option>
                            <?php
                            endforeach; ?>
                        </select>
                    </li>
                    <li>
                        <span>Тип ответа:</span>
                        <select name="add-question-answer" id="add-question-answer">
                            <?php
                            foreach ($answersarr as $answeritem) :
                                $selected = '';
                                if ($answeritem[0] == ANSWER_SINGLE) :
                                    $selected = "selected='selected'";
                                endif; ?>
                                <option <?php echo $selected; ?> value="<?php echo $answeritem[0]; ?>">
                                    <?php echo $answeritem[1]; ?>
                                </option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    </li>
                </ul>
            </div>
        </div>
        <button class="question-add-btn" type="submit" name="add-question" onclick="this.form.submitted=this.value;" value="add-question">
            <img class="survey-cmd" src="images/add-plus.png">
        </button>
    </div>
    <div class="buttons-card">
        <a class="cancel-link" href="index.php">Отмена</a>
        <input type="submit" name="save" value="Сохранить" onclick="this.form.submitted=this.name;">
    </div>
<?php
elseif (!isset($_POST[RESULTS_MODE])) : ?>
    <div class="buttons-card">
        <a class="cancel-link" href="index.php">Отмена</a>
        <input type="submit" name="confirm" value="Завершить" onclick="this.form.submitted=this.name;">
    </div>
<?php
endif;
