<?php

require_once '../includes/config.php';

$id = Role::getId('student');

if (User::existsWith([
    'phone' => $_GET['uname'],
    'password' => md5($_GET['pword']),
    'role_id' => $id,
])) {
    $exams = Exam::get([
        "id > '" . $_GET['last_server_pid'] . "'"
    ]);
    if ($exams) {
        $result = [];
        foreach ($exams as $exam) {
            $data = $exam->attributes;
            if ($exam->questions()) {
                $questions = $exam->questions();
                foreach ($questions as $question) {
                    $data['questions'][] = $question->attributes;
                }
            }
            $result[] = $data;
        }
        echo json_encode($result);
    } else {
        echo 'No exams found';
    }
} else {
    echo 'invalid login credentials';
}
