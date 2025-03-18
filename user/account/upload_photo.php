<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');
$data = getData();





    $file = $_FILES['profile_upload']['name'];
  $file_loc = $_FILES['profile_upload']['tmp_name'];
  $imageFileType = pathinfo($file,PATHINFO_EXTENSION);
  $folder=$_SERVER['DOCUMENT_ROOT']."/v3/assets/user_img/";
  $new_file_name = strtolower($file);
  $final_file0 =str_replace(' ','-',$new_file_name);
  $final_file = $data["name"].'_'.getName(5).'_'.$final_file0;
  $check_existing_email= $data["email"];
  $check_existing_query = "SELECT *  FROM users where email ='$check_existing_email';";
  $check_existing_result = mysqli_query($connect, $check_existing_query);
  $row2 = mysqli_fetch_assoc($check_existing_result);
  if (move_uploaded_file($file_loc,$folder.$final_file)) {
  
    $answer_upload_sql ="UPDATE users Set img ='user_img/$final_file' WHERE email= '$check_existing_email';";
    mysqli_query($connect, $answer_upload_sql);

    echo '1';
              
  }else{
    echo'0';
  }
  


?>




