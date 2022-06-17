<span class="container-title">История</span>
<table>
    <tr>
        <th>Дата</th>
        <th>Название</th>
        <th>Кол-во вопросов</th>
        <th>Время</th>
    </tr>
    <?php
    while ($stm->fetch()) :
        $min = intdiv($time, 60);
        $sec = $time % 60; ?>
        <tr class="row">
            <td class="date-col"><?php echo $date; ?></td>
            <td><?php echo $title; ?></td>
            <td><?php echo $question_count; ?></td>
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
