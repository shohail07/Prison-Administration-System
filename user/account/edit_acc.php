<?php


require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');


$id= pass_openssl_2_dec($_POST['id']);
$sub_value =mysqli_real_escape_string($connect,$_POST['sub_value']);
$sub =mysqli_real_escape_string($connect,$_POST['sub']);
$sub_verify =$sub.'_verify';
sleep(1);
if (($_POST['verify']) == 'send_code') {
    
    // find same email
    if($sub == 'email'){
        $find_mail_sql_users = "SELECT *  FROM users WHERE $sub ='$sub_value' ;";
        $result_find_mail_sql_users = mysqli_query($connect, $find_mail_sql_users);
        $num_rows_find_mail_sql_users = mysqli_num_rows($result_find_mail_sql_users);
    }elseif($sub == 'phone'){
        $find_mail_sql_users = "SELECT *  FROM users_meta WHERE '$sub' ='$sub_value' ;";
        $result_find_mail_sql_users = mysqli_query($connect, $find_mail_sql_users);
        $num_rows_find_mail_sql_users = mysqli_num_rows($result_find_mail_sql_users);
    }
    
    
    if ($num_rows_find_mail_sql_users>0) {
        echo 00;
    }else{
        $codephp = rand(111111,999999);
        
        $set_sql = "INSERT INTO verify(unique_id_php, $sub, $sub_verify) VALUES ('$id','$sub_value','$codephp');";
        if (mysqli_query($connect, $set_sql)) {

            include_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/email.php');
            echo 'Enter code';
        }else{
            echo "Can't";
            echo $set_sql;
        }

    }
    

}
elseif(($_POST['verify']) == 'check_code'){
    $code = mysqli_real_escape_string($connect,$_POST['sub_code']);
    if($sub == 'email'){
        $fin_code_sql_users = "SELECT *  FROM verify WHERE $sub ='$sub_value' and unique_id_php='$id' ;";
        $result_find_code_sql_users = mysqli_query($connect, $fin_code_sql_users);
        
        $fetch_array_find_mail_sql_users = mysqli_fetch_array($result_find_code_sql_users); 
        
        $check_code = $fetch_array_find_mail_sql_users["email_verify"];
       
    }elseif($sub == 'phone'){
        $fin_code_sql_users = "SELECT *  FROM verify WHERE '$sub' ='$sub_value' and unique_id_php='$id';";
        $result_find_code_sql_users = mysqli_query($connect, $fin_code_sql_users);
        $fetch_array_find_mail_sql_users = mysqli_fetch_array($result_find_code_sql_users);
        $check_code = $fetch_array_find_mail_sql_users['phone_verify'];
       
    }
    
    
    if ($check_code == $code) {
        echo 'done';
    }else{
        echo 0;
    }

}else{
    echo 'aa';
}


?>