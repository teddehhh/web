<?php
if (isset($_POST['edit'])) :
    header('Location: survey.php?surveyid=' . $_POST['surveyid'] . '&edit');
elseif (isset($_POST['delete'])) :
    $stm = $connection->prepare('DELETE FROM survey WHERE surveyid=?');
    $stm->execute([$_POST['surveyid']]);
    $stm->free_result();
    echo "<meta http-equiv='refresh' content='0'>";
endif;
