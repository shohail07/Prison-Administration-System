<?php
define("PAGE_NAME","Approve");



session_start();
session_regenerate_id(true);

// print_r($_SESSION);

require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');

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

$data = getData();
$role_menu = $data['role'];
if ($role_menu == 'officer') {
  $query= "SELECT *  FROM users WHERE users.role <> 'admin' and users.role <> 'administrator' and users.role <> '$role_menu' and users.approved <> 'yes' and users.approved <> 'visit';";
}elseif($role_menu == 'administrator'){
  $query= "SELECT *  FROM users WHERE users.role <> 'admin'  and users.role <> '$role_menu' and users.approved <> 'yes' and users.approved <> 'visit';";

}else{
  $query= "SELECT *  FROM users WHERE users.role <> 'admin' and users.role <> '$role_menu' and users.approved <> 'yes' and users.approved <> 'visit';";
}


$edit_btn= '<button type="button" class="btn btn-primary click_edit" data-toggle="modal" data-target="#modal_full_info"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
</svg> Edit
</button>';
// echo $query;
$list_result = mysqli_query($connect, $query);
$num = mysqli_num_rows($list_result);
if(mysqli_num_rows($list_result) > 0)
{
	$output_list='';
  $i =0;
	while($list_row = mysqli_fetch_array($list_result))
	{ $i++;
    $val= pass_openssl_2_enc($list_row["unique_id_php"]);
		$output_list .= '
			<tr>
				<td>'.$i.'</td>
				<td><img src="'.img_check($list_row["img"]).'" alt="" width="100%" class="user_img_list"></td>
				<td>'.$list_row["full_name"].'</td>
				
				<td>'.$list_row["inert_time"].'</td>
				<td>'.$list_row["role"].'</td>
				<td>'.$list_row["approved"].'</td>
        <td class="text-capitalize text-primary" data-a='.$val.'>'.$edit_btn.'</td>
				
			</tr>
		';
	}
	
}
$sql_meta = "SELECT *  FROM meta_data  ;";   
$sql_meta_result = mysqli_query($connect, $sql_meta);
// $sql_meta_row = mysqli_fetch_array($sql_meta_result);
$meta_field_list='';
if(mysqli_num_rows($sql_meta_result) > 0)
{
	
  
	while($list_row_option = mysqli_fetch_array($sql_meta_result))
	{ 
    $val =$list_row_option['meta_field'];
   $meta_field_list .= '<option value="'.$val.'">'.$val.'</option>';
 
		
	}
	
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

    

      <h4 class="text-center text-capitalize"><?php echo 'Approve List';?></h4>
      <h3 class="text-capitalize"><?php echo 'Approve Pending:'.$num;?></h3>

      <table class="table table-bordered table-responsive-md list_table" id="list_table1">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Photo</th>
                              <th scope="col">Full Name</th>
                              <th scope="col">Creation Date</th>
                              <th scope="col">Role</th>
                              <th scope="col">Approved?</th>
                              <th scope="col">Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php echo $output_list; ?> 
                          
                          </tbody>
      </table>
    



        <!-- Button trigger modal -->
        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_full_info"> Launch demo modal</button> -->

                <!-- Modal -->
                <!-- <div> -->
                <div class="modal fade" id="modal_full_info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <form  method="POST">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">Details</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body ">
                          <div class="row text-center ">
                            <div class="col-sm-12 pb-5">
                              <img src="" class="avatar img-circle" id="view_photo" width="250px" height="250px" alt="avatar">
                            </div>
                          </div>
                          
                        <div class="form-group row">
                          <label class="col-sm-3 control-label align-self-center">Full name:</label>
                          <div class="col-sm-8">
                            <input class="form-control" type="text" name="view_full_name" id="view_full_name" value="view_full_name" >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 control-label align-self-center">Email:</label>
                          <div class="col-sm-8">
                            <input class="form-control" type="text" name="view_email" id="view_email" value="view_email" >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 control-label align-self-center">Phone:</label>
                          <div class="col-sm-8">
                            <input class="form-control" type="text" name="view_phone" id="view_phone" value="view_phone" >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 control-label align-self-center">Role:</label>
                          <div class="col-sm-8">
                            <input class="form-control" type="text" name="view_role" id="view_role" value="view_role" >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 control-label align-self-center">Block:</label>
                          <div class="col-sm-8">
                            <input class="form-control" type="text" name="view_block" id="view_block" value="view_block" >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 control-label align-self-center">inert_time:</label>
                          <div class="col-sm-8">
                            <input class="form-control" type="text" name="view_inert_time" id="view_inert_time" value="view_inert_time" >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 control-label align-self-center">approved:</label>
                          <div class="col-sm-8">
                            <input class="form-control" type="text" name="view_approved" id="view_approved" value="view_approved" >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 control-label align-self-center">Document:</label>
                          <div class="col-sm-8">
                            <!-- <input class="form-control" type="text" name="" id="" value="name" > -->
                            <img  class="avatar img-circle" width="250px" height="250px" alt="avatar" id="view_doc">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 control-label align-self-center">gender:</label>
                          <div class="col-sm-8">
                            <input class="form-control" type="text" name="view_gender" id="view_gender" value="view_gender" >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 control-label align-self-center">address:</label>
                          <div class="col-sm-8">
                            <input class="form-control" type="text" name="view_address" id="view_address" value="view_address" >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 control-label align-self-center">city:</label>
                          <div class="col-sm-8">
                            <input class="form-control" type="text" name="view_city" id="view_city" value="view_city" >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 control-label align-self-center">Date of Birth:</label>
                          <div class="col-sm-8">
                            <input class="form-control" type="text" name="view_dob" id="view_dob" value="view_dob" >
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary send_msg_modal" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Send message</button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <select name="approve_list" id="approve_list" class="btn btn-primary text-capitalize">
                            <option value="0">choose  type</option>
                            <?php echo $meta_field_list;?>

                          </select>
                          <button type="button" id="submit_btn" class="btn btn-primary">Save changes</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
            </div>
            <!-- MAIL -->
            

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Send message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form>
                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Recipient:</label>
                        <input type="text" class="form-control" id="view_full_name_send" readonly>
                      </div>
                      <div class="form-group">
                        <label for="message-text" class="col-form-label">Message:</label>
                        <textarea class="form-control" id="send_message_text"></textarea>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary send_msg_btn" data-dismiss="modal">Send message</button>
                  </div>
                </div>
              </div>
            </div>

    </div>

</div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function () {
      var myGlobalVariable;
      var myGlobalVariable2;
      $('.click_edit').click(function (e) { 
        e.preventDefault();
        var rule_id= $(this).parent().attr("data-a");
        myGlobalVariable = rule_id;
        console.log(rule_id);
        $.ajax({
          type: "POST",
          url: "view_data.php",
          data: {'id': rule_id, 'approve': 'no'},
          dataType: "json",
          success: function (response) {
            console.log(response);
            var  name =response.name;
            myGlobalVariable2 = name;
            var  role =response.role;
            var  email =response.email;
            var  unique_id_php =response.unique_id_php;
            var  block =response.block;
            var  inert_time =response.inert_time;
            var  approved =response.approved;
            var  who_approved =response.who_approved;
            var  img =response.img;
            var  doc =response.doc;
            var  phone_number =response.phone_number;
            var  gender =response.gender;
            var  address =response.address;
            var  city =response.city;
            var  dob =response.dob;
            var  marital_status =response.marital_status;
            $('#view_full_name').val(name);
            $('#view_email').val(email);
            $('#view_phone').val(phone_number);
            $('#view_role').val(role);
            $('#view_block').val(block);
            $('#view_inert_time').val(inert_time);
            $('#view_approved').val(approved);
            $('#view_gender').val(gender);
            $('#view_address').val(address);
            $('#view_city').val(city);
            $('#view_dob').val(dob);
            $('#view_photo').attr('src',img);
            $('#view_doc').attr('src',doc);
            // $('#            $('#').val(value);').val(value);
          }
        });
      });
      $('#submit_btn').click(function (e) { 
      e.preventDefault();
      var rule_id= myGlobalVariable;
    
      var approve_list=$('#approve_list').val();
      var who_approved = '<?php echo $user_name; ?>';
      console.log(approve_list);
      $.ajax({
        type: "POST",
        url: "view_data.php",
        data: {'id': rule_id, 'approve': 'yes', 'approve_list': approve_list, 'who_approved': who_approved},
        dataType: "text",
        success: function (response) {
          var response = $.trim(response);
          if (response == "ok") {
            location.reload();
          }
        }
      });
    });
    $('.send_msg_modal').click(function (e) { 
      e.preventDefault();
      
      
      var name= myGlobalVariable2;
      $('#view_full_name_send').val(name);
      var sender = "<?php echo $data['unique_id_php']?>";
      var reciver= myGlobalVariable;
      $('.send_msg_btn').click(function (e) { 
        e.preventDefault();
        var text_box = $('#send_message_text').val();
        console.log(text_box);
        $.ajax({
          type: "POST",
          url: "send_msg.php",
          data: {'sender': sender, 'reciver': reciver, 'text_box':text_box},
          dataType: 'text',
          success: function (response) {
            console.log(response);
           

          }
        });
        
      });

      
    });
    });
    $(document).ready(function () {
    $('#list_table1').DataTable({
          searching: false,
          paging: false,
          "showNEntries" : false,
          scrollY:        350,
          deferRender:    true,
          scroller:       true
        });
  });
  $(document).ready(function () {
    
  });
</script>


</body>
</html>