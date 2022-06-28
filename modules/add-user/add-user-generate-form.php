<form id="user-form" method="POST" enctype="multipart/form-data" onsubmit="return formValidation();">
    <div class="info-card">
        <ul class="reg-form">
            <li class="user-img">
                <img style="margin-right:0;" id="preview" src="<?php echo $imgpath; ?>">
                <?php
                if (!$EDIT) : ?>
                    <input type="file" name="user-img" id="user-img" style="display: none;" onchange="previewImg(event);" value="<?php echo $imgpath; ?>" accept="image/*">
                    <input type="button" value="Выбрать изображение" style="border-radius: 5px; padding:5px; text-align:center;" id="imgbtn" onclick="document.getElementById('user-img').click();">
                <?php
                endif; ?>
            </li>
            <li>
                <ul class="sublist">
                    <li>
                        <p class="info-header">Фамилия</p>
                        <input type="text" class="user-info-input" name="surname" id="surname" autocomplete="off" value="<?php echo $surname; ?>">
                    </li>
                    <li>
                        <p class="info-header">Имя</p>
                        <input type="text" class="user-info-input" name="name" id="name" autocomplete="off" value="<?php echo $name; ?>">
                    </li>
                    <li>
                        <p class="info-header">Отчество</p>
                        <input type="text" class="user-info-input" name="patronymic" id="patronymic" autocomplete="off" value="<?php echo $patronymic; ?>">
                    </li>
                    <li>
                        <p class="info-header">Дата рождения</p>
                        <input type="date" class="add-survey-datetime" name="birthday" id="birthday" value="<?php echo $birthday; ?>" max="<?php echo date('Y-m-d', strtotime($mindate)); ?>">
                    </li>
                </ul>
            </li>
            <hr>
            <li>
                <ul class="sublist">
                    <?php
                    if ($role != RL_HR) : ?>
                        <li>
                            <p class="info-header">Роль</p>
                            <select name="role" id="role">
                                <?php
                                while ($row = $res_roles->fetch_assoc()) :
                                    $selected = $row['roleid'] == $role ? 'selected' : ''; ?>
                                    <option <?php echo $selected; ?> value="<?php echo $row['roleid']; ?>"><?php echo $row['name']; ?></option>
                                <?php
                                endwhile; ?>
                            </select>
                        </li>
                    <?php
                    endif; ?>
                    <li>
                        <p class="info-header">Подразделение</p>
                        <select name="subdiv" id="subdiv">
                            <?php
                            while ($row = $res_subdivs->fetch_assoc()) :
                                $selected = $row['subdivisionid'] == $subdivision ? 'selected' : ''; ?>
                                <option <?php echo $selected; ?> value="<?php echo $row['subdivisionid']; ?>"><?php echo $row['name']; ?></option>
                            <?php
                            endwhile; ?>
                        </select>
                    </li>
                </ul>
            </li>
            <hr>
            <li>
                <ul class="sublist">
                    <li>
                        <p class="info-header">Почта</p>
                        <input type="email" class="user-info-input" name="email" id="email" autocomplete="off" value="<?php echo $email; ?>">
                    </li>

                    <li>
                        <p class="info-header">Имя пользователя</p>
                        <input type="text" class="user-info-input" name="username" id="username" autocomplete="off" value="<?php echo $username; ?>">
                    </li>

                </ul>
                <hr>
            <li>
                <ul class="sublist">
                    <?php
                    if ($EDIT) : ?>
                        <li>
                            <p class="info-header" id="old-pass-header">Старый пароль</p>
                            <input type="password" class="user-info-input" name="old-password" id="old-password">
                        </li>
                    <?php
                    endif; ?>
                    <li>
                        <p class="info-header">Пароль</p>
                        <input type="password" class="user-info-input" name="password" id="password">
                    </li>
                    <li>
                        <p class="info-header">Повторите пароль</p>
                        <input type="password" class="user-info-input" name="password-check" id="password-check">
                    </li>
                </ul>
            </li>
            </li>
        </ul>
    </div>
    <div class="buttons-card">
        <?php
        if ($EDIT) : ?>
            <input type="hidden" name="userid" value="<?php echo $_POST['userid']; ?>">
            <input type="submit" name="save" value="Сохранить" id="save">
        <?php
        else : ?>
            <a class="cancel-link" href="users.php">Отмена</a>
            <input type="submit" name="register" value="Зарегистрировать" id="register">
        <?php
        endif; ?>
    </div>

</form>