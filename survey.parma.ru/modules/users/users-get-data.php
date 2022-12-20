<?php
$res = $connection->query('SELECT user_info.userid as userid, surname, user_info.name as name, patronymic, subdivision.name as subdivision, role.name as role FROM user_info JOIN users ON users.userid=user_info.userid JOIN role ON role.roleid=users.roleid JOIN subdivision ON subdivision.subdivisionid=user_info.subdivisionid');
