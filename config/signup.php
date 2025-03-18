<?php
unset($_SESSION);
session_start();
session_regenerate_id(true);
// include_once('../../database/conection.php');


require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php');
unset($_SESSION[pass_openssl_2_enc('msg_passer')]);


if (isset($_SESSION[pass_openssl_2_enc('status')])) {
  header('location:verification.php');
}

$selection_option_sql ="SELECT * FROM rule_names WHERE audience ='public'";
$selection_option_result = mysqli_query($connect, $selection_option_sql);
$selection_option_list='';
if(mysqli_num_rows($selection_option_result) > 0)
{
	
  
	while($list_row_option = mysqli_fetch_array($selection_option_result))
	{ 
    $val =$list_row_option['value_rule'];
    $val_name =$list_row_option['rule_name'];
		$selection_option_list .= '<option value="'.$val.'">'.$val_name.'</option>';
	}
	
}

if (isset($_POST['signup'])) {
 
    $signup_full_name = mysqli_real_escape_string($connect, $_POST['signup_full_name']);
    $signup_email = mysqli_real_escape_string($connect, $_POST['signup_mail']);
    $signup_pass0 = mysqli_real_escape_string($connect, $_POST['signup_pass']);
    $signup_re_pass = mysqli_real_escape_string($connect, $_POST['signup_re_pass']);
    $signup_option_type = mysqli_real_escape_string($connect, $_POST['option_type']);
    

    $firstsql = "SELECT *  FROM users WHERE users.email ='$signup_email';";
    $result = mysqli_query($connect, $firstsql);
    $row = mysqli_fetch_array($result);
    
    if(empty($signup_full_name) && empty($signup_email) &&empty($signup_pass0) && empty($signup_re_pass) && !isset($_POST['agree-term'])){
      $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('Required All Information');
    }
    elseif (empty($signup_full_name)) {
      $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('Required Your Full Name');
    }elseif(empty($signup_email)) {
      $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('Required Your Email Address');
    }elseif(empty($signup_pass0)) {
      $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('Required Your Password');
    }elseif(empty($signup_re_pass)) {
      $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('Enter Your Password Again');

    }elseif($signup_option_type == 'not') {
      $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('You need to select type');

    }elseif(!isset($_POST['agree-term'])) {
      $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('You need to accept our terms and conditions');

    }elseif($signup_re_pass !== $signup_pass0) {
      $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('Both passwords must be same');

    }elseif(mysqli_num_rows($result) == 1){
      $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('Email is already exist');
    }
    else{

      if ($signup_re_pass == $signup_pass0 ) {
     
        
        $approved = "need";
        
        $codephp = rand(111111,999999);
        // $codephp = 1;
        $unique_id_php= md5(time().mt_rand(1001,9999));   
        $signup_pass = pass_openssl_enc($signup_re_pass);
        $insertsql=  "INSERT INTO users (id, unique_id_php, full_name, email, password, verification, role, login_attempt, block, inert_time, approved) VALUES (NULL,'$unique_id_php', '$signup_full_name', '$signup_email', '$signup_pass', '$codephp', '$signup_option_type', '0', 'no', NOW(),'$approved')";
      
      }
      
      
     
      if (mysqli_query($connect, $insertsql)) {
  
  
          
          $_SESSION[pass_openssl_2_enc('status')]=pass_openssl_enc('online');
          $signupdata = "SELECT * FROM users WHERE users.email = '".$signup_email."'  AND users.password = '".$signup_pass."' ;";
         
         
          $signupresult = mysqli_query($connect, $signupdata);
  
          $signuprow = mysqli_fetch_array($signupresult);
  
          $_SESSION[pass_openssl_2_enc('status')]=pass_openssl_enc('online');
          $_SESSION[pass_openssl_2_enc('unique_id_php')]= pass_openssl_enc($signuprow['unique_id_php']);
          $_SESSION[pass_openssl_2_enc('email')]= pass_openssl_enc($signuprow['email']);
          // $_SESSION[pass_openssl_2_enc('verification')]= pass_openssl_enc($signuprow['verification']);
          // $_SESSION[pass_openssl_2_enc('login_attempt')]= pass_openssl_enc($signuprow['login_attempt']);
          $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('Verification code is sent to your mail. Check your mailbox');




          
          // $sub='Verify Your Email ';
          // $body="Hi ".$signuprow['full_name'].",<br>Your verification code is :<h2>".$signuprow['verification']."</h2>.<br>
          //       Enter this code to activate your account.<br>";
          // sending_mail($signuprow['full_name'],'',$sub,$body);
          include_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/email.php');
          header('location:verification.php');
                    
  
          
      }else {
        $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('failed to signup ');
  
      }


    }

    


}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php') ?>
    
</head>
<body>

<section id="sign_in_out">

  
<!-- Sign up -->
<div id="signup_section">
            <div class="container">
                <!-- <div class="signup-content"> -->
                    <div class="signup_form">
                        <h2 class="form-title">Sign up</h2>
                        <form method="POST"  class="register_form" id="register_form" autocomplete="off">
                            <div class="message_box">
                                <p class="text-danger fw-bold"><?php if (isset($_SESSION[pass_openssl_2_enc('msg_passer')])) { echo pass_openssl_2_dec($_SESSION[pass_openssl_2_enc('msg_passer')]);}?></p>
                               
                            </div>
                            <div class="form-group">
                                <label for="signup_full_name"><i class="fas fa-user"></i></label>
                                <input type="text" name="signup_full_name" id="signup_full_name" placeholder="Your Full Name" />
                            </div>
                            <div class="form-group">
                                <label for="signup_mail"><i class="fas fa-envelope"></i></label>
                                <input type="text" name="signup_mail" id="signup_mail" placeholder="Your Email" />
                            </div>
                            <div class="form-group">
                                <label for="signup_pass"><i class="fas fa-lock-alt"></i></label>
                                <input type="password" name="signup_pass" id="signup_pass" placeholder="Password" />
                            </div>
                            <div class="form-group">
                                <label for="signup_re_pass"><i class="far fa-lock re_lock"></i></label>
                                <input type="password" name="signup_re_pass" id="signup_re_pass" placeholder="Repeat your password" />
                            </div>
                            <div class="form-group not_it text-capitalize">
                                <select class="form-select text-capitalize" aria-label="Default select example" id="option_type" name="option_type" required>
                                    <option value="not" selected>Select the type</option>
                                    <!-- <option value="visitor">Visitor</option>
                                    <option value="staff">Staff</option>
                                    <option value="officer">Officer</option>
                                    <option value="administrator">Administrator</option>
                                    <option value="advocate">Advocate</option> -->
                                    <?php echo $selection_option_list; ?> 
                                </select>
                              </div>
                            <div class="form-group inlining">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term"  />
                                <label for="agree-term" class="label-agree-term">I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup_image">
                        <figure><img src="../assets/bulid_img/2.png" alt="sign up image"></figure>
                        <a href="" class="signup-image-link">I am already member</a>
                    </div>
                <!-- </div> -->
              </div>
</div>



</section>








        <script>
          $(document).ready(function () {

            $('.signup-image-link').click(function (e) { 
              e.preventDefault();
              location.href = '../index.php';
              
            });


            $('#register_form').keyup(function (e) { 
                
                $pass = $('#signup_pass').val();
                $re_pass = $('#signup_re_pass').val();
                if ($re_pass == $pass) {
                    
                    $(".re_lock").addClass("label_border");
                }else{
                   
                    $(".re_lock").removeClass("label_border");
                   
                }
                
                    
                
                            
    
                
            
            
            });
          });
        </script>