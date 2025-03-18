<?php


require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');
// require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php');


$add_page_name =mysqli_real_escape_string($connect,$_POST['add_page_name']);
$add_page_folder =mysqli_real_escape_string($connect,$_POST['add_page_folder']);
$add_page_link =mysqli_real_escape_string($connect,$_POST['add_page_link']);
$add_page_role =mysqli_real_escape_string($connect,$_POST['add_page_role']);
$add_page_status =mysqli_real_escape_string($connect,$_POST['add_page_status']);


$folder = $add_page_folder;
$fileName = $add_page_link;

$path =$_SERVER['DOCUMENT_ROOT'].'/v3/user/';
$folderPath=$path.$folder;
$content= $_SERVER['DOCUMENT_ROOT'].'/v3/user/index.php';
$file_content= file_get_contents($content);
$filePath = $folderPath.'/'.$fileName;
$sql_path =$folder.'/'.$fileName;

if (is_dir($folderPath)) {
   echo 'already exist folder';
   
if (file_exists($filePath)) {
  
  echo ',already exist file';
  $firstsql =  "INSERT INTO menu(page_name,page_link,role,status) VALUES ('$add_page_name','$sql_path','$add_page_role','$add_page_status') ;"; 
        if(mysqli_query($connect, $firstsql)){

        }else{
          echo 'can not ';
        }
} else {
    $file = fopen($filePath, 'w'); 
    if ($file) {
      
      fwrite($file, $file_content);
        fclose($file);
        $firstsql =  "INSERT INTO menu(page_name,page_link,role,status) VALUES ('$add_page_name','$sql_path','$add_page_role','$add_page_status') ;"; 
        if(mysqli_query($connect, $firstsql)){

        }else{
          echo 'can not ';
        }
        
    } else {
        
    }
}
    
} else {
    mkdir($folderPath, 0700);
    if (file_exists($filePath)) {
      echo '<br>';
      echo 'already exist file';
    } else {
        $file = fopen($filePath, 'w'); 
        if ($file) {
          
          fwrite($file, $file_content);
            fclose($file);
            $firstsql =  "INSERT INTO menu(page_name,page_link,role,status) VALUES ('$add_page_name','$sql_path','$add_page_role','$add_page_status') ;"; 
            if(mysqli_query($connect, $firstsql)){
    
            }else{
              echo 'can not ';
            }
            
        } else {
            
        }
    }
    
    
    
}





?>
