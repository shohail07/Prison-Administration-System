<?php

define("PAGE_NAME","Web Settings");

require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php');

// if (!userloggedin()) {
//   header('location:logout.php');
// }
$data = getData();
if ($_SESSION[pass_openssl_2_enc('status')] !== pass_openssl_enc('online') || $data['role'] !== 'admin') {
  header('location:logout.php');
}
$approved_status_comment= approve();

$query= "SELECT *  FROM menu ";

$edit_btn= '<button type="button" class="btn btn-primary click_edit" data-toggle="modal" data-target="#edit_modal_pop"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
</svg> Edit
</button>';


$list_result = mysqli_query($connect, $query);
if(mysqli_num_rows($list_result) > 0)
{
	
  $i =0;
  $output_list='';
	while($list_row = mysqli_fetch_array($list_result))
	{ $i++;
    $val= pass_openssl_2_enc($list_row["id"]);
		$output_list .= '
			<tr>
				<td>'.$i.'</td>
				<td class="text-capitalize">'.$list_row["page_name"].'</td>
				<td class="text-lowercase">'.$list_row["page_link"].'</td>
				<td class="text-capitalize">'.$list_row["role"].'</td>
				<td class="text-capitalize">'.$list_row["status"].'</td>
				<td class="text-capitalize text-primary" data-a='.$val.'>'.$edit_btn.'</td>
			</tr>
		';
	}
	
}


// if (isset($_POST['add_page_submit'])){
//     // $add_rule_value = strtolower(mysqli_real_escape_string($connect, $_POST['add_rule_name']));
//     // $add_rule_name = mysqli_real_escape_string($connect, $_POST['add_rule_name']);
//     // $add_rule_audience = mysqli_real_escape_string($connect, $_POST['add_audience']);
//     // if($add_rule_audience =='0'){
//     //   // $msg = "can't submit";
//     // }else{
//     //   $firstsql = "SELECT *  FROM rule_names WHERE rule_names.value_rule ='$add_rule_value';";
//     //   $result = mysqli_query($connect, $firstsql);
//     //   $row = mysqli_fetch_array($result);
//     //   if(mysqli_num_rows($result) == 1){
//     //     $msg = "Already present";
//     //   }else{
//     //     $insertsql=  "INSERT INTO rule_names (id, value_rule, rule_name, audience) VALUES (NULL,'$add_rule_value', '$add_rule_name', '$add_rule_audience')";
//     //     mysqli_query($connect, $insertsql);
//     //     // header("Refresh:0");
        
//     //   }
//     // }
    
//     echo 'off';

// }

$menu ="SELECT * FROM rule_names ";
$selection_option_result = mysqli_query($connect, $menu);
$menulist2='<option value="admin">admin</option>';
if(mysqli_num_rows($selection_option_result) > 0)
{
	
  
	while($list_row_option = mysqli_fetch_array($selection_option_result))
	{ 
      $val =$list_row_option['value_rule'];
      $menulist2 .= '<option value="'.$val.'">'.$val.'</option>';
    
		
	}


	
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php') ?>
  
</head>

<style>
  *{
    scrollbar-width: none;
  }
  .menu_table::-webkit-scrollbar {
    display: none;
    -ms-overflow-style: none;  
    scrollbar-width: none;
  }


  
</style>

<body>
  <?php include_once($_SERVER['DOCUMENT_ROOT'].'/v3/user/user_dashboard.php') ?>


  <div class="data_show">
    
    <div class="text-center text-danger"style="font-weight: bold;">
      <?php echo $approved_status_comment; ?>
    </div>
    
    <?php require_once('setting_list.php')?>
      
     
    <div id="settings_list_output">
        <h2 class="text-center text-capitalize"style="font-weight: bold;">menu settings</h2>

        <div class="adding roles">
          <!-- Button trigger add modal -->
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#add_page_modal_trigger">
              Add page
            </button>

            <!-- add modal -->
            <div class="modal fade" id="add_page_modal_trigger" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Rule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form  method="POST" class="add_page_form">
                      <div class="modal-body">
                      <div class="text-danger msg_role text-center" style="font-weight: bold;height:30px">  </div>
                      <div class="form-group">
                        <label for="add_page_name">Page Name:</label>
                        <input type="text" class="form-control" id="add_page_name" name="add_page_name" aria-describedby="emailHelp" value="" required>
                      </div>
                      <div class="form-group">
                        <label for="add_page_folder">Page Folder:</label>
                        <input type="text" class="form-control" id="add_page_folder" name="add_page_folder" aria-describedby="emailHelp" value="" required>
                      </div>
                      <div class="form-group">
                        <label for="add_page_link">Page Link:</label>
                        <input type="text" class="form-control" id="add_page_link" name="add_page_link" aria-describedby="emailHelp" value="" required>
                      </div>
                      <div class="form-group">
                        <label for="add_page_role">Page Role:</label>
                        <!-- <input type="text" class="form-control" id="add_page_role" name="add_page_role" aria-describedby="emailHelp" value="" required> -->
                        <select class="form-control" id="add_page_role" name="add_page_role" required>
                          <option value="">Select a Role</option>
                          <?php echo $menulist2;?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="add_page_status">Page Status:</label>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="add_page_status" id="inlineRadio1" value="yes" required>
                          <label class="form-check-label" for="inlineRadio1">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="add_page_status" id="inlineRadio2" value="no">
                          <label class="form-check-label" for="inlineRadio2">No</label>
                        </div>
                      </div>
                      </div>
                      <div class="modal-footer pt-2">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary add_page_submit" name="add_page_submit" value="ADD">
                      </div>
                  </form>
                </div>
              </div>
            </div>

        </div>
        <div class="text-danger msg_role text-center" style="font-weight: bold;height:30px"><?php if(isset($msg)){echo $msg;}?>  </div>

          <div class=" container menu_table" style="width: 70vw;">

          <table class="table table-bordered table-responsive-md list_table" id="myTable2">
                          <thead>
                            <tr style="background-color: #38000e; color:fff">
                              <th scope="col">#</th>
                              <th scope="col">Page Name</th>
                              <th scope="col">Page link</th>
                              <th scope="col">Role</th>
                              <th scope="col">Page Status</th>
                              <th scope="col">Edit</th>


                            </tr>
                          </thead>
                          <tbody>
                            <?php echo $output_list; ?> 
                          
                          </tbody>
            </table>
    </div>



      <!-- Modal -->
      <div class="modal fade" id="edit_modal_pop" tabindex="-1" role="dialog" aria-labelledby="edit_modal_pop_label" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="edit_modal_pop_label">Edit Menu</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form autocomplete="off" method="POST">
              <div class="modal-body">
                <div class="text-danger msg_role text-center" style="font-weight: bold;height:30px">  </div>
                <div class="form-group">
                  <label for="Page_Name_menu">Page Name:</label>
                  <input type="text" class="form-control" id="Page_Name_menu" aria-describedby="emailHelp" value="">
                </div>
                <div class="form-group">
                  <label for="Page_link_menu">Page Link:</label>
                  <input type="text" class="form-control" id="Page_link_menu" value="">
                </div>
                <div class="form-group">
                  <label for="Page_role_menu">Page Role:</label>
                  <select id="Page_role_menu" class="form-select text-capitalize" aria-label="Default select example" >
                    
                    
                    <option  value="0">Change Role</option>
                
                  </select>
                </div>
                <div class="form-group ">
                  <label for="Page_status_menu" id="Page_status_menu_label">Page Status:</label>
                  
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="yes" >
                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="no">
                    <label class="form-check-label" for="inlineRadio2">No</label>
                  </div>
                </div>

                
                
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <input type="button" class="btn btn-primary update_btn_role" name="update" value="Update">
              </div>
            </form>
          </div>
        </div>
      </div>


      </div>

    

  </div>


  


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>  


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
  var myGlobalVariable;
  $('.click_edit').click(function () {
    
          var rule_id= $(this).parent().attr("data-a");
          myGlobalVariable = rule_id;
          console.log(rule_id);
          $.ajax({
            type: "POST",
            url: "menu_find.php",
            data: {'id': rule_id, 'update': 'no'},
            dataType: "json",
            success: function (data) {
              var page_name = data.page_name;
              var page_link = data.page_link;
              var role = data.role;
              var status = data.status;
              myGlobalVariable1 = page_name;
              myGlobalVariable2 = page_link;
              myGlobalVariable3 = role;
              myGlobalVariable4 = status;
              console.log(data);
               
              $.ajax({
                type: "POST",
                url: "options_find.php",
                data: {'role': role, 'hiden_f': 'rule_name'},
                dataType: "html",
                success: function (response) {
                  console.log(response);
                  $('#Page_role_menu').append(response);
                }
              });
             
              $('#Page_Name_menu').val(page_name);
              
              $('#Page_link_menu').val(page_link);
              $('#role').val(role);
              if (status == "yes") {
                console.log(5);
                // jQuery('#inlineRadio1').attr('checked',true);
                jQuery("input[value='yes']").attr('checked', true);
                $('#inlineRadio2').removeAttr('checked');
              }else{
                $('#inlineRadio1').removeAttr('checked');
                jQuery("input[value='no']").attr('checked', true);
                $('#inlineRadio2').attr('checked');
              }
              
             
              
            }
          });
          
          // e.preventDefault();
          
        });
        $(".update_btn_role").click(function (e) { 
            var rule_id= myGlobalVariable;
            var page_name = myGlobalVariable1;
            var page_link = myGlobalVariable2;
            var role = myGlobalVariable3;
            var status = myGlobalVariable4;
            var Page_Name_menu =  $('#Page_Name_menu').val();
            var Page_link_menu =  $('#Page_link_menu').val();
            var Page_role_menu =  $('#Page_role_menu').val();
            var Page_status_menu=$('input[name=inlineRadioOptions]:radio:checked').val();
            // if ($('#inlineRadio1').prop('checked')) {
            //    var Page_status_menu= "yes";
            //   } else {
            //     var Page_status_menu="no";
            //   }
              
                $.ajax({
                    type: "POST",
                    url: "menu_find.php",
                    data: {'id': rule_id,'update': 'yes','Page_Name_menu': Page_Name_menu,'Page_link_menu': Page_link_menu,'Page_role_menu': Page_role_menu,'Page_status_menu': Page_status_menu},
                    dataType: "text",
                    success: function (response) {
                      location.reload();
                      
                    }
                });
              
              
         
          
        });
       
});
  
</script>

<script>
  $(document).ready(function () {
    $('.add_page_form').submit(function (e) { 
      e.preventDefault();
      console.log('ok');
      var formData = $(this).serialize();
      console.log(formData);
      // location.reload(); 
      $.ajax({
        type: "POST",
        url: "add_page.php",
        data: formData,
        dataType: "text",
        success: function (response) {
          var response = $.trim(response);
          
            console.log('response');
            $('.msg_role').text(response);
            setTimeout(function() {$('.msg_role').fadeOut();}, 1000);
            location.reload();
          
        }
      });
    });
  });
</script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script>
  $(document).ready(function () {
    $('#myTable2').DataTable({
          searching: false,
          paging: false,
          "showNEntries" : false,
          scrollY:        350,
          deferRender:    true,
          scroller:       true
        });
  });
</script>






