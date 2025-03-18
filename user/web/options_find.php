<?php


require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');
// require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php');

$role =mysqli_real_escape_string($connect,$_POST['role']);
$hiden_f  =mysqli_real_escape_string($connect,$_POST['hiden_f']);

      $selection_option_sql ="SELECT * FROM rule_names";
      $selection_option_result = mysqli_query($connect, $selection_option_sql);
      // $selection_option_list='<option value="'.$role.' "selected>'.$role.'</option>';
      if ($role == 'admin') {
        $selection_option_list='<option value="admin" selected>admin</option>';
      }else{
        

      }
      if(mysqli_num_rows($selection_option_result) > 0){
        
        
        while($list_row_option = mysqli_fetch_array($selection_option_result))
        { 
          $val =$list_row_option['value_rule'];
          $val_name =$list_row_option['rule_name'];
          if ( $val == $role) {
            $selection_option_list.= '<option value="'.$val.'" selected>'.$val_name.'</option>';
          }else{
            
            $selection_option_list.= '<option value="'.$val.'">'.$val_name.'</option>';

          }
        }
        
      }
      echo $selection_option_list;
     








?>
