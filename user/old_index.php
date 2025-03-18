<?php

session_start();
session_regenerate_id(true);

require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php');


if ($_SESSION[pass_openssl_2_enc('status')] == pass_openssl_enc('online') && !empty($_SESSION[pass_openssl_2_enc('unique_id_php')])) {
  $email_php = pass_openssl_dec($_SESSION[pass_openssl_2_enc('email')]);
  $unique__php = pass_openssl_dec($_SESSION[pass_openssl_2_enc('unique_id_php')]);

  $firstsql = "SELECT *  FROM users WHERE users.unique_id_php ='$unique__php' and users.email ='$email_php';";   
  $result = mysqli_query($connect, $firstsql);
  $row = mysqli_fetch_array($result);

  if ($row['block'] == 'yes') {
      header('location:../index.php');
      $_SESSION[pass_openssl_2_enc('msg_passer')]=pass_openssl_2_enc('user blocked');
    }elseif ( $row['block'] == 'no') {
      if( $row['verification'] !== '1' ){
        header('location:../config/verification.php');
      }else{
        if ($row['role'] == 'admin') {
         
        }elseif ($row['role'] == 'user') {
          header('location:../user');
        } 
      }
      
    };

  
}else{
  header('location:logout.php');
}



if (isset($_POST['change_pass'])) {
  $_SESSION[pass_openssl_2_enc('password_change_trigger')] = pass_openssl_2_enc('change mode for logged user');
  header('location:../config/verification.php');
}


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php') ?>
  
</head>
<body>
        
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#" style="text-transform: capitalize;"><?php echo$row['role'];?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">


          <!--  -->
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="#">dds</a>
            </li>
            <!--  -->
            
            
          </ul>
          <form class="d-flex">
                <li class="nav-item dropdown" style="list-style-type: none;">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo$row['full_name'];?>
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style='margin-left: -80px;'>
                    <li><a class="dropdown-item" href="#"> <form action="" method="post"><input type="submit" class='btn btn-primary' name='change_pass' value="Change Password"></form></a></li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    
                  </ul>
                </li>
            
          </form>
        </div>
      </div>
    </nav>

    <div class="p-3">
      <p> <?php 
      
     if ($row['approved']== 'need') {
      echo 'You are not allow to access.';
      echo "<br>";
      echo "After the Administration approve your profile.";
     } 
      
      ?></p>
      
    </div>


    <script>
    </script>
    

</body>
</html>