<?php 

$status = session_status();
if($status == PHP_SESSION_NONE){

    session_start();
}
session_regenerate_id(true);


require_once("connect.php");
require_once('functions.php');


 error_reporting(0);

if (isset($_POST['signin'])) {

    $login_email = mysqli_real_escape_string($connect, $_POST['user_mail']);
    $login_pass = mysqli_real_escape_string($connect, $_POST['user_pass']);

    $firstsql = "SELECT *  FROM users WHERE users.email ='$login_email';";
   
   
    $result = mysqli_query($connect, $firstsql);

    $row = mysqli_fetch_array($result);
    $mail = $row['email'];

    // password encrpt r kaj baki 
    $pass = pass_openssl_dec($row['password']);

    // echo'<pre>';
    // // print_r($_POST);
    // print_r($row);
    // die();


    if(empty($login_email) && empty($login_pass)){
        
        $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('Fill the blanks');
    }elseif (empty($login_pass)) {
        
        $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('Fill the pass');
    }elseif (empty($login_email)) {
       
        $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('Fill the mail');
    }elseif ($mail !== $login_email) {
        
        $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc("user isn't exist");
    }elseif ($pass !== $login_pass) {
        
        $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('incorrect');
    }
    else{
        
               

        if (mysqli_num_rows($result) == 1) {

            $_SESSION[pass_openssl_2_enc('status')]=pass_openssl_enc('online');
            $_SESSION[pass_openssl_2_enc('unique_id_php')]= pass_openssl_enc($row['unique_id_php']);
            // $_SESSION[pass_openssl_2_enc('full_name')]= pass_openssl_enc($row['full_name']);
            $_SESSION[pass_openssl_2_enc('email')]= pass_openssl_enc($row['email']);
            // $_SESSION[pass_openssl_2_enc('verification')]= pass_openssl_enc($row['verification']);
            // $_SESSION[pass_openssl_2_enc('role')]= pass_openssl_enc($row['role']);
            // $_SESSION[pass_openssl_2_enc('login_attempt')]= pass_openssl_enc($row['login_attempt']);
            // $_SESSION[pass_openssl_2_enc('block')]= pass_openssl_enc($row['block']);



             

            $abcd= $row['unique_id_php'];
            
            if ($row['login_attempt']  > 4) {
                $attempt2sql ="UPDATE users SET block = 'yes' WHERE users.unique_id_php = '$abcd';";
                if(mysqli_query($connect, $attempt2sql)){
                    header('location:index.php');
                    $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('blocked user');
                    $_SESSION[pass_openssl_2_enc('status')]=pass_openssl_2_enc('offline');
                }else{
                    $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('User problem');
                    $_SESSION[pass_openssl_2_enc('status')]=pass_openssl_2_enc('offline');
                }
                
            }
            if ($row['block'] == 'yes') {
                header('location:index.php');
                $_SESSION[pass_openssl_2_enc('msg_passer')]=pass_openssl_2_enc('user blocked');
                $_SESSION[pass_openssl_2_enc('status')]=pass_openssl_2_enc('offline');
            
            }else{
               
                if ($row['verification'] == '1') {
                    header('location:config/verification.php');
                } elseif($row['verification'] !== 1){

                    $a = $row['login_attempt'];
                    $a++;
                   
                    $attempt2sql ="UPDATE users SET login_attempt = '$a' WHERE users.unique_id_php = '$abcd';";

                    if(mysqli_query($connect, $attempt2sql)){
                        $_SESSION['login_attempt'] = $a;
                        header('location:config/verification.php');
                    }else{
                        $_SESSION[pass_openssl_2_enc('msg_passer')]=pass_openssl_2_enc('some is wrong');
                        $_SESSION[pass_openssl_2_enc('status')]=pass_openssl_2_enc('offline');
                    }


                }
                
                
               
                
            }
        }else{
            $_SESSION[pass_openssl_2_enc('msg_passer')] = pass_openssl_2_enc("not exist");
        }
            
        
        
        
        
        

    }


}

?>