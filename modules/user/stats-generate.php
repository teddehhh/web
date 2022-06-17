<div class="stat-cards">
    <div class="stat-card">
        <img src="images/count.png" alt="">
        <p class="stat-value"><?php echo $count_surveys; ?></p>
        <p class="stat-about">пройденных опросов</p>
    </div>
    <div class="stat-card">
        <img src="images/smile.png" alt="">
        <p class="stat-value"><?php echo $emoji_code; ?></p>
        <p class="stat-about">часто используемый смайлик</p>
    </div>
    <div class="stat-card">
        <img src="images/clock.png" alt="">
        <p class="stat-value"><?php echo "{$min}:{$sec}"; ?></p>
        <p class="stat-about">среднее время прохождения опроса</p>
    </div>
    <?php
    if ($_SESSION[SESSTION_ROLEID] != RL_EMPLOYEE) : ?>
        <div class="stat-card">
            <img src="images/active.png" alt="">
            <p class="stat-value"><?php echo $subdiv_name; ?></p>
            <p class="stat-about">самое активное подразделение</p>
        </div>
        <div class="stat-card">
            <img src="images/group.png" alt="">
            <p class="stat-value"><?php echo $employee_count; ?></p>
            <p class="stat-about">количество активных сотрудников</p>
        </div>
        <?php
        if ($_SESSION[SESSTION_ROLEID] == RL_HR) : ?>
            <div class="stat-card">
                <img src="images/day-night.png" alt="">
                <p class="stat-value"><?php echo $time_of_day; ?></p>
                <p class="stat-about">частое время суток прохождения опросов</p>
            </div>
</div>
<?php
        endif;
    endif;
