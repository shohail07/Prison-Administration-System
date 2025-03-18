<?php
//  session_start();


include_once('functions.php');
include_once('connect.php');
include_once('login.php');


if ($_SESSION[pass_openssl_2_enc('status')] !== pass_openssl_enc('online')) {
  header('location:../index.php');
  $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc("Don't try again!!");
}

session_regenerate_id(true);


$email_php = pass_openssl_dec($_SESSION[pass_openssl_2_enc('email')]);
$unique__php = pass_openssl_dec($_SESSION[pass_openssl_2_enc('unique_id_php')]);

$firstsql = "SELECT *  FROM users WHERE users.unique_id_php ='$unique__php' and users.email ='$email_php';";   
$result = mysqli_query($connect, $firstsql);
$row = mysqli_fetch_array($result);



if ($row['block'] == 'yes') {
  header('location:../index.php');
  $_SESSION[pass_openssl_2_enc('msg_passer')]=pass_openssl_2_enc('user blocked');
}
elseif ( $row['block'] == 'no' && $row['verification'] == '1'   ) {
  if (isset($_SESSION[pass_openssl_2_enc('password_change_trigger')])) {
    header('location:change_pass.php');
  }else{
    
      header('location:../user');
    
  }
};

unset($_SESSION[pass_openssl_2_enc('msg_passer')]);



if (isset($_POST['verification_confirm'])) {
  $value = $_POST['verification_code'];
  $update = "SELECT  users.unique_id_php, users.role, users.verification, users.login_attempt FROM users WHERE users.email = '".$email_php."' and users.unique_id_php = '".$unique__php."';";

  $checkresultupdate = mysqli_query($connect, $update);
  $checkrow = mysqli_fetch_array($checkresultupdate);
  if ($value == $checkrow['verification']) {
    
    $updatephp = "UPDATE users SET verification = '1' WHERE users.email = '".$email_php."' and users.unique_id_php = '".$unique__php."';";
    mysqli_query($connect, $updatephp);

    $login_attempt_query="UPDATE users SET login_attempt = '0' WHERE users.email = '".$email_php."' and users.unique_id_php = '".$unique__php."';";
    $resultsql_login_attempt =mysqli_query($connect, $login_attempt_query);
    
    $_SESSION[pass_openssl_2_enc('status')]=pass_openssl_enc('online');
    $_SESSION[pass_openssl_2_enc('verification')]= pass_openssl_enc('1');
    $_SESSION[pass_openssl_2_enc('login_attempt')]= pass_openssl_enc('0');

    if (isset($_SESSION[pass_openssl_2_enc('password_change_trigger')])) {
      header('location:change_pass.php');
    }else{
      
        header('location:../user');
      
    }
    
  }else {
                    

                  $id = $checkrow['unique_id_php'];
                  $abc = $checkrow['login_attempt'];
                  
                  $abc++;
                  $login_attempt_query="UPDATE users SET login_attempt = '$abc' WHERE users.unique_id_php = '$id';";
                  $resultsql_login_attempt =mysqli_query($connect, $login_attempt_query);

                  $_SESSION[pass_openssl_2_enc('login_attempt')]= pass_openssl_enc($abc);
                  $result_row_sql = mysqli_fetch_array($resultsql_login_attempt);
                  $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc("Incorrect Code");
                 
                 

                  if ($checkrow['login_attempt'] > 4) {
                    $attempt3sql ="UPDATE users SET block = 'yes' WHERE users.unique_id_php = '$id';";
                    $newsql=mysqli_query($connect, $attempt3sql);
                    $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('user blocked ; Attempt Number:'.$checkrow['login_attempt']);

                    header("location:logout.php");
                  }elseif ($checkrow['login_attempt'] == 4) {
                    $_SESSION[pass_openssl_2_enc('msg_passer')]= pass_openssl_2_enc('Last Call before being blocked.;');
                    // header("Refresh: 0");
                  }
               
  }



}

?>




<!DOCTYPE html>
<html lang="en">
<head>
<?php require_once('header.php') ?>
</head>
<body>

    <section id="verification_section">

        <div class="container">
            <h2>Verification</h2>
            <p>Enter the code, we just send on your email </p>
            <p>[<?php  echo $email_php;?>]</p>
            <form method="POST" class="verification_form" id="verification_form">
                <div class="message_box">
                  <img class='loader' src="Infinity-1s-200px.gif" >
                    <p class='<?php if (isset($_SESSION[pass_openssl_2_enc('msg_passer')])) { echo 'text-danger';}?> '><?php  echo pass_openssl_2_dec($_SESSION[pass_openssl_2_enc('msg_passer')]);?></p>
                </div>
                <div class="form-group">
                    <label for="verification_code"><i class="fas fa-key"></i></label>
                    <input type="text" name="verification_code" id="verification_code" placeholder="Your Verification Code"/>
                </div>
               
                <div class="form-group form-button">
                    <input type="submit" name="verification_confirm" id="verification_confirm" class="form-submit" value="Confirm"/>
                </div>
            </form>
            <div class="verification_resend_div">
               <p class="verification_text">Don't receive the code? <a href="#" class="verification_resend">Resend</a> </p>
               <br>
               <p class="verification_text"> <a href="logout.php" class="text-center">Logout</a> </p>

                
            </div>
        </div>

    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
          $('.loader').hide();
            $('.verification_resend').click(function (e) { 
                // e.preventDefault();

                var unique__id_jq= '<?php echo $unique__php?>';
                var email_id_jq= '<?php echo $email_php?>';
                console.log(email_id_jq);
                console.log(unique__id_jq);


                

                $.ajax({
                  type: "POST",
                  url: "resend_code.php",
                  data: {'unique__id': unique__id_jq,'email_id': email_id_jq},
                  dataType: "text",
                  beforeSend: function() {
                        
                        $('.message_box p').text('');
                        $('.loader').show();
                  },
                  success: function (response) {
                    response = response.trim();
                    $('.loader').hide();
                    if (response =='done' ) {
                      $('.message_box p').addClass('text-success').removeClass('text-danger');
                      $('.message_box p').text('Code Sent, again.');
                    } else {
                      
                      $('.message_box p').addClass('text-danger').removeClass('text-success');
                      $('.message_box p').text('Something Wrong.');
                      
                    }
                    console.log(response);
                  }
                });
                                
                setTimeout(function(){
                    $('.message_box p').text('');
                }, 5000);
            });
            
        });
    </script>

    
</body>
</html>