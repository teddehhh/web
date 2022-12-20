<div class="info-card">
    <img src="images/users/<?php echo $imgpath; ?>" alt="">
    <ul>
        <li>
            <p class="info-header">ФИО</p>
            <p class="info-value"><?php echo implode(' ', array($surname, $name, $patronymic)); ?></p>
        </li>
        <li>
            <p class="info-header">Статус</p>
            <p class="info-value"><?php echo $status; ?></p>
        </li>
        <li>
            <p class="info-header">Подразделение</p>
            <p class="info-value"><?php echo $subdivision; ?></p>
        </li>
        <li>
            <p class="info-header">Дата рождения</p>
            <p class="info-value"><?php echo $birthday; ?></p>
        </li>
        <li>
            <p class="info-header">Почта</p>
            <p class="info-value"><?php echo $email; ?></p>
        </li>
    </ul>
</div>