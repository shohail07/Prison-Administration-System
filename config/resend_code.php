<?php

include_once('functions.php');
include_once('connect.php');
// include_once($_SERVER['DOCUMENT_ROOT'].'/v3/assets/smtp/sendmail.php');

$unique__id =mysqli_real_escape_string($connect, $_POST['unique__id']);
$email_id =mysqli_real_escape_string($connect, $_POST['email_id']);
$codephp = rand(111111,999999);
error_reporting(0);

$firstsql = "SELECT *  FROM users WHERE users.unique_id_php ='$unique__id' ;";   
$result = mysqli_query($connect, $firstsql);
$row = mysqli_fetch_array($result);



if (empty($unique__id)) {
   
    $attempt2sql ="UPDATE users SET verification = '$codephp' where  users.email ='$email_id';";

}else{
    
    $attempt2sql ="UPDATE users SET verification = '$codephp' where users.unique_id_php ='$unique__id' and users.email ='$email_id';";

}



    if(mysqli_query($connect, $attempt2sql)){
       

        echo 'done';
        include_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/email.php');
    }else{
        echo 'error';
    }

?>