<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');


$unique_id =mysqli_real_escape_string($connect,$_POST['id']);
// $approve_list =mysqli_real_escape_string($connect,$_POST['approve_list']);
$approve_list =mysqli_real_escape_string($connect,isset($_POST['approve_list']) ? $_POST['approve_list'] : " ");
$from_data =mysqli_real_escape_string($connect,isset($_POST['from_data']) ? $_POST['from_data'] : " ");
$from_time =mysqli_real_escape_string($connect,isset($_POST['from_time']) ? $_POST['from_time'] : " ");
$to_data =mysqli_real_escape_string($connect,isset($_POST['to_data']) ? $_POST['to_data'] : " ");
$to_time =mysqli_real_escape_string($connect,isset($_POST['to_time']) ? $_POST['to_time'] : " ");
// $from_time =mysqli_real_escape_string($connect,$_POST['from_time']);
// $to_data =mysqli_real_escape_string($connect,$_POST['to_data']);
// $to_time =mysqli_real_escape_string($connect,$_POST['to_time']);


$sql = "UPDATE request SET approve ='$approve_list',to_time='$to_time',to_data='$to_data',from_time='$from_time',from_data='$from_data' WHERE unique_id= '$unique_id';";



if(mysqli_query($connect, $sql)){
    echo'ok';
    }else{
    echo 'not';
    };











?>