<?php

// define("base_url","http://localhost/project");
// $date = strtotime($row['inert_time']);
// echo date('l,d F Y, h:i:s A ', $date);
$status = session_status();
if($status == PHP_SESSION_NONE){

    session_start();
    session_regenerate_id(true);
}




function userloggedin(){
    if ($_SESSION['block'] == 'no' && $_SESSION['start'] == 'online') {
       return true;
    }
};

function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$_SERVER['QUERY_STRING'] = validate($_SERVER['QUERY_STRING']);
if ($_SERVER['QUERY_STRING'] !=='') {
    header('location:http://localhost/v3/config/logout.php');
    
}

function checksame(){
    include('connect.php');
    if ($_SESSION[pass_openssl_2_enc('status')] == pass_openssl_enc('online') && !empty($_SESSION[pass_openssl_2_enc('unique_id_php')])) {
        $email_php = pass_openssl_dec($_SESSION[pass_openssl_2_enc('email')]);
        $unique__php = pass_openssl_dec($_SESSION[pass_openssl_2_enc('unique_id_php')]);
        
        $firstsql = "SELECT *  FROM users WHERE users.unique_id_php ='$unique__php' and users.email ='$email_php';";   
        $result = mysqli_query($connect, $firstsql);
        $row = mysqli_fetch_array($result);
       
       
      
        if ($row['block'] == 'yes') {
            
            header('location:logout.php');
          }elseif ( $row['block'] == 'no') {
            if( $row['verification'] !== '1' ){
              header('location:verification.php');
           
            }
      
        
      }else{
        header('location:logout.php');
        
        }

    }else{
      
    }
    return true;
    
}

function getData(){
    include('connect.php');
    if ($_SESSION[pass_openssl_2_enc('status')] == pass_openssl_enc('online') && !empty($_SESSION[pass_openssl_2_enc('unique_id_php')])) {
        $email_php = pass_openssl_dec($_SESSION[pass_openssl_2_enc('email')]);
        $unique__php = pass_openssl_dec($_SESSION[pass_openssl_2_enc('unique_id_php')]);
        
        $firstsql = "SELECT *  FROM users WHERE users.unique_id_php ='$unique__php' and users.email ='$email_php';";   
        $result = mysqli_query($connect, $firstsql);
        $row = mysqli_fetch_array($result);
        $secondsql = "SELECT *  FROM users_meta WHERE unique_id ='$unique__php';";   
        $secondresult = mysqli_query($connect, $secondsql);
        if ($secondresult && mysqli_num_rows($secondresult) > 0){
            $row2 = mysqli_fetch_array($secondresult);
        }else{
            $row2=[];
        }
        
        // $retVal = (condition) ? a : b ;
        
        return array(
            "name" => $row['full_name'],
            // "phone" => $row['phone_num'],
            "role" => $row['role'],
            "email" => $row['email'],
            "unique_id_php" => $row['unique_id_php'],

            "phone_number" => isset($row2['phone_number']) ? $row2['phone_number'] : "",
            "gender" => isset($row2['gender']) ? $row2['gender'] : "",
            "address" => isset($row2['address']) ? $row2['address'] : "",
            "city" => isset($row2['city']) ? $row2['city'] : "",
            "dob" => isset($row2['dob']) ? $row2['dob'] : "",
            "marital_status" => isset($row2['marital_status']) ? $row2['marital_status'] : "",
           

          );      
    }
    
}
// $s =getData();
// print_r($s);


function approve(){
    include('connect.php');
    $approve_mail = pass_openssl_dec($_SESSION[pass_openssl_2_enc('email')]);
    $approve_id = pass_openssl_dec($_SESSION[pass_openssl_2_enc('unique_id_php')]);
    $approve_id_sql = "SELECT *  FROM users WHERE users.unique_id_php ='$approve_id' and users.email ='$approve_mail';";   
    $approve_id_result = mysqli_query($connect, $approve_id_sql);
    $approve_result = mysqli_fetch_array($approve_id_result);
    $approved_status_comment='';
    $approved_status= $approve_result['approved'];
    
    
    
    $approved_status_sql = "SELECT *  FROM meta_data WHERE meta_data.meta_field ='$approved_status';";   
    $result_approved_status_sql_count = mysqli_query($connect, $approved_status_sql);
    $rows_result_approved_status_sql_count = mysqli_num_rows($result_approved_status_sql_count);
    $result_approved_status_sql= mysqli_fetch_array($result_approved_status_sql_count);

    
    
    if ($rows_result_approved_status_sql_count == 0) {
        $approved_status_comment='';
    }else{
        $approved_status_comment = $result_approved_status_sql['meta_value'];
    }
    
    
    return $approved_status_comment;
}

function pass_openssl_enc ($pass) {
    
    $key='11223344556677889900AASSDDFFGGHHlkjhg!@#$%%$#@!!@#$$%$$###@@@@@#';
    $chiper="AES-128-CTR";
    $iv='9876543211598750';
    $options=0;

    $pass=openssl_encrypt($pass, $chiper, $key, $options, $iv);
    
    return $pass;
}

function pass_openssl_dec ($pass) {
    
    $key='11223344556677889900AASSDDFFGGHHlkjhg!@#$%%$#@!!@#$$%$$###@@@@@#';
    $chiper="AES-128-CTR";
    $iv='9876543211598750';
    $options=0;

    $pass=openssl_decrypt($pass, $chiper, $key, $options, $iv);
    
    return $pass;
}
function pass_openssl_2_enc ($pass) {
    
    $key='ABCDFpoiuytrewq!@#$%^&!@#$%^&zxnsuiunvsiourtuhnogviusnohgiubdhvivi';
    $chiper="AES-128-CTR";
    $iv='8654259874135697';
    $options=0;

    $pass=openssl_encrypt($pass, $chiper, $key, $options, $iv);
    
    return $pass;
}

function pass_openssl_2_dec ($pass) {
    
    $key='ABCDFpoiuytrewq!@#$%^&!@#$%^&zxnsuiunvsiourtuhnogviusnohgiubdhvivi';
    $chiper="AES-128-CTR";
    $iv='8654259874135697';
    $options=0;

    $pass=openssl_decrypt($pass, $chiper, $key, $options, $iv);
    
    return $pass;
}





function img_check($img_link){
    include('connect.php');
    
    // define("base_function_aaa",'http://'.$_SERVER['SERVER_NAME'].'/v3/assets/');
    $base_fuction ='http://'.$_SERVER['SERVER_NAME'].'/v3/assets/';
    $file_path = $base_fuction.$img_link;
    $ch = curl_init($file_path);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
 
    if($img_link=== null){
        $user_img_out= $base_fuction."user_img/blank.png";
        
    }else{
        if($responseCode == 200){
            $user_img_out =$file_path;
        }else{
            // $user_img= constant("base_function_aaa").$user_dashboard_row['img'];
            $user_img_out= $base_fuction."user_img/blank.png";
        }
    }
    return $user_img_out;
}




function doc_check($img_link){
    include('connect.php');
    
    // define("base_function_aaa",'http://'.$_SERVER['SERVER_NAME'].'/v3/assets/');
    $base_fuction ='http://'.$_SERVER['SERVER_NAME'].'/v3/assets/';
    $file_path = $base_fuction.$img_link;
    $ch = curl_init($file_path);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    // if($img_link == ''){
    //     $user_img_out= $base_fuction."user_doc/blank.png";
    //     $msg ='no'; 
    // }
    if($img_link === null){
        $user_img_out= $base_fuction."user_doc/blank.png";
        $msg ='no';
        
    }else{
        if($responseCode == 200){
            $user_img_out =$file_path;
            $msg ='yes';
        }else{
            // $user_img= constant("base_function_aaa").$user_dashboard_row['img'];
            $user_img_out= $base_fuction."user_doc/blank.png";
            $msg ='no';
        }
    }
    return $user_img_out;
}
function getName($n) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
 
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
 
    return $randomString;
}















?>




