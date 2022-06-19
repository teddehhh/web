<table>
    <tr>
        <th>Дата</th>
        <th>Название</th>
        <th>Время</th>
    </tr>
    <?php
    while ($stm->fetch()) :
        $min = intdiv($time, 60);
        $sec = $time % 60; ?>
        <tr class="row">
            <td class="date-col"><?php echo $date; ?></td>
            <td>
                <form method="POST" action="survey.php?surveyid=<?php echo $surveyid; ?>">
                    <input type="hidden" name="<?php echo RESULTS_MODE; ?>" value="<?php echo MY_RES; ?>">
                    <input class="history-btn-survey" type="submit" value="<?php echo $title; ?>">
                </form>

            </td>
            <td class="time-col"><?php echo "{$min}:{$sec}"; ?></td>
        </tr>
    <?php
    endwhile;
    if ($res_count == 0) : ?>
        <tr>
            <td colspan="4" style="text-align: center;"> Пройдите опрос, чтобы начать историю</td>
        </tr>
    <?php
    endif; ?>
</table>
<?php
