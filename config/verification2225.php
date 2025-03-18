<?php


session_start();


require_once('functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/project/database/connect.php');
require_once('header.php');
require_once('login.php');
require_once('signup.php');

$updateemailphp = $_SESSION['mail'];
$updatepassphp = $_SESSION['pass'];




if ($_SESSION['block'] == 'yes' && ($_SESSION['start']) == 'online') {
  header('location:../index.php');
  $_SESSION['msg_passer']= 'blocked user';
}
elseif ( $_SESSION['block'] == 'no' && $_SESSION['verification'] == '1'   ) {
  if ($_SESSION['role'] == 'admin') {
    header('location:../admin');
  } elseif ($_SESSION['role'] == 'user') {
    header('location:../user');
  } 
};

echo '<pre>';
print_r($_SESSION);
echo '</pre>';

echo '<pre>';
print_r($_POST);
echo '</pre>';
echo $_POST['name'];





if (isset($_POST['verificationsubmit'])) {
  $value = $_POST['verificationcode'];
  $update = "SELECT  users.id, users.verification, users.login_attempt FROM users WHERE users.email = '".$updateemailphp."' and users.password = '".$updatepassphp."';";

  $checkresultupdate = mysqli_query($connect, $update);
  $checkrow = mysqli_fetch_array($checkresultupdate);
  if ($value == $checkrow['verification']) {

    $updatephp = "UPDATE users SET verification = '1' WHERE users.email = '".$updateemailphp."' and users.password = '".$updatepassphp."';";
    mysqli_query($connect, $updatephp);
    
    $_SESSION['verification'] = 1;
    $_SESSION['start']='online';

    if ($_SESSION['role'] == 'admin') {
      header('location:../admin');
    } elseif ($_SESSION['role'] == 'user') {
      header('location:../user');
    } 
    
  }else {

                  $id = $checkrow['id'];
                  $abc = $checkrow['login_attempt'];
                  $abc++;
                  $login_attempt_query="UPDATE users SET login_attempt = '$abc' WHERE users.id = $id;";
                  $resultsql_login_attempt =mysqli_query($connect, $login_attempt_query);
                  $_SESSION['login_attempt'] = $abc;
                  $result_row_sql = mysqli_fetch_array($resultsql_login_attempt);
                  $verificationmsg = 'Incorrect ';
                 

                  if ($_SESSION['login_attempt'] > 4) {
                    $attempt3sql ="UPDATE users SET block = 'yes' WHERE users.id = $id;";
                    $newsql=mysqli_query($connect, $attempt3sql);
                    $_SESSION['msg_passer']= 'user blocked <br> Attempt Number:'.$_SESSION['login_attempt'] ;

                    header("Refresh: 10;url=logout.php");
                  }elseif ($_SESSION['login_attempt'] == 4) {
                    $_SESSION['msg_passer']= 'hello bro check your mail <br> Attempt Number:'.$_SESSION['login_attempt'] .'code' .$_SESSION['verification'] ;
                    header("Refresh: 0");
                  }
                  else {
                    $_SESSION['msg_passer']= 'hello bro check your mail <br> Attempt Number:'.$_SESSION['login_attempt'] ;
                    header("Refresh: 0");
                  }
                      
                  // if ($resultrowsql['attempt'] == '5') {
                  //    # code...
                   
                    
                    


                  // $attempt3sql ="UPDATE users SET block = 'yes' WHERE users.id = $id;";
                  // $newsql=mysqli_query($connect, $attempt3sql);
                      
                  //     $_SESSION['msg_passer']= 'boltaci verfication kheke';
                  //     // header('location:index.php');
                  //  }
                   
                  //  else  {

                    
                   
        // 
  }



}



?>








<!doctype html>
<html lang="en">
  <head>
    <?php require_once('header.php'); ?>
    <title>Management</title>
  </head>
  <body>

  <!-- verification -->
  <div class="verfication row">
        <form method="POST" autocomplete="off" class="verificationform">
            <div class="outputpart" style="font-size: 12px;color: green;"><?php  echo $_SESSION['msg_passer'];?></div> 
            <div class="output"><?php if(isset($verificationmsg)){ echo $verificationmsg;} ?></div>
            <div class="output"><?php  echo $_SESSION['msg_passer'];?></div>
            <div class=""><?php if(isset($a)){ echo 'value:'.$a;} ?></div>
            <div class="outputkjjj"><?php  echo 'Name:' .$_SESSION['firstname']. $_SESSION['lastname']; ?></div>

            <label for="mail" class="">Email:</label>
            <?php echo $_SESSION['mail'] ?>
             
            <div>
            <label for="verificationcode" class="visually-hidden">Password</label>
            <input type="number" class="form-control" id="verificationcode" name="verificationcode" autocomplete="off">
            </div>
            <div>
                <input type="submit" name="verificationsubmit" id="verificationsubmit" class="btn btn-primary" value="Confirm identity">
                <a href="logout.php" class="btn btn-primary">logout</a>
            </div>
        </form>
   </div>
    
  </body>
</html>