<?php


require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');
// require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php');


$pass_id  =mysqli_real_escape_string($connect,$_POST['id']);


if ($_POST['send'] == 'yes') {
  $msg =mysqli_real_escape_string($connect,$_POST['msg']);
  
    $firstsql =  "INSERT INTO records(unique_id,msg, time) VALUES ('$pass_id','$msg',NOW());"; 
        $result = mysqli_query($connect, $firstsql);
        echo 'ok';
      
}






?>
