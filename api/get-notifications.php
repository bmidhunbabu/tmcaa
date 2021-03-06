<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

require_once '../includes/config.php';

$notifications = Notification::paginate(0, 10, null, 'created_at', 'desc');
$result = [];
foreach ($notifications as $notification) {
    $result[] = $notification->attributes;
}
echo json_encode($result);
