<?php
if ($EDIT) : ?>
    <div class="survey-info">
        <input class="add-survey-title" type="text" placeholder="Название опроса" name="title" autocomplete="off" value="<?php echo $title; ?>">
        <input class="add-survey-desc" type="text" placeholder="Описание" name="desc" autocomplete="off" value="<?php echo $description; ?>">
        <div class="add-survey-date-container">
            <p class="survey-timeend">Дата завершения</p>
            <input class="add-survey-datetime" type="date" name="date" value="<?php echo date('Y-m-d', strtotime($timeend));; ?>">
        </div>
    </div>
<?php
else : ?>
    <h1><?php echo $title; ?></h1>
    <div class="survey-about">
        <p><?php echo $description; ?></p>
    </div>
    <p class="survey-timeend">Доступен до <?php echo $timeend; ?></p>
<?php
endif;
