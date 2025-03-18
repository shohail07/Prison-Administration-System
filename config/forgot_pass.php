<?php


session_start();
session_regenerate_id(true);
include_once('functions.php');
include_once('connect.php');
// if (isset($_SESSION[pass_openssl_2_enc('status')]) ) {
//     header('location:verification.php');
//     // $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc("Don't try again!!");
//   }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php') ?>
    
    
</head>
<body> 

    <section id="forgot_section">

        <div class="container">
            <h2>Password Reset</h2>
            <p class="alert alert-success bg-soft-primary border-0 text-success ">Enter your email address to reset your password. </p>
            <div class="message_box">
                <img class='loader' src="Infinity-1s-200px.gif" >
                <p class="text-danger fw-bold"></p>
          
            </div>
            <form method="POST" class="verification_form" id="verification_form">
                
                <div class="form-group">
                    <label for="forgot_mail"><i class="fas fa-envelope"></i></label>
                    <input type="text" name="forgot_mail" id="forgot_mail" placeholder="Your Email "/>
                </div>
               
                <div class="form-group form-button">
                    <input type="submit" name="forgot_mail_send" id="forgot_mail_send" class="form-submit" value="Reset Password"/> 
                    
                    
                </div>
            </form>
            <div class="sign_In_Up_path">
               <p class="sign_In_Up_path_text"><a href="" id='signin_btn'>Sign In</a> / <a href="" id='signup_btn'>Sign Up</a>  </p>
                
            </div>
        </div>

    </section>
    
    <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script>

 
    <script>
        $(document).ready(function () {
            $('#signup_btn').click(function (e) { 
                e.preventDefault();
                location.href = 'signup.php';
            });
            $('#signin_btn').click(function (e) { 
                e.preventDefault();
                location.href = '../index.php';
            });
            $('.loader').hide();

            $('#forgot_mail_send').click(function (e) { 

                var email_id_jq = $('#forgot_mail').val();
                var unique__id_jq= '<?php echo ''?>';
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "findme.php",
                    data: {'email_id': email_id_jq},
                    dataType: "text",
                    beforeSend: function() {
                        
                        $('.message_box p').text('');
                        $('.loader').show();
                    },
                    success: function (response) {
                        $('.loader').hide();
                        response = response.trim();
                        if (response =='found') {

                            $(location).attr('href','verification.php');
                            // $.ajax({
                            //     type: "POST",
                            //     url: "verification.php",
                            //     data: {'unique__id': unique__id_jq,'email_id': email_id_jq},
                            //     dataType: "html",
                            //     success: function (response2) {
                            //         $('#forgot_section').html(response2);
                            //     }
                            // });
                        }else{
                            $('.message_box p').text('User Not Exist');
                        }
                        console.log(response);
                    }
                });
                
            });
            
        });
    </script>
</body>
</html>