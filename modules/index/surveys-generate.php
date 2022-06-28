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
            <span class="survey-date">До <?php echo date('d-m Y г H:i', strtotime($row['timeend'])); ?></span>
            <form method="POST" onsubmit="return surveyControl(this.submitted, '<?php echo $row['timeend']; ?>');">
                <?php
                if ($_SESSION[SESSION_ROLEID] == RL_HR) : ?>
                    <input type="hidden" value="<?php echo $row['timeend']; ?>" name="timeend" id="timeend">
                    <input type="hidden" value="<?php echo $row['surveyid']; ?>" name="surveyid">
                    <?php
                    if ($row['isarchived']) : ?>
                        <button type="submit" name="edit" onclick="this.form.submitted=this.value;">
                            <img class="survey-cmd" src="images/edit.png">
                        </button>
                    <?php else : ?>
                        <button type="submit" name="unload" onclick="this.form.submitted=this.value;" value="unload">
                            <img class="survey-cmd" src="images/unload.png">
                        </button>
                    <?php
                    endif; ?>
                    <button type="submit" name="delete" onclick="this.form.submitted=this.value;" value="delete">
                        <img class="survey-cmd" src="images/delete.png" alt="">
                    </button>
                    <?php
                    if ($row['isarchived']) : ?>
                        <button type="submit" name="upload" onclick="this.form.submitted=this.value;" value="upload">
                            <img class="survey-cmd" src="images/upload.png" alt="">
                        </button>
                <?php
                    endif;
                endif;
                ?>
            </form>
        </div>
    </div>
<?php
    $count++;
endwhile;
if ($count == 0) : ?>
    <p>Вы прошли все опросы. Можете отдохнуть!</p>
<?php
endif; ?>