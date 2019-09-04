<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

require_once '../includes/config.php';

$id = Role::getId('student');

$data = json_decode($_POST['pack']);
$cred = $data[0];
array_shift($data);

$users = User::get([
    "phone = '" . $cred->user . "'",
    "password = '" . md5($cred->pass) . "'",
    "role_id = '$id'",
]);

$result_ids = [];

if ($users) {
    $user = $users[0];
    foreach ($data as $result) {
        $result_ids[] = Result::create([
            'user_id' => $user->id,
            'exam_id' => $result->server_pid,
            'attended' => $result->attend,
            'correct' => $result->cor_no,
            'wrong' => $result->attend - $result->cor_no,
            'score' => ($result->cor_no * $result->correct) - (($result->attend - $result->cor_no) * $result->wrong),
        ]);
    }
    echo json_encode($result_ids);
} else {
    echo 'invalid login credentials';
}
