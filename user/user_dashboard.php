<?php

$status = session_status();
if($status == PHP_SESSION_NONE){

    session_start();
    session_regenerate_id(true);
}



require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php');


$user_dashboard_email = pass_openssl_dec($_SESSION[pass_openssl_2_enc('email')]);
$user_dashboard_id = pass_openssl_dec($_SESSION[pass_openssl_2_enc('unique_id_php')]);

$user_dashboard_sql = "SELECT *  FROM users WHERE users.unique_id_php ='$user_dashboard_id';";   
$user_dashboard_result = mysqli_query($connect, $user_dashboard_sql);
$user_dashboard_row = mysqli_fetch_array($user_dashboard_result);

$role_menu =$user_dashboard_row['role'];
$menu_sql= "SELECT *  FROM menu WHERE menu.role ='$role_menu' and menu.status ='yes';"; 
$result_menu_sql = mysqli_query($connect, $menu_sql);
$output='';
$output .= ' <li><a href="/v3/user/" dekhi="Dashboard">Dashboard</a></li>';

if ($user_dashboard_row['approved'] !== 'yes') {

}else{
    

    while($row_menu_sql = mysqli_fetch_array($result_menu_sql)){
        $output .= ' <li><a href="/v3/user/'.$row_menu_sql["page_link"].'"  dekhi="'.str_replace(" ","",$row_menu_sql["page_name"]).'">'.$row_menu_sql["page_name"].'</a></li>';
    }
     
}
$output .= '<li><a href="/v3/user/account/account.php" dekhi="AccountSettings">Account Settings</a></li>
                <li><a href="/v3/user/settings.php" dekhi="PrivacyandSecurity">Privacy and Security</a></li>
                <li><a href="/v3/user/logout.php" dekhi="Logout">Logout</a></li>';
 
 $user_name = $user_dashboard_row['full_name'];
 $user_img= img_check($user_dashboard_row['img']);
 $doc= $user_dashboard_row['doc'];
 $user_doc= doc_check($doc);
// if ($user_doc['user_doc'] = 'yes') {
//   $user_msg = 'Uploaded Document';
//   $user_msg2 = 'Upload again';
// }else{
//   $user_msg = 'Upload Document';
//   $user_msg2 = 'Upload ';
// }
// print_r($user_doc);

 if (!defined("PAGE_NAME")) {
    header('location:logout.php');
    
}


?>














<section id="user_dashboard">
        <div id="menus">
                <div class="logo-bar">
                    <div class="logo">PMS</div>
                    <div class="text-center">Prison management system</div>
                    <hr>
                </div>
                <div class="user_profile">
                    <img src="<?php echo $user_img; ?>" alt="" width="100%" class="user_img">
                    <div class="user_name"> <?php echo $user_name; ?></div>
                    <div class="list_menus">
                        <ul>
                            <?php echo $output; ?>
                            
                        </ul>
                    </div>
                </div>
        </div>
        <div id="dashboards">
            <div class="bar">
                <div class="page_name "><?php echo constant("PAGE_NAME");?></div>
                <div class="user_role_name "><?php echo $role_menu; ?></div>
            </div>



<script>
  $(document).ready(function () {
     var page_name = '<?php echo str_replace(" ","",constant("PAGE_NAME")) ?>';
     
     $("[dekhi="+page_name+"]").css("background-color", "rgb(255, 255, 255)");
     $("[dekhi="+page_name+"]").css("color", "black");
    $('.logo_bar').click(function (e) { 
        e.preventDefault();
        location.reload();
        
    });
  });
</script>