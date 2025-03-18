<!-- Sign up -->
<div id="signup_section">
            <div class="container">
                <!-- <div class="signup-content"> -->
                    <div class="signup_form">
                        <h2 class="form-title">Sign up</h2>
                        <form method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" class="register_form" id="register_form" autocomplete="off">
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
                        <figure><img src="assets/bulid_img/2.png" alt="sing up image"></figure>
                        <a href="#" class="signup-image-link">I am already member</a>
                    </div>
                <!-- </div> -->
            </div>
        </div>








        <script>
          $(document).ready(function () {
            $('#register_form').keyup(function (e) { 
                
                $pass = $('#signup_pass').val();
                $re_pass = $('#signup_re_pass').val();
                if ($re_pass == $pass) {
                    
                    $(".re_lock").addClass("label_border");
                }else{
                   
                    $(".re_lock").removeClass("label_border");
                   
                }
                // var checking1 = $('#signup_full_name').val();
                // var checking2 = $('#signup_pass').val();
                // var checking3 = $('#signup_pass').val();
                // var checking4 = $('#signup_re_pass').val();
                // var checking5 = $('#agree-term').prop('checked');
                

                // $('#signup').click(function (e) { 
                //     e.preventDefault();
                //     if ($re_pass !== $pass) {
                //         $('#signup').prop('disabled', true);
                //     }
                //     if (checking1 !=='' && checking2 !=='' && checking3 !=='' && checking4 !=='' && checking5 !=='' ) {
                //         // $('#signup').prop('disabled', false);
                        
                        
                //     }else{ 
                //         $(' #signup_section .message_box p').text('check all');
                //         // $('#signup').prop('disabled', true);
                //         // setTimeout(function(){
                //         //     $('.message_box p').text('');
                //         // }, 5000);
                //     }
                    
                // });
                    
                
                            
    
                
            
            
            });
          });
        </script>