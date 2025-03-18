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

if (isset($_POST['change_pass'])) {
  $_SESSION[pass_openssl_2_enc('password_change_trigger')] = pass_openssl_2_enc('change mode for logged user');
  header('location:../config/verification.php');
}
$data = getData();

// output the name data



if(isset($_POST['submit'])){
  $file = $_FILES['profile_upload']['name'];
  $file_loc = $_FILES['profile_upload']['tmp_name'];
  $imageFileType = pathinfo($file,PATHINFO_EXTENSION);
  $folder=$_SERVER['DOCUMENT_ROOT']."/v3/assets/user_img/";


  
  if(!empty($file_loc)){
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
      $msg= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }else{
      $new_file_name = strtolower($file);
      $final_file0 =str_replace(' ','-',$new_file_name);
      $final_file = $data["name"].'_'.getName(5).'_'.$final_file0;
      $check_existing_email= $data["name"];
      $check_existing_query = "SELECT *  FROM users where email ='$check_existing_email';";
      $check_existing_result = mysqli_query($connect, $check_existing_query);
      $row2 = mysqli_fetch_assoc($check_existing_result);
      
  
      // if(mysqli_num_rows($check_existing_result) > 0){
      //   if($row2["img"] === null){
      //     $update_trigger = 0;
      //   }else{
      //     rename($folder.$row2["img"],$folder.'delete_'.$row2["img"] );
      //     $update_trigger = 1;
      //   }
          
  
      // }else{
      //   $update_trigger = 0;
      // }
  
      if (move_uploaded_file($file_loc,$folder.$final_file)) {
        // if ($update_trigger !== 1) {
        //   $answer_upload_sql ="INSERT INTO users(img) VALUES ('user_img/.$final_file');";
          
        // }else{
        //   $answer_upload_sql ="UPDATE users Set img ='$final_file' WHERE email= '$check_existing_email';";
  
        // }
        $answer_upload_sql ="UPDATE users Set img ='user_img/$final_file' WHERE email= '$check_existing_email';";
        mysqli_query($connect, $answer_upload_sql);
  
  
                  
      }else{
        $msg= 'tur upload hoy nai';
      }
      
    }
  }else{
    $msg = 'NO change';
  }
  }
 
  
if (isset($_POST['cancel'])) {
  
  $file = $_FILES['profile_upload']['name'];
  $file_loc = $_FILES['profile_upload']['tmp_name'];
  
  if (file_exists($file_loc)) {
    header("Location: ".$_SERVER['PHP_SELF']);
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


  <div class="data_show">
    
  <div class="text-center text-danger p-2" style="font-weight: bold;">
      <?php 
      echo $approved_status_comment; 
      echo '<br>';
      if(isset($msg)){echo $msg;}

      ?>

    </div>

    <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h3>My Profile</h3>
                            <hr style="color: #fff;">
                        </div>
                    </div>
                    <form method="POST" class="row" enctype="multipart/form-data">
                        <div class="row col-md-6">
                            <div class="col-md-12">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" placeholder="" aria-label="" value="<?php echo $data["name"];?>" readonly>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Phone Number</label>
                                <input type="number" class="form-control" placeholder="" aria-label="First name" value="<?php echo $data["phone"];?>" readonly>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" placeholder="" aria-label="First name" value="<?php echo $data["email"];?>" readonly>
                            </div> 
                        </div> 
                        <div class="row col-md-6">
                            
                            <div class="col-md-12">
                                <h4 class="text-center">Upload your profile photo</h4>
                                <div class="square position-relative display-2 mb-3">
                                    <img src="<?php echo $user_img; ?>" alt="" width="100%" height="100%" id="preview">
                                </div>
                                <div class="text-center">
                                    <input type="file" id="profile_upload" name="profile_upload" hidden="" accept="image/*">
                                    <label class="btn btn-success-soft btn-block text-center" for="profile_upload">Upload</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                            <input type="submit" value="Update" name='submit'  class="btn btn-primary">
                            <input type="submit" value="Cancel" name='cancel'  class="btn btn-danger">
                                
                                
                            </div>
                        </div>
                    </form>
               </div>

    </div>

</div>
</section>
<script>
        // Preview the selected image
        const fileInput = document.getElementById('profile_upload');
        const preview = document.getElementById('preview');
        fileInput.addEventListener('change', () => {
          const file = fileInput.files[0];
          const reader = new FileReader();
          reader.addEventListener('load', () => {
            preview.src = reader.result;
          });
          reader.readAsDataURL(file);
        });
      </script>

</body>
</html>