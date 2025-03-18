<!-- Page Info: Signin + Signup -->


<?php

 session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/login.php');
// require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/signup.php');


session_regenerate_id(true);
// echo $_SERVER['DOCUMENT_ROOT'];

if ($_SESSION[pass_openssl_2_enc('status')] == pass_openssl_enc('online') && !empty($_SESSION[pass_openssl_2_enc('unique_id_php')])) {
    header('location:config/verification.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php') ?>
  
</head>
<body id="body_sign_in_out">
    
    <section id="sign_in_out">
        <!-- Sign in -->


        <div id="signin_section">

            <div class="container">
                
                <div class="signin_image">
                    <figure><img src="assets/bulid_img/3.jpg" class="signin_img_edit" alt="sign up image"></figure>
                    <a href="config/signup.php" class="signin-image-link" id="signup_btn">Create an account</a>
                </div>

                <div class="signin_form" style="justify-content: normal;">
                    
                    <h2 class="form-title">Prison Managment System</h2>

                    <form method="POST" class="register-form" id="login_form"  autocomplete="off">
                        <h5 class="text-center">Sign In</h5>
                        <div class="message_box">
                            <p class="text-danger fw-bold"><?php if (isset($_SESSION[pass_openssl_2_enc('msg_passer')])) { echo pass_openssl_2_dec($_SESSION[pass_openssl_2_enc('msg_passer')]);}?></p>
                            <!-- <p class="text-success ">Code Sent, again.</p> -->
                        </div>
                        <div class="form-group">
                            <label for="user_mail"><i class="fas fa-envelope"></i></label>
                            <input type="text" name="user_mail" id="user_mail" placeholder="Your Email"/>
                        </div>
                        <div class="form-group">
                            <label for="user_pass"><i class="fas fa-lock-alt"></i></label>
                            <input type="password" name="user_pass" id="user_pass" placeholder="Password"/>
                        </div>
                        
                        
                        <div class="form-group inlining d-none">
                            <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                            <label for="remember-me" class="label-agree-term">Remember me</label>
                        </div>
                        <div class="form-group form-button">
                            <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                        </div>
                    </form>
                    <div class='forgot_section'>
                        <a href="config/forgot_pass.php">Forgot Password?</a>
                    </div>

                    
                </div>

            </div>

        </div>

        
    </section>




    <script>
        $(document).ready(function () {

            // $('.forgot_section a').click(function (e) { 
            //     e.preventDefault();
            //     location.href = 'config/forgot_pass.php';
            // });
            // $('#signup_btn').click(function (e) { 
            //     e.preventDefault();
            //     location.href = 'config/signup.php';
            // });



            // $('#signup_btn').click(function (e) { 
            //     e.preventDefault();
            //     $.ajax({
            //         type: "POST",
            //         url: "config/signup.php",
            //         // data: "data",
            //         // dataType: "php",
            //         success: function (response) {
            //             $('#signin_section ').html(response);
            //         }
            //     });
                
            // });





            
            
                // $('#signup_section').hide();
                // $('#signup_btn').click(function (e) { 
                //     e.preventDefault();
                //     $('#signin_section').hide();
                //     $('#signup_section').show('fadeIn');
                //     sessionStorage.removeItem('<?php //echo pass_openssl_2_enc('msg_passer')?>');
                
                // });
                // $('.signup-image-link').click(function (e) { 
                //     e.preventDefault();
                //     $('#signup_section').hide();
                //     $('#signin_section').show('fadeIn');
                //     sessionStorage.removeItem("<?php //echo pass_openssl_2_enc('msg_passer')?>");
                
                
                // });

                


                
                // $('#register_form').keyup(function (e) { 
                
                //     $pass = $('#signup_pass').val();
                //     $re_pass = $('#signup_re_pass').val();
                //     if ($re_pass == $pass) {
                        
                //         $(".re_lock").addClass("label_border");
                //     }else{
                       
                //         $(".re_lock").removeClass("label_border");
                       
                //     }
                //     // var checking1 = $('#signup_full_name').val();
                //     // var checking2 = $('#signup_pass').val();
                //     // var checking3 = $('#signup_pass').val();
                //     // var checking4 = $('#signup_re_pass').val();
                //     // var checking5 = $('#agree-term').prop('checked');
                    

                //     // $('#signup').click(function (e) { 
                //     //     e.preventDefault();
                //     //     if ($re_pass !== $pass) {
                //     //         $('#signup').prop('disabled', true);
                //     //     }
                //     //     if (checking1 !=='' && checking2 !=='' && checking3 !=='' && checking4 !=='' && checking5 !=='' ) {
                //     //         // $('#signup').prop('disabled', false);
                            
                            
                //     //     }else{ 
                //     //         $(' #signup_section .message_box p').text('check all');
                //     //         // $('#signup').prop('disabled', true);
                //     //         // setTimeout(function(){
                //     //         //     $('.message_box p').text('');
                //     //         // }, 5000);
                //     //     }
                        
                //     // });
                        
                    
                                
        
                    
                
                
                // });

                
                
                
        // $('#signup').click(function (e) { 

        //     window.location.replace("verification.html");

        // });
        });
    </script>
    

</body>
</html>