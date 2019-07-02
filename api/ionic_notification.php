<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
$time=time()+60*60*24*30;
$id=1;

$msq1="The Storyteller Bookstore on Saturday";
$msg2="report to school at 10am on Saturday";
$msg3="Students are allowed to take up a maximum of two Co-Curricular Activities";
  $someArray=array(0=>array("id"=>$id,"msg"=>$msq1,"title"=>"title 1","date"=>time()),1=>array("id"=>$id+1,"msg"=>$msg2,"title"=>"title 2","date"=>time()),2=>array("id"=>$id+2,"msg"=>$msg3,"title"=>"title 3","date"=>time()));
  
    $someJSON = json_encode($someArray);
  echo $someJSON;
