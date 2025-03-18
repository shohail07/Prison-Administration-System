<?php


require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');
// require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php');


$unique_id =mysqli_real_escape_string($connect,$_POST['id']);





if ($_POST['approve'] == 'yes') {
    $row_name = mysqli_real_escape_string($connect, $_POST['row_name']);
    $full_name_ac = mysqli_real_escape_string($connect, $_POST['data']);
    if ($row_name == 'approved') {
        $who_approved = mysqli_real_escape_string($connect, $_POST['who_approved']);
        $data_1_sql = "UPDATE users SET approved='$full_name_ac' , who_approved='$who_approved' WHERE unique_id_php ='$unique_id';";

    }else{
        
        $data_1_sql = "UPDATE users SET block='$full_name_ac'  WHERE unique_id_php ='$unique_id';";

    }
  
  
     
    
   
    if(mysqli_query($connect, $data_1_sql)){
    echo'ok';
    }else{
    echo 'not';
    };
      
}else{

           
        $firstsql = "SELECT *  FROM prisoner_list WHERE unique_id ='$unique_id' ;";   
        $result = mysqli_query($connect, $firstsql);
        $row = mysqli_fetch_array($result);

        echo json_encode(array(
            "id" => $row['id'],
            "unique_id" => $row['unique_id'],
            "cell_no" => $row['cell_no'],
            "name" => $row['name'],
            "visitor" => $row['visitor'],
            "prisoner_img" => img_check($row['prisoner_img']),
            "address" => $row['address'],
            "dob" => $row['dob'],
            "marital" => $row['marital'],
            "complexion" => $row['complexion'],
            "eye" => $row['eye'],
            "crimes" => $row['crimes'],
            "sentence" => $row['sentence'],
            "start_time" => $row['start_time'],
            "end_time" => $row['end_time'],
            "emergency_name" => $row['emergency_name'],
            "emergency_phone" => $row['emergency_phone'],
            "emergency_relation" => $row['emergency_relation']
            
            
           

        ));      
    
    
    }
?>
