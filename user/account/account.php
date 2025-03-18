<?php
define("PAGE_NAME","Account Settings");



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
if ($approved_status_comment !== '') {
  $readonly = 'readonly';
}

if (isset($_POST['change_pass'])) {
  $_SESSION[pass_openssl_2_enc('password_change_trigger')] = pass_openssl_2_enc('change mode for logged user');
  header('location:../config/verification.php');
}
$data = getData();


if (isset($_POST['submit'])) {
    $full_name_ac = mysqli_real_escape_string($connect, $_POST['full_name_ac']);
    $phone_ac = mysqli_real_escape_string($connect, $_POST['phone_ac']);
    $email_ac = mysqli_real_escape_string($connect, $_POST['email_ac']);
    $dob_ac = mysqli_real_escape_string($connect, $_POST['dob_ac']);
    $address_ac = mysqli_real_escape_string($connect, $_POST['address_ac']);
    $gender_ac = mysqli_real_escape_string($connect, $_POST['gender_ac']);
    $cities_ac = mysqli_real_escape_string($connect, $_POST['cities_ac']);
  
  $id =$data['unique_id_php'];

  if (isset($readonly)) {
    $data_1_sql = "UPDATE users SET full_name='$full_name_ac' WHERE unique_id_php ='$id';";
  }else{
    $data_1_sql = "UPDATE users SET full_name='$full_name_ac',email ='$email_ac' WHERE unique_id_php ='$id';";
  }
  mysqli_query($connect, $data_1_sql);

  // search
  $search_sql_users_meta = "SELECT *  FROM users_meta WHERE unique_id ='$id' ;";
  $result_search_sql_users_meta = mysqli_query($connect, $search_sql_users_meta);
  $num_rows_search_sql_users_meta = mysqli_num_rows($result_search_sql_users_meta);
  if($num_rows_search_sql_users_meta>0){
    $data_2_sql ="UPDATE users_meta SET phone_number='$phone_ac',gender='$gender_ac',address='$address_ac',city='$cities_ac',dob='$dob_ac' WHERE unique_id='$id';";
  }else{
    $data_2_sql ="INSERT INTO users_meta(unique_id, phone_number, gender, address, city, dob) VALUES ('$id','$phone_ac','$gender_ac','$address_ac','$cities_ac','$dob_ac');";
  }
 if(mysqli_query($connect, $data_2_sql)){
  echo'ok';
 }else{
  echo 'not';
 };
//  echo $data_1_sql ;
//  echo '<br>';
//  echo $data_2_sql ;

  header("Location: ".$_SERVER['PHP_SELF']);
  // header("Refresh:1");
}


$districts_sql ="SELECT * FROM districts ";
$selection_option_result = mysqli_query($connect, $districts_sql);
$districtslist='';
if(mysqli_num_rows($selection_option_result) > 0)
{
	
  
	while($list_row_option = mysqli_fetch_array($selection_option_result))
	{ 
    $val =$list_row_option['name'];
    if ($data['city'] == $val) {
      $districtslist .= '<option value="'.$val.'" selected>'.$val.'</option>';
    } else {
      $districtslist .= '<option value="'.$val.'">'.$val.'</option>';
    }
    
    
		
	}
	
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php') ?>
    <style>
        
       
        .rounded {
            border-radius: 5px !important;
        }
        .py-5 {
            padding-top: 3rem !important;
            padding-bottom: 3rem !important;
        }
        .px-4 {
            padding-right: 1.5rem !important;
            padding-left: 1.5rem !important;
        }
        .square {
            height: 250px;
            width: 250px;
            margin: auto;
            vertical-align: middle;
            border: 1px solid #e5dfe4;
            background-color: #fff;
            border-radius: 5px;
        }
        .text-secondary {
            --bs-text-opacity: 1;
            color: rgba(208, 212, 217, 0.5) !important;
        }
        .btn-success-soft {
            color: #28a745;
            background-color: rgba(40, 167, 69, 0.1);
        }
        .btn-danger-soft {
            color: #dc3545;
            background-color: rgba(220, 53, 69, 0.1);
        }
        .form-control {
            display: block;
            width: 100%;
            padding: 0.5rem 1rem;
            font-size: 0.9375rem;
            font-weight: 400;
            line-height: 1.6;
            color: #29292e;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #e5dfe4;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 5px;
            -webkit-transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
            transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        }
        
    
    </style>
  
</head>
<body>
  <?php include_once($_SERVER['DOCUMENT_ROOT'].'/v3/user/user_dashboard.php') ?>


  <div class="data_show personal">
    
  <div class="text-center text-danger p-2" style="font-weight: bold;">
      <?php 
      echo $approved_status_comment; 
      echo '<br>';
      if(isset($msg)){echo $msg;}

      ?>

  </div>

  <div class="container">
                <h1>Edit Profile</h1>
                <hr>
                <div class="alert alert-info alert-dismissable"></div>
              <form  method="POST" enctype="multipart/form-data">
                <div class="row" style="overflow: hidden;height: 60vh;overflow-y: scroll;">
                  <!-- left column -->
                  <div class="col-md-3 overflow-hidden">
                    <div class="text-center">
                      <div id="preview"><img src="<?php echo $user_img; ?>" class="avatar img-circle" width="250px" height="250px" alt="avatar"></div>
                      <h6>Upload Photo</h6>
                      
                      <input type="file" id="profile_upload" name="profile_upload" class="form-control"  accept="image/*">
                      <div>
                        
                        <button type="submit" class="mt-2 btn btn-warning update_photo">Upload</button>
                      </div>
                    </div>
                  </div>
                  
                  <!-- edit form column -->
                  <div class="col-md-9 personal-info">
                    
                    <h3>Personal info</h3>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Full name:</label>
                      <div class="col-lg-8">
                        <input class="form-control" type="text" name="full_name_ac" value="<?php echo $data['name'];?>" required>
                      </div>
                    </div>
                    
                    
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Phone:</label>
                      <div class="col-lg-8">
                        <input class="form-control " type="number" id="phone_ac" name="phone_ac" value="<?php echo $data['phone_number'];?>" onmousewheel="return false;" onkeydown="if(event.keyCode === 38 || event.keyCode === 40) return false;" required>
                        <div class="verify_cover phone_cover">
                          <a href="#" class="btn btn-primary p-lg-1 verify phone_verify">verify</a>
                          <div class="verify_under_phone verify_under">
                            <input class="form-control" type="text" id="code_phone_ac" value="" >
                            <a href="#" class="d-block btn pl-2 submit_code_phone">Submit</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Email:</label>
                      <div class="col-lg-8">
                        <input class="form-control " type="text" id="email_ac" name="email_ac" value="<?php echo $data['email'];?>" <?php echo isset($readonly)? $readonly:""?> required>
                        <div class="verify_cover email_cover">
                          <a href="#" class="btn btn-primary p-lg-1 verify email_verify">verify</a>
                          <div class="verify_under_email verify_under">
                            <input class="form-control" type="text" value="" id="code_email_ac" name="code_email_ac">
                            <a href="#" class="d-block btn pl-2 submit_code_email">Submit</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="form-group ">
                      <label class="col-lg-3 control-label">Gender</label>
                      <div class="form-inline" style="display: flex;flex-direction: row;">
                        <div class="form-check  pl-1" style="margin-right: 10px;">
                          <input class="form-check-input" type="radio" name="gender_ac" id="male" value="male"  required  >
                          <label class="form-check-label" for="male">
                            Male
                          </label>
                        </div>
                        <div class="form-check  pl-1" style="margin-right: 10px;">
                          <input class="form-check-input" type="radio" name="gender_ac" id="female" value="female" required >
                          <label class="form-check-label" for="female">
                            Female
                          </label>
                        </div>
                        <div class="form-check pl-1" style="margin-right: 10px;">
                          <input class="form-check-input" type="radio" name="gender_ac" id="other" value="other" required >
                          <label class="form-check-label" for="other">
                            Other
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Date of birth</label>
                      <div class="col-lg-8">
                        <input class="form-control" type="date" id="dob_ac" name="dob_ac"  value="<?php echo $data['dob'];?>" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Address</label>
                      <div class="col-lg-8">
                        <input class="form-control" type="text"  value="<?php echo $data['address'];?>" id="address_ac" name="address_ac">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Districts:</label>
                      <div class="col-lg-8">
                      <select id="cities_ac" name="cities_ac" class="form-control" required>
                        <option value="">Select a district</option>
                        <?php echo $districtslist;?>
                      </select>
                      </div>
                    </div>
                    <div class="form-group mt-2 pt-2">
                      <label class="col-md-3 control-label"></label>
                      <div class="col-md-8">
                        <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Save Changes">
                        <span></span>
                        <input type="submit" name="cancel" class="btn btn-warning" value="Cancel">
                      </div>
                    </div>
                    
                    
                  </div>
                </div>
              </form>
            </div>
            <hr>  

  

</div>
</section>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

      <script>
      $(document).ready(function () {
        // var cities_ac = [
        //   'Dhaka',
        //   'Chittagong',
        //   'Khulna',
        //   'Rajshahi',
        //   'Barisal',
        //   'Sylhet',
        //   'Rangpur',
        //   'Comilla',
        //   'Mymensingh',
        //   'Narayanganj',
        //   'Tangail',
        //   'Jamalpur',
        //   'Sirajganj',
        //   'Narsingdi',
        //   'Gazipur',
        //   'Pabna',
        //   'Jessore',
        //   'Kushtia',
        //   'Bogra',
        //   'Dinajpur'
        // ];
        
        // // Loop through the cities_ac array and add option tags to the select element
        // for (var i = 0; i < cities_ac.length; i++) {
        //   var city = cities_ac[i];
        //   $('#cities_ac').append('<option value="' + city + '">' + city + '</option>');
        // }
          var gender_val = '<?php echo $data['gender'];?>';
          if(gender_val == 'male'){
                $('#male').prop('checked', true);
                $('#female').prop('checked', false);
                $('#other').prop('checked', false);
          }else if(gender_val == 'female'){
                $('#male').prop('checked', false);
                $('#female').prop('checked', true);
                $('#other').prop('checked', false);
          }else if(gender_val == 'other'){
                $('#male').prop('checked', false);
                $('#female').prop('checked', false);
                $('#other').prop('checked', true);
          }
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
                url: "upload_photo.php",
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
        setTimeout(function() {$('.alert').fadeOut();}, 5000);



        
        
        
        $('.verify').hide();
        $('.verify_under_phone').hide();
        $('.verify_under_email').hide();

        var id = '<?php echo pass_openssl_2_enc($data['unique_id_php'])?>';

        // email----

        var old_email_ac = $('#email_ac').val();
        $('#email_ac').change(function (e) {

          $('.email_verify').text('Verify');

          var check_value_verify = $(this).val();
          check_value_verify = check_value_verify.replace(/\s+/g, '');;
          console.log(check_value_verify);
          if (check_value_verify =='') {
            $('#email_ac').addClass('is-invalid');
            $('#email_ac').removeClass('is-valid');
            $('.email_verify').hide();
          }else if(old_email_ac == check_value_verify){
            $('.email_verify').hide();
            $('#email_ac').removeClass('is-invalid');
            $('#email_ac').removeClass('is-valid');
          }else{
            $('.email_verify').show();
            $('#email_ac').removeClass('is-invalid');
            $('#submit').prop('disabled', true);
          }
          
          $('.email_verify').click(function (e) { 
            
            console.log(check_value_verify);
            e.preventDefault();
            $.ajax({
              type: "POST",
              url: "edit_acc.php",
              data: {'sub_value': check_value_verify, 'verify': 'send_code' , 'sub': 'email', 'id' : id},
              dataType: "text",
              beforeSend: function() {
                        
                $('.email_verify').text('sent code');
                    },
              success: function (response) {
                if(response == 00){
                        $('.alert').text('Already exist');
                        
                        $('.alert').removeClass('alert-success');
                        $('.alert').addClass('alert-danger');
                        $('.alert').show();
                        setTimeout(function() {$('.alert').fadeOut();}, 2000);
                        // location.reload();
                        
                }else{
                  $('.email_verify').text(response);
                  $('.verify_under_email').show();
                  $('.submit_code_email').click(function (e) { 

                    e.preventDefault();
                    var email_code = $('#code_email_ac').val();
                    $.ajax({
                      type: "POST",
                      url: "edit_acc.php",
                      data: {'sub_value': check_value_verify, 'sub_code': email_code, 'verify': 'check_code' , 'sub': 'email', 'id' : id},
                      dataType: "text",
                      success: function (dek) {
                        console.log(dek);
                        
                        if (dek == 0) {
                          $('.alert').text('invalid code');
                          $('.alert').removeClass('alert-success');
                          $('.alert').addClass('alert-danger');
                          $('.alert').show();
                          setTimeout(function() {$('.alert').fadeOut();}, 5000);

                        
                        }else{
                          $('.email_cover').hide();
                          $('#email_ac').removeClass('is-invalid');
                          $('#email_ac').addClass('is-valid');
                          $('#email_ac').val(check_value_verify);
                          $('#submit').prop('disabled', false);
                        }
                      }
                    });
                    
                  });
                }
                


              }
            });
          });
        });





// phone
        var old_phone_ac = $('#phone_ac').val();
        $('#phone_ac').change(function (e) {

          $('.phone_verify').text('Verify');

          var check_value_verify = $(this).val();
          check_value_verify = check_value_verify.replace(/\s+/g, '');;
          console.log(check_value_verify);
          if (check_value_verify =='') {
            $('#phone_ac').addClass('is-invalid');
            $('#phone_ac').removeClass('is-valid');
            $('.phone_verify').hide();
          }else if(old_email_ac == check_value_verify){
            $('.phone_verify').hide();
            $('#phone_ac').removeClass('is-invalid');
            $('#phone_ac').removeClass('is-valid');
          }else{
            $('.phone_verify ').show();
            $('#phone_ac').removeClass('is-invalid');
            $('#submit').prop('disabled', true);
          }
          
          $('.phone_verify').click(function (e) { 
            
            console.log(check_value_verify);
            e.preventDefault();
            $.ajax({
              type: "POST",
              url: "edit_acc.php",
              data: {'sub_value': check_value_verify, 'verify': 'send_code' , 'sub': 'phone', 'id' : id},
              dataType: "text",
              beforeSend: function() {
                        
                $('.phone_verify').text('sent code');
                    },
              success: function (response) {
                if(response == 00){
                        $('.alert').text('Already exist');
                        
                        $('.alert').removeClass('alert-success');
                        $('.alert').addClass('alert-danger');
                        $('.alert').show();
                        setTimeout(function() {$('.alert').fadeOut();}, 2000);
                        // location.reload();
                        
                }else{
                  $('.phone_verify').text(response);
                  $('.verify_under_phone').show();
                  $('.submit_code_phone').click(function (e) { 

                    e.preventDefault();
                    var phone_code = $('#code_phone_ac').val();
                    $.ajax({
                      type: "POST",
                      url: "edit_acc.php",
                      data: {'sub_value': check_value_verify, 'sub_code': phone_code, 'verify': 'check_code' , 'sub': 'phone', 'id' : id},
                      dataType: "text",
                      success: function (dek) {
                        console.log(dek);
                        
                        if (dek == 0) {
                          $('.alert').text('invalid code');
                          $('.alert').removeClass('alert-success');
                          $('.alert').addClass('alert-danger');
                          $('.alert').show();
                          setTimeout(function() {$('.alert').fadeOut();}, 5000);

                        
                        }else{
                          $('.phone_cover').hide();
                          $('#phone_ac').removeClass('is-invalid');
                          $('#phone_ac').addClass('is-valid');
                          $('#phone_ac').val(check_value_verify);
                          $('#submit').prop('disabled', false);
                        }
                      }
                    });
                    
                  });
                }
                


              }
            });
          });
        });
// submit
// $('#submit').submit(function (e) { 
  
//   var formData = $("form").serialize();
//   console.log(formData);
//   e.preventDefault();
  
// });
          
      });

    </script>
</body>
</html>