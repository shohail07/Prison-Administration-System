<?php
define("PAGE_NAME","Visitor Requests");



session_start();
session_regenerate_id(true);

// print_r($_SESSION);


require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php');

// if (!userloggedin()) {
//   header('location:logout.php');
// }

checksame();
$approved_status_comment= approve();

if (isset($_POST['change_pass'])) {
  $_SESSION[pass_openssl_2_enc('password_change_trigger')] = pass_openssl_2_enc('change mode for logged user');
  header('location:../config/verification.php');
}


// inbox
$data = getData();
$reciver = $data['unique_id_php'];

$path =$_SERVER['SCRIPT_NAME'];
$file = basename($path, ".php");

$query= "SELECT *  FROM request ;";

$edit_btn= '<button type="button" class="btn btn-primary click_edit" data-toggle="modal" data-target=".bd-example-modal-xl"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
</svg> Edit 
</button>';
$output_list='';
$list_result = mysqli_query($connect, $query);
if(mysqli_num_rows($list_result) > 0)
{
	
  $i =0;
	while($list_row = mysqli_fetch_array($list_result))
	{ $i++;
    $val= $list_row["prisoner_id"];
    $val2= $list_row["unique_id"];
  
		$output_list.= '
			<tr>
				<td>'.$i.'</td>
				<td><img src="'.img_check($list_row["img"]).'" alt="" width="100%" class="user_img_list"></td>
				<td>'.$list_row["unique_id"].'</td>
				<td>'.$list_row["prisoner_id"].'</td>
				<td>'.$list_row["name"].'</td>
				<td>'.$list_row["relation"].'</td>
				<td>'.$list_row["approve"].'</td>
				
        <td class="text-capitalize text-primary" data-a='.$val.' data-b='.$val2.'>'.$edit_btn.'</td>
				
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
	$meta_field_list.='<option value="block_yes">Block User</option>';
	$meta_field_list.='<option value="block_no">Unblock User</option>';
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
    
    <div class="text-center text-danger" style="font-weight: bold;">
      <?php echo $approved_status_comment; ?>
    </div>

      

      <h4 class="text-center text-capitalize"><?php echo $file.' List';?></h4>

      <table class="table table-bordered table-responsive-md list_table" id="list_table10">
                          <thead>
                            <tr class="text-capitalize">
                              <th scope="col">#</th>
                              <th scope="col">Prisoner Photo</th>
                              <th scope="col">user id</th>
                              <th scope="col">prisoner id</th>
                              <th scope="col"> Prisoner Full Name</th>
                              <th scope="col">Relation</th>
                              <th scope="col">approve</th>
                              
                              <th scope="col">Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php echo $output_list; ?> 
                          
                          </tbody>
      </table>


                  

    </div>

     <!-- Modal -->
     <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <form  method="POST">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">View Prisoner</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <div class="row pb-5" style="height: 85vh; overflow-y: scroll; ">
                  
                    
                    <div class="col-sm-6">
                      <div class="col-sm-12 mt-5">
                        <div>According to Request</div>
                        <div>Prisoner Data</div>
                      </div>
                    <div class="text-center">
                      <div id="preview "><img src="<?php echo img_check('user_img'); ?>" class="avatar img-circle view_prisoner_photo " width="250px" height="250px" alt="avatar"></div>

                    <div class="col-sm-12 mt-5 row">
                      <div class="col-sm-6 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-6 control-label">ID:</label>
                          <div class="col-sm-6">
                            <input class="form-control" name="view_prisoner_id" id="view_prisoner_id" type="text"   readonly>
                          </div>
                        </div> 
                      </div>
                      <div class="col-sm-6 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-6 control-label">Cell No:</label>
                          <div class="col-sm-6">
                            <input type="text"  name="cell_no" id="view_prisoner_cell" class="form-control" required>
                             
                          </div>
                        </div> 
                      </div>
                      <div class="col-sm-6 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-6 control-label">Visitor Access:</label>
                          <div class="col-sm-6">
                          <select name="view_prisoner_visitor" id="view_prisoner_visitor" class="form-control">
                              <option value="">Select </option>
                              <option value="allow">Allowed</option>
                              <option value="not">Not Allow</option>
                            </select>
                          </div>
                        </div> 
                      </div>
                      <div class="col-sm-6 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-6 control-label">Name:</label>
                          <div class="col-sm-6">
                            <input class="form-control" name="view_prisoner_name" id="view_prisoner_name"  value="" required>
                          </div>
                        </div> 
                      </div>
                      <div class="col-sm-6 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-6 control-label">Date of Birth:</label>
                          <div class="col-sm-6">
                            <input class="form-control" type="date" name="view_prisoner_dob" id="view_prisoner_dob" value="">
                          </div>
                        </div> 
                      </div>
                      <div class="col-sm-6 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-6 control-label">Address:</label>
                          <div class="col-sm-6">
                            <input class="form-control" type="text" name="view_prisoner_address" id="view_prisoner_address" value="">
                          </div>
                        </div> 
                      </div>
                      <div class="col-sm-6 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-6 control-label">Marital Status:</label>
                          <div class="col-sm-6">
                            <input class="form-control" type="text" value="" name="view_prisoner_marital" id="view_prisoner_marital">
                          </div>
                        </div> 
                      </div>
                      <div class="col-sm-6 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-6 control-label">Complexion:</label>
                          <div class="col-sm-6">
                            <input class="form-control" type="text" value="" name="view_prisoner_complexion" id="view_prisoner_complexion">
                          </div>
                        </div> 
                      </div>
                      <div class="col-sm-6 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-6 control-label">Eye Color:</label>
                          <div class="col-sm-6">
                            <input class="form-control" type="text" value="" name="view_prisoner_eye" id="view_prisoner_eye">
                          </div>
                        </div> 
                      </div>
                      
                    </div>
                    <div class="col-sm-12 pt-1 pb-2">
                      <h5 class="text-center"> Case info</h5>
                      
                    </div>
                    <div class="col-sm-6 mb-2">
                      <div class="form-group row">
                        <label class="col-sm-6 control-label">Crimes Committed:</label>
                        <div class="col-sm-6">
                          <input class="form-control" type="text" value="" name="view_prisoner_crimes" id="view_prisoner_crimes">
                        </div>
                      </div> 
                    </div>
                    <div class="col-sm-6 mb-2">
                      <div class="form-group row">
                        <label class="col-sm-6 control-label">Sentence [days]:</label>
                        <div class="col-sm-6">
                          <input class="form-control" type="text" value="" id="sentence" name=" view_prisoner_sentence">
                        </div>
                      </div> 
                    </div>
                    <div class="col-sm-6 mb-2">
                      <div class="form-group row">
                        <label class="col-sm-6 control-label">Time Serve Starts:</label>
                        <div class="col-sm-6">
                          <input class="form-control" type="date" id="startday" name="view_prisoner_startday">
                        </div>
                      </div> 
                    </div>
                    <div class="col-sm-6 mb-2">
                      <div class="form-group row">
                        <label class="col-sm-6 control-label">Time Serve Ends:</label>
                        <div class="col-sm-6">
                          <input class="form-control" type="date" id="endday" name="view_prisoner_endday">
                        </div>
                      </div> 
                    </div>
                    
                    <div class="col-sm-12 pt-1 pb-2">
                      <h5 class="text-center"> Emergency Contact Details</h5>
                      
                    </div>
                    <div class="col-sm-12 mb-2">
                      <div class="form-group row">
                        <label class="col-sm-6 control-label">Emergency Contact Name:</label>
                        <div class="col-sm-7">
                          <input class="form-control" type="text" value="" name="view_prisoner_emergency_name" id="view_prisoner_emergency_name">
                        </div>
                      </div> 
                    </div>
                    <div class="col-sm-6 mb-2">
                      <div class="form-group row">
                        <label class="col-sm-4 control-label">Contact:</label>
                        <div class="col-sm-6">
                          <input class="form-control" type="text" value="" id="view_prisoner_emergency_contact" name="view_prisoner_emergency_contact">
                        </div>
                      </div> 
                    </div>
                    <div class="col-sm-6 mb-2">
                      <div class="form-group row">
                        <label class="col-sm-4 control-label">Relation:</label>
                        <div class="col-sm-6">
                          <input class="form-control" type="text" id="view_prisoner_emergency_relation" name="view_prisoner_emergency_relation" >
                        </div>
                      </div> 
                    </div>
                    <div class="col-sm-12 pt-1 pb-2">
                      <h5 class="text-center"> Records</h5>
                      
                    </div>
                    <div class="col-sm-12 mb-2">
                      <table class="table table-bordered table-responsive-md list_table" id="list_table10">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Comments</th>
                                <th scope="col">Time</th>
                                
                              </tr>
                            </thead>
                            <tbody class="list">
                             <tr ></tr>
                            </tbody>
                      </table>

                    </div>
                  
                    
                  </div>
                  
                    </div> 
                    <div class="col-sm-6">
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
              </div>
            </div>
          </div>
            <div class="col-sm-12 mt-2">
            <div class="col-sm-6">
                  <select name="approve_list" id="approve_list" class="btn btn-primary text-capitalize">
                                  <option value="0">choose  type</option>
                                  <option value="approve">approve</option>
                                  <option value="reject">reject</option>
                                  <option value="renew">renew</option>
                                  
                    
                  </select>
                 <div class="col-sm-6">
                        <h6>From</h6>
                        <input type="date" name="from_data" id="from_data" class="form-control">
                        <input type="time" name="from_time" id="from_time" class="form-control">
                 </div>
                 <div class="col-sm-6">
                        <h6>TO</h6>
                        <input type="date" name="to_data" id="to_data" class="form-control">
                        <input type="time" name="to_time" id="to_time" class="form-control">
                 </div>
            </div>
            <div class="col-sm-6">
            <input type="submit" id="req" class="btn btn-primary" data-dismiss="modal" value="approved">
                      <span></span>
                      <button type="button" class="close btn btn-warning" data-dismiss="modal" aria-label="Close">Cancel</button>

            </div>
                      
            </div>
        </form>
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
   
  });
</script>
<script>
    $(document).ready(function () {
      var myGlobalVariable;
      var myGlobalVariable2;
      $('.click_edit').click(function (e) { 
        e.preventDefault();
        console.log(5);
        var rule_id= $(this).parent().attr("data-b");
        myGlobalVariable = rule_id;
        console.log(rule_id);
        $.ajax({
          type: "POST",
          url: "view_data2.php",
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
        $('#req').click(function (e) { 
        e.preventDefault();
        var from_data = $('#from_data').val();
        var from_time = $('#from_time').val();
        var to_data = $('#to_data').val();
        var to_time = $('#to_time').val();
        var approve_list = $('#approve_list').val();
        myGlobalVariable = rule_id;
        console.log(approve_list);
        console.log(from_data);
        console.log(from_time);
        console.log(to_data);
        console.log(to_time);
        console.log(rule_id);
        $.ajax({
          type: "POST",
          url: "update.php",
          data: {'id': rule_id, 'approve_list': approve_list, 'from_data': from_data, 'from_time': from_time, 'to_data': to_data, 'to_time': to_time},
          dataType: "text",
          success: function (response) {
            // var response = $.trim(response);
            location.reload();
            
          }
        });
        
        });
      
        
      });
    });
    
    
  
</script>
<script>
    $(document).ready(function () {
      var myGlobalVariable;
      var myGlobalVariable2;
      $('.click_edit').click(function (e) { 
        e.preventDefault();
        console.log(5);
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
            var unique_id =response.unique_id;
            var name =response.name;
            var cell_no=response.cell_no;
            var visitor =response.visitor;
            var prisoner_img=response.prisoner_img;
            var address=response.address;
            var dob=response.dob;
            var marital=response.marital;
            var complexion=response.complexion;
            var eye=response.eye;
            var crimes=response.crimes;
            var sentence=response.sentence;
            var start_time=response.start_time;
            var end_time=response.end_time;
            var emergency_name=response.emergency_name;
            var emergency_phone=response.emergency_phone;
            var emergency_relation=response.emergency_relation;
            $('#view_prisoner_id').val(unique_id);
            $('#view_prisoner_cell').val(cell_no);
            $('#view_prisoner_visitor').val(visitor);
            $('#view_prisoner_address').val(address);
            $('#view_prisoner_dob').val(dob);
            $('#view_prisoner_name').val(name);
            $('#view_prisoner_marital').val(marital);
            $('#view_prisoner_complexion').val(complexion);
            $('#view_prisoner_eye').val(eye);
            $('#view_prisoner_crimes').val(crimes);
            $('#sentence').val(sentence);
            $('#startday').val(start_time);
            $('#endday').val(end_time);
            $('#view_prisoner_emergency_name').val(emergency_name);
            $('#view_prisoner_emergency_contact').val(emergency_phone);
            $('#view_prisoner_emergency_relation').val(emergency_relation);
            $('.view_prisoner_photo').attr('src',prisoner_img);
            $.ajax({
              type: "post",
              url: "options_find.php",
              data: {'id': rule_id},
              dataType: "html",
              success: function (response) {
                  console.log(response);
                  $(".list").empty();
                  $('.list').append(response);
              }
            });
            
            
            // $('#            $('#').val(value);').val(value);
          }
        });
        $('#submit_btn').click(function (e) { 
        e.preventDefault();
        var rule_id= myGlobalVariable;
      
        var approve_list=$('#approve_list').val();
        if(approve_list == 'block_yes'){
          var row_name = 'block';
          var approve_list = "yes";

        }else if(approve_list == 'block_no'){
          var row_name = 'block';
          var approve_list = "no";
        }else{
          var row_name = 'approved';
        }
        var who_approved = '<?php echo $user_name; ?>';
        console.log(approve_list);
        $.ajax({
          type: "POST",
          url: "view_data.php",
          data: {'id': rule_id, 'approve': 'yes', 'data': approve_list, 'who_approved': who_approved, 'row_name': row_name},
          dataType: "text",
          success: function (response) {
            var response = $.trim(response);
            if (response == "ok") {
              location.reload();
            }
          }
        });
        });  
      });
      $('.click_record').click(function (e) { 
        e.preventDefault();
        console.log(5);
        var rule_id2= $(this).parent().attr("data-a");
        myGlobalVariable = rule_id2;
        console.log(rule_id2);
        $.ajax({
          type: "POST",
          url: "view_data.php",
          data: {'id': rule_id2, 'approve': 'no'},
          dataType: "json",
          success: function (response) {
            console.log(response);
            var unique_id =response.unique_id;
            var name =response.name;
            $('#record_prisoner_id').text(unique_id);
            
            $('#record_prisoner_name').text(name);
            $.ajax({
              type: "post",
              url: "options_find.php",
              data: {'id': rule_id2},
              dataType: "html",
              success: function (response) {
                  console.log(response);
                  $(".list").empty();
                  $('.list').append(response);
              }
            });

            
            // $('#            $('#').val(value);').val(value);
          }
        });
        $('.send_records').click(function (e) { 
        e.preventDefault();
        var rule_id2= myGlobalVariable;
      
        var approve_list=$('#message-text').val();
       if (approve_list !=='') {
        console.log(55);
        console.log(approve_list);
        $.ajax({
          type: "POST",
          url: "add_records.php",
          data: {'id': rule_id2, 'send': 'yes', 'msg': approve_list},
          dataType: "text",
          success: function (response) {
            var response = $.trim(response);
            if (response == "ok") {
              location.reload();
            }
          }
        });
       }
        
        });  
      });
    });
    
    
  
</script>
<script>
  $(document).ready(function () {
    $('#list_table10000').DataTable({
    searching: false,
          paging: false,
          "showNEntries" : false,
          scrollY:        150,
          deferRender:    true,
          scroller:       true
        });
  });
</script>


</body>
</html>