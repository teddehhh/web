<table>
    <tr>
        <th>Название</th>
        <th>Статус подразделения</th>
        <th>Результаты</th>
        <th>Доступен до</th>
    </tr>
    <?php
    $stm_emp_count = $connection->prepare('SELECT COUNT(*) as count FROM user_info WHERE subdivisionid=?');
    $stm_emp_count->execute([$_SESSION[SESSION_SUBDIVID]]);
    $stm_emp_count->bind_result($general_subdiv_count);
    $stm_emp_count->fetch();
    $stm_emp_count->free_result();

    $count = 0;
    while ($row = $res->fetch_assoc()) :
        $stm_emp_count = $connection->prepare('SELECT COUNT(*) as count FROM user_survey JOIN user_info ON user_info.userid=user_survey.userid WHERE user_info.subdivisionid=? AND user_survey.surveyid=?');
        $stm_emp_count->execute([$_SESSION[SESSION_SUBDIVID], $row['surveyid']]);
        $stm_emp_count->bind_result($subdiv_count);
        $stm_emp_count->fetch();
        $stm_emp_count->free_result();

        $stm_emp_count = $connection->prepare('SELECT COUNT(*) as count FROM user_survey JOIN user_info ON user_info.userid=user_survey.userid AND user_survey.surveyid=?');
        $stm_emp_count->execute([$row['surveyid']]);
        $stm_emp_count->bind_result($general_count);
        $stm_emp_count->fetch();
        $stm_emp_count->free_result(); ?>
        <tr>
            <td class="tb-title"><?php echo $row['title']; ?></td>
            <td class='tb-status'>
                <?php
                $path = '';
                if ($subdiv_count == $general_subdiv_count) :
                    $path = 'images/done-status.png';
                elseif ($subdiv_count < $general_subdiv_count && $subdiv_count != 0) :
                    $path = 'images/warning-status.png';
                else :
                    $path = 'images/bad-status.png';
                endif;
                ?>
                <img class="survey-status" src="<?php echo $path; ?>" alt="" title="<?php echo "Прошло {$subdiv_count}/{$general_subdiv_count}"; ?>">
            </td>
            <td>
                <?php
                if ($subdiv_count == 0 && $general_count == 0) : ?>
                    <span>----</span>
                <?php
                elseif ($subdiv_count > 0) :
                ?>
                    <form method="POST" action="survey.php?surveyid=<?php echo $row['surveyid']; ?>">
                        <input type="hidden" name="<?php echo RESULTS_MODE; ?>" value="<?php echo RES_SUBDIV; ?>">
                        <input class="history-btn-survey" type="submit" value="Подразделение">
                    </form>
                <?php
                endif;
                if ($general_count > 0) : ?>
                    <form method="POST" action="survey.php?surveyid=<?php echo $row['surveyid']; ?>">
                        <input type="hidden" name="<?php echo RESULTS_MODE; ?>" value="<?php echo RES_COMP; ?>">
                        <input class="history-btn-survey" type="submit" value="Компания">
                    </form>
                <?php
                endif; ?>
                </form>
            </td>
            <td class="tb-timeend"><?php echo date('d-m Y г H:i', strtotime($row['timeend'])); ?></td>
        </tr>
    <?php
        $count++;
    endwhile;
    if ($count == 0) : ?>
        <td colspan="4" style="text-align: center;">Никто не хочет проходить опросы :(</td>
    <?php
    endif; ?>
</table>