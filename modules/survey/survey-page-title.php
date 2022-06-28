<?php
if ($EDIT) : ?>
    <h1>Редактирование опроса</h1>
    <?php
elseif (isset($_POST[RESULTS_MODE])) :
    switch ($_POST[RESULTS_MODE]):
        case MY_RES: ?>
            <h1>Мои ответы</h1>
        <?php
            break;
        case RES_COMP: ?>
            <h1>Ответы по компании</h1>
        <?php
            break;
        case RES_SUBDIV: ?>
            <h1>Ответы по подразделению</h1>
<?php
            break;
    endswitch;
endif;
