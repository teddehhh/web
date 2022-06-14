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

function generate_answer_content($answerid, $infotypeid, $text, $mediapath, $type, $count)
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
    return;
};

function generate_question_content($answertypeid, $res_answers, $count)
{
    switch ($answertypeid):
        case ANSWER_TEXT: ?>
            <textarea class="input-text" name="<?php echo $count; ?>" placeholder="Введите текст" id="<?php echo $count; ?>" maxlength="255"></textarea>
        <?php
            break;
        case ANSWER_VIDEO: ?>
            <input class="input-file" type="file" accept="video/*" name="<?php echo $count; ?>" id="<?php echo $count; ?>">
        <?php
            break;
        case ANSWER_IMG: ?>
            <input class="input-file" type="file" accept="image/*" name="<?php echo $count; ?>" id="<?php echo $count; ?>">
        <?php
            break;
        default:
            $type = $answertypeid == ANSWER_SINGLE ? 'radio' : 'checkbox';
            $name_post = $answertypeid == ANSWER_SINGLE ? '' : '[]'; ?>
            <ul>
                <?php
                while ($answer = $res_answers->fetch_assoc()) : ?>
                    <li>
                        <input type="<?php echo $type; ?>" value="<?php echo $answer['answerid']; ?>" name="<?php echo $count . $name_post; ?>" id="<?php echo $count; ?>">
                        <?php
                        generate_answer_content($answer['answerid'], $answer['infotypeid'], $answer['text'], $answer['mediapath'], $type, $count);
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

function generate_question($typequestionid, $answertypeid, $qtext, $qmedia, $res_answers, $count)
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
                generate_question_content($answertypeid, $res_answers, $count);
                ?>
            </div>
        </div>
    </div>
<?php
    return;
};

$questions_count = 0;
$questions_info = array();

while ($row = $res_questions->fetch_assoc()) :
    $questions_count++;
    $stm_answers = $connection->prepare('SELECT answerid, infotypeid, text, mediapath FROM answer WHERE questionid=?');
    $stm_answers->bind_param("i", $row['questionid']);
    $stm_answers->execute();
    $res_answers = $stm_answers->get_result();
    generate_question($row['infotypeid'], $row['answertypeid'], $row['text'], $row['mediapath'], $res_answers, $questions_count);
    $stm_answers->free_result();
    array_push($questions_info, [$row['questionid'], $row['answertypeid']]);
endwhile;
