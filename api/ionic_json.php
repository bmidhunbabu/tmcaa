<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
$time = time() + 60 * 60 * 24 * 30;

/*

recieved values
 $_GET['uname']
 $_GET['pass']
 $_GET['last_server_pid']
*/

$someArray = array(
  0 => array("name" => "physcics-model", "category" => "physics", "end_date" => "{$time}", "max_sec" => "3600", "left_sec" => "0", "server_pid" => "1", "correct" => "3", "worng" => "1", "question" => array(0 => array("qs" => "charge of electron", "answer" => "johnson found voltage of electron", "server_qid" => "1", "option" => array(0 => array("msg" => "1.7 V", "correct" => "1"), 1 => array("msg" => "8 v", "correct" => "0"), 2 => array("msg" => ".7 V", "correct" => "0"), 3 => array("msg" => "2 v", "correct" => "0"))), 1 => array("qs" => "whats speed of light", "answer" => "found by electron microscope", "server_qid" => "1", "option" => array(0 => array("msg" => "3 km/sec", "correct" => "1"), 1 => array("msg" => "4 km/sec", "correct" => "0"), 2 => array("msg" => "2 km/sec", "correct" => "0"), 3 => array("msg" => "1 km/sec", "correct" => "0")))))
);
// Convert Array to JSON String
$someJSON = json_encode($someArray);
echo $someJSON;
