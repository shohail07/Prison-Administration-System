<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');


$unique_id =mysqli_real_escape_string($connect,$_POST['id']);
// $approve_list =mysqli_real_escape_string($connect,$_POST['approve_list']);
$approve_list =mysqli_real_escape_string($connect,isset($_POST['approve']) ? $_POST['approve'] : " ");

// $from_time =mysqli_real_escape_string($connect,$_POST['from_time']);
// $to_data =mysqli_real_escape_string($connect,$_POST['to_data']);
// $to_time =mysqli_real_escape_string($connect,$_POST['to_time']);
if ($approve_list == 'renew') {
    $sql = "UPDATE request SET approve ='$approve_list' WHERE unique_id= '$unique_id';";

}else{
    $sql = "DELETE FROM request  WHERE unique_id= '$unique_id';";
}






if(mysqli_query($connect, $sql)){
    echo'ok';
    }else{
    echo 'not';
    };











?>