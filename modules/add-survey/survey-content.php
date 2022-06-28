<div class="survey-info">
    <input class="add-survey-title" type="text" placeholder="Название опроса" name="title" autocomplete="off" value="Новый опрос">
    <input class="add-survey-desc" type="text" placeholder="Описание" name="desc" autocomplete="off">
    <div class="add-survey-date-container">
        <p class="survey-timeend">Доступен до</p>
        <input class="add-survey-datetime" type="date" name="date" id="date" min=<?php echo $date->format('Y-m-d'); ?> value="<?php echo $date->format('Y-m-d'); ?>">
        <input class="add-survey-datetime" type="time" name="time" id="time" step="60" value="12:00">
    </div>
</div>