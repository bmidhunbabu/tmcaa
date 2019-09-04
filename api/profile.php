<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

require_once '../includes/config.php';

$id = Role::getId('student');

$users = User::get([
    "phone = '" . $_POST['uname'] . "'",
    "password = '" . md5($_POST['pword']) . "'",
    "role_id = '$id'",
]);
if ($users) {
    $user = $users[0];
    echo $user->name;
} else {
    echo 'invalid login credentials';
}
