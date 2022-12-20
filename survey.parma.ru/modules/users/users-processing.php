<?php
if (isset($_POST['edit'])) :
    header('location: add-user.php?userid=' . $_POST['edit'] . '&edit');
elseif (isset($_POST['delete'])) :
    $stm = $connection->prepare('DELETE FROM users WHERE userid=?');
    $stm->execute([$_POST['delete']]);
    echo "<meta http-equiv='refresh' content='0'>";
endif;
