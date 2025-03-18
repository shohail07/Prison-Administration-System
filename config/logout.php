<?php 

    // session_start();
    include_once('functions.php');
    include_once('connect.php');
    include_once('login.php');
    // include_once('signup.php');
    
    session_destroy();
    session_unset();
    session_destroy();
    // unset($_COOKIE['keep']);
    // unset($_COOKIE['keepuser']);
    // setcookie('keep', $hoyse , time() - 60*60*24*365, "/");
    // setcookie('keepuser', $user , time() - 60*60*24*365, "/");
    

    header('location:../index.php');
    
    
  
  

?>