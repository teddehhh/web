<?php
if ($EDIT) : ?>
    <input class="add-survey-title" type="text" placeholder="Название опроса" name="title" autocomplete="off" value="<?php echo $title; ?>">
    <input class="add-survey-desc" type="text" placeholder="Описание" name="desc" autocomplete="off" value="<?php echo $description; ?>">
    <div class="add-survey-date-container">
        <p class="survey-timeend">Доступен до</p>
        <input class="add-survey-datetime" type="date" name="date" id='date' value="<?php echo date('Y-m-d', strtotime($timeend)); ?>" min="<?php echo $mindate->format('Y-m-d'); ?>">
        <input class="add-survey-datetime" type="time" name="time" id="time" step="60" value="<?php echo date('H:i', strtotime($timeend)); ?>">
    </div>
<?php
else : ?>
    <h2><?php echo $title; ?></h2>
    <div class="survey-about">
        <p><?php echo $description; ?></p>
    </div>
    <p class="survey-timeend">Доступен до <?php echo date('d-m Y г', strtotime($timeend)); ?></p>
<?php
endif;
