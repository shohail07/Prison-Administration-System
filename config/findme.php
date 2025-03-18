<?php

session_start();
session_regenerate_id(true);
include_once('functions.php');
include_once('connect.php');
// include_once($_SERVER['DOCUMENT_ROOT'].'/v3/assets/smtp/sendmail.php');



$email_id =mysqli_real_escape_string($connect, $_POST['email_id']);

$firstsql = "SELECT *  FROM users WHERE users.email ='$email_id';";
$result = mysqli_query($connect, $firstsql);
$row = mysqli_fetch_array($result);

sleep(2);

if (mysqli_num_rows($result) == 1) {

    
    $_SESSION[pass_openssl_2_enc('status')] = pass_openssl_enc('online');
    $_SESSION[pass_openssl_2_enc('unique_id_php')]= pass_openssl_enc($row['unique_id_php']);
    $_SESSION[pass_openssl_2_enc('email')]= pass_openssl_enc($row['email']);

    $unique__id =mysqli_real_escape_string($connect, $row['unique_id_php']);
    $email_id =mysqli_real_escape_string($connect, $row['email']);
    $codephp = rand(111111,999999);
    $attempt2sql ="UPDATE users SET verification = '$codephp' where users.unique_id_php ='$unique__id' and users.email ='$email_id';";


    if(mysqli_query($connect, $attempt2sql)){
       
        
        $_SESSION[pass_openssl_2_enc('password_change_trigger')]=pass_openssl_2_enc('change mode on');
        echo 'found';
        include_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/email.php');
    }else{
        echo 'error';
    }
} else {

    echo 'not found';
}




?>