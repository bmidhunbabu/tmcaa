<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

require_once '../includes/config.php';

$id = Role::getId('student');

if (User::existsWith([
    'phone' => $_GET['uname'],
    'password' => md5($_GET['pword']),
    'role_id' => $id,
])) {
    $exams = Exam::get([
        "id > '" . $_GET['last_server_pid'] . "'",
        "start_date <= '" . date('Y-m-d') . "'",
        "end_date >= '" . date('Y-m-d') . "'",
        "status = '1'",
    ]);

    if ($exams) {
        $result = [];
        foreach ($exams as $exam) {
            $data = $exam->attributes;
            $data['course_name'] = $exam->course()->name;
            if ($exam->questions()) {
                $questions = $exam->questions();
                foreach ($questions as $question) {
                    $qs = $question->attributes;
                    foreach ($question->answers() as $answer) {
                        $qs['options'][] = $answer->attributes;
                    }
                    $data['questions'][] = $qs;
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
