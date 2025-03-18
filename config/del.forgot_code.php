<?php

include_once('functions.php');
include_once('connect.php');
include_once('resend_code.php');


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php') ?>
    
    
</head>
<body>
            <section id="forget_code_section">

            <div class="container">
                <h2>Code  Verification</h2>
                <p class="alert alert-success bg-soft-primary border-0 text-success ">We sent code to your email address [<span  class='text-decoration-underline tw-bold'><?php echo $_POST['email_id'];?></span>] for resetting your account </p>
                <div class="message_box">
                        <!-- <p class="text-danger ">Wrong entered code</p> -->
                        <p class="text-success "></p>
                </div>
                <form method="POST" class="verification_form" id="verification_form">
                    
                    <div class="form-group">
                        <label for="forgot_mail_code"><i class="fas fa-envelope"></i></label>
                        <input type="number" name="forgot_mail_code" id="forgot_mail_code" placeholder="Enter Code "/>
                    </div>
                
                    <div class="form-group form-button">
                        <input type="submit" name="forgot_mail_code_submit" id="forgot_mail_code_submit" class="form-submit" value="Confirm"/>
                    </div>
                </form>
                <div class="verification_resend_div">
                <p class="verification_text">Don't receive the code? <a href="#" class="verification_resend">Resend</a> </p>
                    
                </div>
            </div>

            </section>

            
            <script>
                $(document).ready(function () {

                    $('#forgot_mail_code_submit').click(function (e) { 
                        e.preventDefault();
                        $('.message_box p').text('vala');
                
                });
                    $('.verification_resend').click(function (e) { 
                                e.preventDefault();

                                var unique__id_jq= '<?php echo ''?>';
                                var email_id_jq= '<?php echo $email_php?>';

                                console.log(unique__id_jq);
                                console.log(email_id_jq);

                                $.ajax({
                                    type: "POST",
                                    url: "resend_code.php",
                                    data: {'unique__id': unique__id_jq,'email_id': email_id_jq},
                                    dataType: "text",
                                    success: function (response) {
                                        if (response =='done') {
                                        $('.message_box p').addClass('text-success').removeClass('text-danger');
                                        $('.message_box p').text('Code Sent, again.');
                                        } else {
                                        $('.message_box p').addClass('text-danger').removeClass('text-success');
                                        $('.message_box p').text('Something Wrong.');
                                        }
                                    }
                                });
                                
                setTimeout(function(){
                    $('.message_box p').text('');
                }, 5000);
                });
            });
           
            </script>
</body>

 
