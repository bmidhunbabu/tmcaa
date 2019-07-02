<?php

require_once '../includes/config.php';

$id = Role::getId('student');

if (User::existsWith([
    'phone' => $_POST['uname'],
    'password' => md5($_POST['pword']),
    'role_id' => $id,
])) {
    echo 'success';
} else {
    echo 'invalid login credentials';
}
