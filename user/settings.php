<?php
define("PAGE_NAME","Privacy and Security");



session_start();
session_regenerate_id(true);

// print_r($_SESSION);


require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php');

// if (!userloggedin()) {
//   header('location:logout.php');
// }
if ($_SESSION[pass_openssl_2_enc('status')] !== pass_openssl_enc('online')) {
  header('location:../index.php');
}
checksame();
$approved_status_comment= approve();

if (isset($_POST['change_pass'])) {
  $_SESSION[pass_openssl_2_enc('password_change_trigger')] = pass_openssl_2_enc('change mode for logged user');
  header('location:../config/verification.php');
}
$data = getData();





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php') ?>
   
</head>
<body>
  <?php include_once($_SERVER['DOCUMENT_ROOT'].'/v3/user/user_dashboard.php') ?>


  <div class="data_show">
    
  <div class="text-center text-danger p-2" style="font-weight: bold;">
      <?php 
      echo $approved_status_comment; 
      echo '<br>';
      if(isset($msg)){echo $msg;}

      ?>
      <style>
        .box_section h4{
          color: black;
          background-color: #777;
          padding: 10px;
          text-align: left;
          font-weight: bold;
          text-transform: capitalize;
        }
        .box_section{
          height: 25vh;
        }
      </style>
      <div class="box_section">
        <h4>Password change section</h4>
        <form method="POST">
        <input type="submit" class="btn btn-primary" name='change_pass' value="Change your password">
        </form>
      </div>
      <div class="box_section">
      <div class="alert alert-info alert-dismissable"></div>
        <h4>Upload your Document</h4>
        <!-- <form method="POST">
        <input type="submit" class="btn btn-primary" name='change_pass' value="Change your password">
        </form> -->
                    <div class="row text-center">
                    <div class="col-md-6">
                      <div id="preview"><img src="<?php echo $user_doc; ?>" class="avatar img-circle" width="250px" height="250px" alt="avatar"></div>
                      <h6>Upload your document</h6>
                    </div>
                    <div class="col-md-3 d-flex align-items-center">
                      <div>
                        <input type="file" id="profile_upload" name="profile_upload" class="form-control"  accept="image/*">
                        <div>
                          <button type="submit" class="mt-2 btn btn-warning update_photo">Upload</button>
                        </div>
                      </div>
                    </div>
                    </div>
      </div>

    </div>

    

</div>
</section>

      
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  $(document).ready(function () {
    $('.update_photo').hide();
        $("#profile_upload").change(function (e) {
          var file = this.files[0];
          console.log(file);
          myGlobalVariable = file;
          var reader = new FileReader();
          console.log(reader);
          reader.onload = function(event) {
            var img = $('<img>').attr('src', event.target.result).attr('class', 'avatar img-circle').attr('width', '250px').attr('height', '250px').attr('alt', 'avatar');
            
            $('#preview').html(img);
            $('.update_photo').show();
            
          };
          
          // Read the file as a data URL
          reader.readAsDataURL(file); 
          e.preventDefault();
          
        });


        $('.alert').hide();


        $('.update_photo').click(function (e) { 
          e.preventDefault();
          var file= myGlobalVariable;
              console.log(file);
              var formData = new FormData();
              formData.append('profile_upload', file);
              $.ajax({
                type: "POST",
                url: "config/upload_photo.php",
                data: formData,
                dataType: "text",
                contentType: false,
                processData: false,
                success: function (response) {
                  console.log(response);
                  if (response == 1) {
                    // location.reload();
                    $('.alert').text(' Photo Uploaded');
                    $('.alert').addClass('alert-success');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').show();
                    setTimeout(function() {$('.alert').fadeOut();}, 10000);
                    // $('#menus').load('../user_dashboard.php');
                    location.reload();
                  } else {
                    $('.alert').text('Photo not Uploaded');
                    $('.alert').removeClass('alert-success');
                    $('.alert').addClass('alert-danger');
                    $('.alert').show();
                    setTimeout(function() {$('.alert').fadeOut();}, 10000);
                  }
                }
              });
              
        });
  });
</script>
</body>
</html>