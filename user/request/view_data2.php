<?php


require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');
// require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php');


$unique__php  =mysqli_real_escape_string($connect,$_POST['id']);





if ($_POST['approve'] == 'yes') {
    $row_name = mysqli_real_escape_string($connect, $_POST['row_name']);
    $full_name_ac = mysqli_real_escape_string($connect, $_POST['data']);
    if ($row_name == 'approved') {
        $who_approved = mysqli_real_escape_string($connect, $_POST['who_approved']);
        $data_1_sql = "UPDATE users SET approved='$full_name_ac' , who_approved='$who_approved' WHERE unique_id_php ='$unique__php';";

    }else{
        
        $data_1_sql = "UPDATE users SET block='$full_name_ac'  WHERE unique_id_php ='$unique__php';";

    }
  
  
     
    
   
    if(mysqli_query($connect, $data_1_sql)){
    echo'ok';
    }else{
    echo 'not';
    };
      
}else{

           
        $firstsql = "SELECT *  FROM users WHERE users.unique_id_php ='$unique__php' ;";   
        $result = mysqli_query($connect, $firstsql);
        $row = mysqli_fetch_array($result);
        $secondsql = "SELECT *  FROM users_meta WHERE unique_id ='$unique__php';";   
        $secondresult = mysqli_query($connect, $secondsql);
        if ($secondresult && mysqli_num_rows($secondresult) > 0){
            $row2 = mysqli_fetch_array($secondresult);
        }else{
            $row2=[];
        }
               
        echo json_encode(array(
            "name" => $row['full_name'],
            // "phone" => $row['phone_num'],
            "role" => $row['role'],
            "email" => $row['email'],
            "unique_id_php" => $row['unique_id_php'],
            "block" => $row['block'],
            "inert_time" => $row['block'],
            "approved" => $row['approved'],
            "who_approved" => $row['who_approved'],
            "img" => img_check($row['img']),
            "doc" => doc_check($row['doc']),



            "phone_number" => isset($row2['phone_number']) ? $row2['phone_number'] : "",
            "gender" => isset($row2['gender']) ? $row2['gender'] : "",
            "address" => isset($row2['address']) ? $row2['address'] : "",
            "city" => isset($row2['city']) ? $row2['city'] : "",
            "dob" => isset($row2['dob']) ? $row2['dob'] : "",
            "marital_status" => isset($row2['marital_status']) ? $row2['marital_status'] : "",
           

        ));      
    
    
    }
?>
