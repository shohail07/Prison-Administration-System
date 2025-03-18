<?php


require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');
// require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php');


$id =mysqli_real_escape_string($connect,$_POST['id']);
$pass_id = pass_openssl_2_dec($id);


if ($_POST['update'] == 'yes') {
  $audience =mysqli_real_escape_string($connect,$_POST['audience']);
  
    $firstsql =  "UPDATE crime SET  status='$audience' WHERE id='$pass_id' ;"; 
        $result = mysqli_query($connect, $firstsql);
        echo 'ok';
      
}else{
  $firstsql = "SELECT *  FROM crime WHERE id ='$pass_id' ;";   
        $result = mysqli_query($connect, $firstsql);
        $row = mysqli_fetch_array($result);

        echo json_encode(array(
          
          'rule_name' => $row['value'],
          'audience' => $row['status']
      ));

}






?>
