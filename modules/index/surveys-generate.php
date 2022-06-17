<?php
while ($row = $res->fetch_assoc()) : ?>
    <div class="survey-card-control">
        <a class="survey-card" href="survey.php?surveyid=<?php echo $row['surveyid'] ?>">
            <div class="survey-card-intro">
                <hr>
                <span><?php echo $row['title'] ?></span>
            </div>
            <p class="survey-card-info"><?php echo $row['description'] ?></p>
        </a>
        <?php
        if ($_SESSION[SESSTION_ROLEID] == RL_HR) : ?>
            <div class="survey-control">
                <input type="button" value="Результаты">
                <input type="button" value="Удалить">
            </div>
        <?php
        endif;
        ?>
    </div>
<?php
endwhile; ?>