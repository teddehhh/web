<?php
$res_roles = $connection->query('SELECT roleid, name FROM role WHERE roleid != 1');
$res_subdivs = $connection->query('SELECT subdivisionid, name FROM subdivision');


$surname = '';
$name = '';
$patronymic = '';
$birthday = '';
$imgpath = 'images/default-user.png';
$role = '';
$subdivision = '';
$username = '';
$email = '';

date_default_timezone_set('Asia/Yekaterinburg');
$mindate = date('Y-m-d', time());

if ($EDIT) :
    $stm = $connection->prepare('SELECT surname, user_info.name as name, patronymic,birthday,imgpath, email, role.roleid as role, subdivision.subdivisionid as subdivision, username FROM user_info JOIN users ON users.userid=user_info.userid JOIN role ON role.roleid=users.roleid JOIN subdivision ON subdivision.subdivisionid=user_info.subdivisionid WHERE user_info.userid=?');
    $stm->execute([$_POST['userid']]);
    $res = $stm->get_result();
    $row = $res->fetch_assoc();
    $surname = $row['surname'];
    $name = $row['name'];
    $patronymic = $row['patronymic'];
    $birthday = $row['birthday'];
    $imgpath = 'images/users/' . $row['imgpath'];
    $role = $row['role'];
    $subdivision = $row['subdivision'];
    $username = $row['username'];
    $email = $row['email'];
endif;
