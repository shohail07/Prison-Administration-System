<?php


require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');
// require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php');


$id =mysqli_real_escape_string($connect,$_POST['id']);
$pass_id = pass_openssl_2_dec($id);







if ($_POST['update'] == 'yes') {
  
  $Page_Name_menu =mysqli_real_escape_string($connect,$_POST['Page_Name_menu']);
  $Page_link_menu=mysqli_real_escape_string($connect,$_POST['Page_link_menu']);
  $Page_role_menu=mysqli_real_escape_string($connect,$_POST['Page_role_menu']);
  $Page_status_menu=mysqli_real_escape_string($connect,$_POST['Page_status_menu']);
  
    $firstsql =  "UPDATE menu SET  page_name='$Page_Name_menu', page_link='$Page_link_menu' , role='$Page_role_menu', status='$Page_status_menu'  WHERE id='$pass_id' ;"; 
        $result = mysqli_query($connect, $firstsql);
       
      
}else{


        $firstsql = "SELECT *  FROM menu WHERE id ='$pass_id' ;";   
        $result = mysqli_query($connect, $firstsql);
        $row = mysqli_fetch_array($result);
        
        echo json_encode(array(
          
          'page_name' => $row['page_name'],
          'page_link' => $row['page_link'],
          'role' => $row['role'],
          'status' => $row['status']

      ));



     

}






?>
