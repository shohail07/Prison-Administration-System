<?php
define("PAGE_NAME","Prisoner Management");





session_start();
session_regenerate_id(true);



require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php');

checksame();
$approved_status_comment= approve();
$output_list = '';









if (isset($_POST['change_pass'])) {
  $_SESSION[pass_openssl_2_enc('password_change_trigger')] = pass_openssl_2_enc('change mode for logged user');
  header('location:../config/verification.php');
}
// -----------------------------

$path =$_SERVER['SCRIPT_NAME'];
$file = basename($path, ".php");

$query= "SELECT *  FROM prisoner_list ";

$edit_btn= '<button type="button" class="btn btn-primary click_edit" data-toggle="modal" data-target=".bd-example-modal-xl"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
</svg> View 
</button>';
$edit_btn2= '<button type="button" class="btn btn-warning   click_record" data-toggle="modal" data-target="#records_modal"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
</svg> Add Record 
</button>';

$list_result = mysqli_query($connect, $query);
$num_list =mysqli_num_rows($list_result) ;
if(mysqli_num_rows($list_result) > 0)
{
	
  $i =0;
	while($list_row = mysqli_fetch_array($list_result))
	{ $i++;
    
		$output_list .= '
			<tr>
				<td>'.$i.'</td>
				<td><img src="'.img_check($list_row["prisoner_img"]).'" alt="" width="100%" class="user_img_list"></td>
				<td>'.$list_row["unique_id"].'</td>
				<td>'.$list_row["cell_no"].'</td>
				<td>'.$list_row["name"].'</td>
				<td>'.$list_row["address"].'</td>
				<td>'.$list_row["crimes"].'</td>
				
        <td class="text-capitalize text-primary" data-a='.$list_row["unique_id"].'>'.$edit_btn.'</td>
        <td class="text-capitalize text-warning" data-a='.$list_row["unique_id"].'>'.$edit_btn2.'</td>
				
			</tr>
		';
	}
	
}


$districts_sql ="SELECT * FROM cell_data;";
$selection_option_result = mysqli_query($connect, $districts_sql);
$cell_list='';
if(mysqli_num_rows($selection_option_result) > 0)
{
	
  
	while($list_row_option = mysqli_fetch_array($selection_option_result))
	{ 
    $cell_no =$list_row_option['cell_no'];
    $max =$list_row_option['max'];
    $booked =$list_row_option['booked'];
    $n_max = (int) $max;
    $booked = (int) $booked;
    $remaining = $n_max -$booked;

    if ($remaining == 0) {
      $cell_list .='';
    }else{
      $cell_list .= '<option value="'.$cell_no.'">'.$cell_no.' [Remaining: '.$remaining.', Max: '.$max.' ]</option>';
    }
    
    
    
		
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
    
    <div class="text-center text-danger" style="font-weight: bold;">
      <?php echo $approved_status_comment; ?>
    </div>

    <a href="add_prisoner.php" class="btn btn-success" style="border: 10px solid #157347;"> Add New Prisoner</a>

      <h4 class="text-center text-capitalize"><?php echo 'Prisoner List';?></h4>
      <h4 class="text-center text-capitalize"><?php echo 'Total Prisoner:'. $num_list;?></h4>

      <table class="table table-bordered table-responsive-md list_table" id="list_table10">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Photo</th>
                              <th scope="col">unique_id </th>
                              <th scope="col">cell_no </th>
                              <th scope="col">Full Name</th>
                              <th scope="col">address</th>
                              <th scope="col">crimes</th>
                              <th scope="col">Actions</th>
                              <th scope="col">Records</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php echo $output_list; ?> 
                          
                          </tbody>
      </table>

      

                  

  </div>

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
                  
                    
                    <div class="col-sm-12 ">
                    <div class="text-center">
                      <div id="preview "><img src="<?php echo img_check('user_img'); ?>" class="avatar img-circle view_prisoner_photo " width="600px" height="600px" alt="avatar"></div>

                    <div class="col-sm-12 mt-5 row">
                      <div class="col-sm-6 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-3 control-label">ID:</label>
                          <div class="col-sm-8">
                            <input class="form-control" name="view_prisoner_id" id="view_prisoner_id" type="text"  value="<?php echo time();?>" readonly>
                          </div>
                        </div> 
                      </div>
                      <div class="col-sm-6 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-3 control-label">Cell No:</label>
                          <div class="col-sm-8">
                            <select name="cell_no" id="view_prisoner_cell" class="form-control" required>
                              <option value="">Select  cell</option>
                              <?php echo $cell_list;?>
                            </select>
                          </div>
                        </div> 
                      </div>
                      <div class="col-sm-6 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-3 control-label">Visitor Access:</label>
                          <div class="col-sm-8">
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
                          <label class="col-sm-3 control-label">Name:</label>
                          <div class="col-sm-8">
                            <input class="form-control" name="view_prisoner_name" id="view_prisoner_name" type="text" value="" required>
                          </div>
                        </div> 
                      </div>
                      <div class="col-sm-6 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-3 control-label">Date of Birth:</label>
                          <div class="col-sm-8">
                            <input class="form-control" type="date" name="view_prisoner_dob" id="view_prisoner_dob" value="">
                          </div>
                        </div> 
                      </div>
                      <div class="col-sm-6 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-3 control-label">Address:</label>
                          <div class="col-sm-8">
                            <input class="form-control" type="text" name="view_prisoner_address" id="view_prisoner_address" value="">
                          </div>
                        </div> 
                      </div>
                      <div class="col-sm-6 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-3 control-label">Marital Status:</label>
                          <div class="col-sm-8">
                            <input class="form-control" type="text" value="" name="view_prisoner_marital" id="view_prisoner_marital">
                          </div>
                        </div> 
                      </div>
                      <div class="col-sm-6 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-3 control-label">Complexion:</label>
                          <div class="col-sm-8">
                            <input class="form-control" type="text" value="" name="view_prisoner_complexion" id="view_prisoner_complexion">
                          </div>
                        </div> 
                      </div>
                      <div class="col-sm-6 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-3 control-label">Eye Color:</label>
                          <div class="col-sm-8">
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
                        <label class="col-sm-3 control-label">Crimes Committed:</label>
                        <div class="col-sm-8">
                          <input class="form-control" type="text" value="" name="view_prisoner_crimes" id="view_prisoner_crimes">
                        </div>
                      </div> 
                    </div>
                    <div class="col-sm-6 mb-2">
                      <div class="form-group row">
                        <label class="col-sm-3 control-label">Sentence [days]:</label>
                        <div class="col-sm-8">
                          <input class="form-control" type="text" value="" id="sentence" name=" view_prisoner_sentence">
                        </div>
                      </div> 
                    </div>
                    <div class="col-sm-6 mb-2">
                      <div class="form-group row">
                        <label class="col-sm-3 control-label">Time Serve Starts:</label>
                        <div class="col-sm-8">
                          <input class="form-control" type="date" id="startday" name="view_prisoner_startday">
                        </div>
                      </div> 
                    </div>
                    <div class="col-sm-6 mb-2">
                      <div class="form-group row">
                        <label class="col-sm-3 control-label">Time Serve Ends:</label>
                        <div class="col-sm-8">
                          <input class="form-control" type="date" id="endday" name="view_prisoner_endday">
                        </div>
                      </div> 
                    </div>
                    
                    <div class="col-sm-12 pt-1 pb-2">
                      <h5 class="text-center"> Emergency Contact Details</h5>
                      
                    </div>
                    <div class="col-sm-12 mb-2">
                      <div class="form-group row">
                        <label class="col-sm-3 control-label">Emergency Contact Name:</label>
                        <div class="col-sm-7">
                          <input class="form-control" type="text" value="" name="view_prisoner_emergency_name" id="view_prisoner_emergency_name">
                        </div>
                      </div> 
                    </div>
                    <div class="col-sm-6 mb-2">
                      <div class="form-group row">
                        <label class="col-sm-4 control-label">Contact:</label>
                        <div class="col-sm-8">
                          <input class="form-control" type="text" value="" id="view_prisoner_emergency_contact" name="view_prisoner_emergency_contact">
                        </div>
                      </div> 
                    </div>
                    <div class="col-sm-6 mb-2">
                      <div class="form-group row">
                        <label class="col-sm-4 control-label">Relation:</label>
                        <div class="col-sm-8">
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
                    <!-- <div class="col-sm-12 mt-2">
                      <input type="submit" name="add_view_prisoner_submit" class="btn btn-primary" value="Save Changes">
                      <span></span>
                      <button type="button" class="close btn btn-warning" data-dismiss="modal" aria-label="Close">Cancel</button>
                      
                    </div> -->
                  </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- records -->
<div class="modal fade" id="records_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Records---> <span id="record_prisoner_name"></span>[ <span id="record_prisoner_id"></span> ]</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
          <table class="table table-bordered table-responsive-md list_table" id="list_table10000">
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
          <div class="form-group">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary send_records">Send message</button>
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