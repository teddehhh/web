<?php
if ($_SESSION[SESSION_ROLEID] == RL_HR) : ?>
    <div class="add-survey-container">
        <a class="add-survey-btn" href="add-survey.php">
            <img src="images/add.png">
            <p>Создать опрос</p>
        </a>
    </div>
<?php
endif;
