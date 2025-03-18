<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');

$id =mysqli_real_escape_string($connect,$_POST['reciver']);
$sender =mysqli_real_escape_string($connect,$_POST['sender']);
$text_box =mysqli_real_escape_string($connect,$_POST['text_box']);
$reciver = pass_openssl_2_dec($id);


$insert_sql= "INSERT INTO msg( sender, reciver, text, seen, time) VALUES ('$sender','$reciver','$text_box','0',NOW())";
// echo $insert_sql;
// mysqli_query($connect, $insert_sql);
if (mysqli_query($connect, $insert_sql)){
    echo 'OK';
}else{
    echo 'not';
}







?>