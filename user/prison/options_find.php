<?php


require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');
// require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php');

$pass_id  =mysqli_real_escape_string($connect,$_POST['id']);

      $selection_option_sql ="SELECT * FROM records where unique_id='$pass_id';";
      $selection_option_result = mysqli_query($connect, $selection_option_sql);
      $selection_option_list='';
      
      if(mysqli_num_rows($selection_option_result) > 0){
        
        $i=0;
        while($list_row_option = mysqli_fetch_array($selection_option_result))
        { $i++;
          $selection_option_list.= '<tr>
      
          <td>'.$i.'</td>
          <td>'.$list_row_option["msg"].'</td>
          <td>'.$list_row_option["time"].'</td>
        </tr>';
        }
        
      }else{
        $selection_option_list.='<tr><td colspan="3">Empty Inbox</td></tr>';
      }
      echo $selection_option_list;
     








?>
