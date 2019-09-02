<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

require_once '../includes/config.php';

$id = Role::getId('student');

if (User::existsWith([
    'phone' => $_POST['uname'],
    'password' => md5($_POST['pword']),
    'role_id' => $id,
])) {
    $user = User::get([
        'phone' => $_POST['uname'],
        'password' => md5($_POST['pword']),
        'role_id' => $id,
    ]);
    return $user->name;
} else {
    echo 'invalid login credentials';
}
