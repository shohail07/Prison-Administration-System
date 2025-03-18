<?php

include_once('functions.php');
include_once('connect.php');




$status = session_status();
if($status == PHP_SESSION_NONE){

    session_start();
    session_regenerate_id(true);
}


error_reporting(0);
// if ($_SESSION[pass_openssl_2_enc('status')] !== pass_openssl_enc('online') || !isset($_SESSION[pass_openssl_2_enc('password_change_trigger')])) {
    
//     $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc("Don't try again!!");
//     header('location:verification.php');
// }

$email_php = pass_openssl_dec($_SESSION[pass_openssl_2_enc('email')]);
$unique__php = pass_openssl_dec($_SESSION[pass_openssl_2_enc('unique_id_php')]);

if (isset($_POST['change_pass_btn'])) {


  if ($_SESSION[pass_openssl_2_enc('password_change_trigger')] == pass_openssl_2_enc('change mode for logged user')) {
    $current_pass = mysqli_real_escape_string($connect, $_POST['current_pass']);
    if(empty($current_pass)){
      $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('Required Current Password');
    }

  }

  $change_pass = mysqli_real_escape_string($connect, $_POST['change_pass']);
  $change_re_pass = mysqli_real_escape_string($connect, $_POST['change_re_pass']);

  


  if(empty($change_pass) && empty($change_re_pass) ){
    $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('Required Password');
  }
  elseif(empty($change_pass)) {
    $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('Required New Password');
  }elseif(empty($change_re_pass)) {
    $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('Enter Your New Password Again');
  }elseif($change_re_pass !== $change_pass) {
    $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('Both Must be Same');
  }elseif($change_re_pass == $change_pass) {

    $pass= pass_openssl_enc($change_re_pass);

    if ($_SESSION[pass_openssl_2_enc('password_change_trigger')] == pass_openssl_2_enc('change mode for logged user')) {
      
      if(!empty($current_pass)){
        $firstsql = "SELECT password  FROM users WHERE users.email = '".$email_php."' and users.unique_id_php = '".$unique__php."';";
        $result = mysqli_query($connect, $firstsql);
        $row = mysqli_fetch_array($result);
        
        $old_pass = $row['password'];
        $current_pass = pass_openssl_enc($current_pass);
        if($current_pass == $old_pass){
          $updatephp = "UPDATE users SET password = '".$pass."' WHERE users.email = '".$email_php."' and users.unique_id_php = '".$unique__php."';";

        }else{
          $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc(' Current Password Dismatched');
        }
      }
  
    }

    if ($_SESSION[pass_openssl_2_enc('password_change_trigger')] !== pass_openssl_2_enc('change mode for logged user')) {
      $updatephp = "UPDATE users SET password = '".$pass."' WHERE users.email = '".$email_php."' and users.unique_id_php = '".$unique__php."';";

    };
    sleep(3); 

    if(mysqli_query($connect, $updatephp)){
      $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('Password Changed');
      unset($_SESSION[pass_openssl_2_enc('password_change_trigger')]);
      unset($_SESSION[pass_openssl_2_enc('msg_passer')]);
      header('location:verification.php');
    }else{
      if(empty($current_pass)){
        $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('Required Current Password');
      }else{
      $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc("Current Password didn't match");
      }
    }
  }else {
    $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('Fall to change');
  }
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php') ?>
    
</head>
<body>



<div id="change_password_section">
            <div class="container">
              <div class="back text-left"><a href="#" class="btn btn-warning" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
</svg></a></div>
              <h2 class="title_bar">Change Password</h2>
                  <div class="email_show_box">
                    <p class="text-success fw-bold">Your Email: <span class="text-decoration-underline"><?php  echo $email_php;?></span></p>
                  </div>
              
                  <form method="POST"  class="change_pass_form" id="change_pass_form" autocomplete="off">

                    <div class="message_box text-center pb-3">
                      <img src="Infinity-1s-200px.gif" >
                      <p class=' tw-bold text-danger '><?php if (isset($_SESSION[pass_openssl_2_enc('msg_passer')])) { echo pass_openssl_2_dec($_SESSION[pass_openssl_2_enc('msg_passer')]);}?></p>
                    </div>
                    <?php if (isset($_SESSION[pass_openssl_2_enc('password_change_trigger')]) && $_SESSION[pass_openssl_2_enc('password_change_trigger')] == pass_openssl_2_enc('change mode for logged user')) {
                      echo '<div class="form-group"><label for="current_pass"><i class="fas fa-lock-alt"></i></label><input type="password" name="current_pass" id="current_pass" placeholder="Your Current Password" /></div>';
                    }
                      
                    ?>
                    <div class="form-group">
                        <label for="change_pass"><i class="fas fa-lock-alt"></i></label>
                        <input type="password" name="change_pass" id="change_pass" placeholder="Your New Password" />
                    </div>
                    <div class="form-group">
                        <label for="change_re_pass"><i class="far fa-lock re_lock"></i></label>
                        <input type="password" name="change_re_pass" id="change_re_pass" placeholder="Repeat your New password" />
                    </div>
                    <div class="form-group form-button">
                        <input type="submit" name="change_pass_btn" id="change_pass_btn" class="form-submit" value="Change Password"/>
                    </div>
                </form>
              </div>
</div>

   <!-- js -->
   <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
   <script src="assets/js/script.js"></script>
        <script>
          $(document).ready(function () {
            $('.message_box img').hide();
            $('#change_pass_form').keyup(function (e) { 
                
                $pass = $('#change_pass').val();
                $re_pass = $('#change_re_pass').val();
                if ($re_pass == $pass) {
                    
                    $(".re_lock").addClass("label_border");
                }else{
                   
                    $(".re_lock").removeClass("label_border");
                   
                }
              
            
            });
            $('#change_pass_btn').click(function (e) { 
              
              $('.message_box img').show();
              
            });
            $('.back a').click(function (e) { 
              e.preventDefault();
              history.back();
              
            });
            
          });
        </script>