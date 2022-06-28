<table class="users-table">
    <tr>
        <th>Фамилия</th>
        <th>Имя
        <th>Отчество</th>
        <th>Подразделение</th>
        <th>Роль</th>
        <th></th>
        </th>
    </tr>
    <?php
    while ($row = $res->fetch_assoc()) : ?>
        <tr>
            <td><?php echo $row['surname']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['patronymic']; ?></td>
            <td><?php echo $row['subdivision']; ?></td>
            <td><?php echo $row['role']; ?></td>
            <td class="control-column">
                <form action="add-user.php" method="POST">
                    <button class="user-cmd" type="submit" name="userid" value="<?php echo $row['userid']; ?>">
                        <img class="survey-cmd" src="images/edit.png" alt="">
                    </button>
                </form>
                <?php
                if ($_SESSION[SESSION_USERID] != $row['userid']) : ?>
                    <form method="POST">
                        <button class="user-cmd" type="submit" name="delete" value="<?php echo $row['userid']; ?>">
                            <img class="survey-cmd" src="images/delete.png" alt="">
                        </button>
                    </form>
                <?php
                endif; ?>
            </td>
        </tr>
    <?php
    endwhile;
    ?>
</table>