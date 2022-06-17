<table>
    <tr>
        <th>Название</th>
        <th>Статус подразделения</th>
        <th>Результаты</th>
        <th>Дата закрытия</th>
    </tr>
    <?php
    $stm_emp_count = $connection->prepare('SELECT COUNT(*) as count FROM user_info WHERE subdivisionid=?');
    $stm_emp_count->execute([$_SESSION[SESSION_SUBDIVID]]);
    $stm_emp_count->bind_result($general_subdiv_count);
    $stm_emp_count->fetch();
    $stm_emp_count->free_result();

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
            <td><?php echo $subdiv_count . '/' . $general_subdiv_count; ?></td>
            <td>
                <?php
                if($subdiv_count > 0):?>
                    <a href=""><input type="button" value="Подразделение"></a>

                <?php
                endif;
                if($general_count > 0):?>
                <a href=""><input type="button" value="Компания"></a>
                <?php
                endif;?>
            </td>
            <td class="tb-timeend"><?php echo $row['timeend']; ?></td>
        </tr>
    <?php
    endwhile; ?>
</table>