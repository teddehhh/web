<?php
$count = 0;
while ($row = $res->fetch_assoc()) : ?>
    <div class="survey-card-control">
        <a class="survey-card" href="survey.php?surveyid=<?php echo $row['surveyid'] ?>">
            <div class="survey-card-intro">
                <hr>
                <span><?php echo $row['title'] ?></span>
            </div>
            <p class="survey-card-info"><?php echo $row['description'] ?></p>
        </a>
        <div class="survey-control">
            <span class="survey-date">До <?php echo $row['timeend']; ?></span>
            <?php
            if ($_SESSION[SESSION_ROLEID] == RL_HR) : ?>
                <form method="POST">
                    <input type="hidden" value="<?php echo $row['surveyid']; ?>" name="surveyid">
                    <button type="submit" name="edit">
                        <img class="survey-cmd" src="images/edit.png">
                    </button>
                </form>
                <form method="POST">
                    <input type="hidden" value="<?php echo $row['surveyid']; ?>" name="surveyid">
                    <button type="submit" name="delete">
                        <img class="survey-cmd" src="images/delete.png" alt="">
                    </button>
                </form>
            <?php
            endif;
            ?>
        </div>
    </div>
<?php
    $count++;
endwhile;
if ($count == 0) : ?>
    <p>Вы прошли все опросы. Можете отдохнуть!</p>
<?php
endif; ?>