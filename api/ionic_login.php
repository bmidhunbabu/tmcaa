<?php
header("Access-Control-Allow-Origin: *");
//header('content-type: application/json; charset=utf-8');
include_once('dbs.php');
 //$ds[]="success";
 //$json=json_encode($ds);
// exit("{$_POST['callback']}($json)");


if($_POST['uname']=='demo'&&$_POST['pword']=='demo')             // && $_POST['pword']=='demo'
echo "success";
else
echo "invalid username or password";


file_put_contents("just_a_test.txt",json_encode($_POST).json_encode($_GET));
?>