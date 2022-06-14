<?php
if (isset($_POST['signin'])) :
    switch ($_SESSION[SESSION_ERROR]):
        case UNKNOWN_USER:
?> <span class="error-msg">Пользователь не найден</span>
        <?php
            break;
        case WRONG_USER_OR_PASS:
        ?> <span class="error-msg">Неверные имя пользователя или пароль</span>
<?php
            break;
    endswitch;
endif;
