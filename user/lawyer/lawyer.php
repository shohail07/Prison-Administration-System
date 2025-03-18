<?php
define("PAGE_NAME","Lawyer Management");



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


// inbox
$data = getData();
$reciver = $data['unique_id_php'];

$sql_inbox= "SELECT * FROM msg WHERE reciver='$reciver' ORDER BY time DESC;";
$sql_inbox_result = mysqli_query($connect, $sql_inbox);
$num = mysqli_num_rows($sql_inbox_result);
// $output_list='';
if(mysqli_num_rows($sql_inbox_result) > 0)
{
	$output_list='';
  $i =0;
	while($list_row = mysqli_fetch_array($sql_inbox_result))
	{ $i++;
    if($list_row["seen"] !== "0"){
      $see = 'seen';
    }else{
      $see = 'see';
    }
		$output_list .= '
			<tr>
				<td>'.$i.'</td>
				<td>'.$list_row["text"].'</td>
				<td>'.$list_row["time"].'</td>				
				<td><a href="#" seeid="'.$list_row["id"].' seeid="'.$reciver.'">'.$see.'</a></td>				
			</tr>
		';
	}
	// echo $output_list;
}else{
  $output_list='<td colspan="4">Empty Inbox</td>';
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php') ?>
  
</head>
<body>
  <?php include_once($_SERVER['DOCUMENT_ROOT'].'/v3/user/user_dashboard.php') ?>


  <div class="data_show">
    
    <div class="text-center text-danger"style="font-weight: bold;">
      <?php echo $approved_status_comment; ?>
    </div>

    <div class="row">
      
      <div class="col-sm-5">
      <h2 class="text-center">Inbox</h2>
      <table class="table table-bordered table-responsive-md list_table" id="myTable">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Text</th>
                              <th scope="col">Time</th>
                              <th scope="col">Seen</th>
                              <!-- <th scope="col">Edit</th> -->


                            </tr>
                          </thead>
                          <tbody>
                            <?php echo $output_list; ?> 
                          
                          </tbody>
      </div>
      
    </div>
    
    </div>

</div>
</section>

</body>
</html>