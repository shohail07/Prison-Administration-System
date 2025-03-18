<?php

define("PAGE_NAME","Crime Management");

require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php');

// if (!userloggedin()) {
//   header('location:logout.php');
// }
$data = getData();

$approved_status_comment= approve();

$query= "SELECT *  FROM crime ";

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
				<td class="text-capitalize">'.$list_row["value"].'</td>
				<td class="text-capitalize">'.$list_row["status"].'</td>
				<td class="text-capitalize text-primary" data-a='.$val.'>'.$edit_btn.'</td>
			</tr>
		';
	}
	
}else{
  $output_list='';
}


if (isset($_POST['add_rule_submit'])){
    $add_rule_value = strtolower(mysqli_real_escape_string($connect, $_POST['add_rule_name']));
    $add_rule_name = mysqli_real_escape_string($connect, $_POST['add_rule_name']);
    $add_rule_audience = mysqli_real_escape_string($connect, $_POST['add_audience']);
    if($add_rule_audience =='0'){
      $msg = "can't submit";
    }else{
      $firstsql = "SELECT *  FROM crime WHERE crime.value ='$add_rule_value';";
      $result = mysqli_query($connect, $firstsql);
      $row = mysqli_fetch_array($result);
      if(mysqli_num_rows($result) == 1){
        $msg = "Already present";
      }else{
        $insertsql=  "INSERT INTO crime (id, value, name, status) VALUES (NULL,'$add_rule_value', '$add_rule_name', '$add_rule_audience')";
        mysqli_query($connect, $insertsql);
      //  header("Refresh:0");
      header("Location: ".$_SERVER['PHP_SELF']);

      }
    }
    

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php') ?>
  
</head>


<style>
          :root {

        --theadColor: #38000e;

        --theadTextColor: #fff;

        --darkColor:#000;

        --lightColor:#fff;

        --darkRowColor: #e8003a;

        }

        body {

              font-family: "Open Sans", sans-serif;

            }

            table.dataTable {

            border:1px solid #000;

          

            }

            th,tr,td

            {

              border-color: #000 !important;
              text-align: center!important;    }

            thead {

              background-color: var(--theadColor);

              

            }

            thead > tr,

            thead > tr > th {

              background-color: transparent;

              color: var(--theadTextColor) !important;

              font-weight: normal;

              text-align: start;

            }

            table.dataTable thead th,

            table.dataTable thead td {

              border-bottom: 0px solid #111 !important;

            }

            .dataTables_wrapper > div {

              margin: 5px;

            }

            table.dataTable.display tbody tr.even > .sorting_1,

            table.dataTable.order-column.stripe tbody tr.even> .sorting_1, 

            table.dataTable.display   tbody tr.even,

            table.dataTable.display tbody tr.odd > .sorting_1,

            table.dataTable.order-column.stripe tbody tr.odd > .sorting_1,

            table.dataTable.display tbody tr.odd {

              background-color: var(--darkRowColor);

              color:var(--lightColor);

            }

            table.dataTable thead th {

              position: relative;

              background-image: none !important;

            }

            table.dataTable thead th.sorting:after,

            table.dataTable thead th.sorting_asc:after,

            table.dataTable thead th.sorting_desc:after {

              position: absolute;

              top: 12px;

              right: 8px;

              display: block;

              font-family: "Font Awesome\ 5 Free";

            }

            table.dataTable thead th.sorting:after {

              content: "\f0dc";

              color: #ddd;

              font-size: 0.8em;

              padding-top: 0.12em;

            }

            table.dataTable thead th.sorting_asc:after {

              content: "\f0de";

            }

            table.dataTable thead th.sorting_desc:after {

              content: "\f0dd";

            }

            table.dataTable.display tbody tr:hover > .sorting_1,

            table.dataTable.order-column.hover tbody tr:hover > .sorting_1,

            tbody tr:hover {

              background-color: var(--darkColor) !important;

              color: #fff;

            }

            .dataTables_wrapper .dataTables_paginate .paginate_button.current, 

            .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {

                  background: none !important;

                  border-radius: 50px;

              background-color: var(--theadColor) !important;

              color:var(--lightColor) !important

            }

            

            

            .dataTables_wrapper .dataTables_paginate .paginate_button {

                  background: none !important;

              color:var(--darkColor) !important

            }

        .paginate_button.current:hover

        {

              background: none !important;

                  border-radius: 50px;

                  background-color: var(--theadColor) !important;

              color:#fff !important

        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover,

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {

        border: 1px solid #979797;

        background: none !important;

        border-radius: 50px !important;

        background-color: #000 !important;

        color: #fff !important;

        }
        #myTable_info{
          display: none;
        }
</style>
<body>
  <?php include_once($_SERVER['DOCUMENT_ROOT'].'/v3/user/user_dashboard.php') ?>


  <div class="data_show">
    
    <div class="text-center text-danger"style="font-weight: bold;">
      <?php echo $approved_status_comment; ?>
    </div>
    
   
      
     
    <div id="settings_list_output">
        <h2 class="text-center"style="font-weight: bold;">Crime Management</h2>

        <div class="adding roles">
          <!-- Button trigger modal -->
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModalCenter">
              Add new crime parameter
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Crime Management</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form  method="POST">
                  <div class="modal-body pb-5">
                    
                  <div class="form-group">
                         <label for="add_rule_name">Enter Crime Name</label>
                         <input type="text" class="form-control" name="add_rule_name" id="add_rule_name" aria-describedby="helpId" placeholder="" required>
                       </div>
                       <div class="form-group">
                          <label for="add_audience">Select Status</label>
                          <select id="add_audienes" class="form-select text-capitalize" aria-label="Default select example" id="add_audience" name="add_audience">
                            <option value="0">---Select Status ---</option>
                            <option value="yes">yes</option>
                            <option value="no">no</option>
                          </select>
                       </div>
                       
                    
                  </div>
                  <div class="modal-footer pt-2">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary add_rule_submit" name="add_rule_submit" value="add">
                  </div>
                  </form>
                </div>
              </div>
            </div>

        </div>
        <div class="text-danger msg_role text-center" style="font-weight: bold;height:30px"><?php if(isset($msg)){echo $msg;}?>  </div>

          <div class="pt-5 container" style="width: 70vw;">

          <table class="table table-bordered table-responsive-md list_table" id="myTable">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Name</th>
                              <th scope="col">Status</th>
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
              <h5 class="modal-title" id="edit_modal_pop_label">Edit Role</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form autocomplete="off">
              <div class="modal-body">
                
                <div class="text-capitalize">
                  <p>Crime Name: <span id="name"></span></p>
                  <p>Current Status: <span id="audience"></span></p>
                </div>
                <div class="p-2">
                <div class="text-danger msg_role text-center" style="font-weight: bold;height:30px">  </div>
                  <label for="exampleFormControlSelect1">Change Audience</label>
                  <select id="myselect" class="form-select text-capitalize" aria-label="Default select example" id="exampleFormControlSelect1">
                            <option value="0">---Select Status ---</option>
                            <option value="yes">yes</option>
                            <option value="no">no</option>
                  </select>
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


  


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>  
<script>
$(document).ready(function () {
  var myGlobalVariable;
  $('.click_edit').click(function () {
          var rule_id= $(this).parent().attr("data-a");
          myGlobalVariable = rule_id;
          console.log(rule_id);
          $.ajax({
            type: "POST",
            url: "admin_find.php",
            data: {'id': rule_id, 'update': 'no'},
            dataType: "json",
            success: function (data) {
              var name = data.rule_name;
              var audience = data.audience;
              
              $('#name').html(name);
              $('#audience').html(audience);
            }
          });
          
          // e.preventDefault();
          
        });
        $(".update_btn_role").click(function (e) { 
         
          var myselect_val = $( "#myselect" ).val();
          var rule_id= myGlobalVariable;
          var audience = $('#audience').text();
          
          console.log(rule_id);
          if(myselect_val == '0'){
            $msg = 'Select audience';
            $('.msg_role').html($msg);
            e.preventDefault();
          }else{
            
            if(myselect_val == audience){
              $msg = 'Change audience';
            $('.msg_role').html($msg);
            
            }else{
              $.ajax({
              type: "POST",
              url: "admin_find.php",
              data: {'id': rule_id,'update': 'yes','audience': myselect_val},
              dataType: "text",
              success: function (response) {
                console.log(response);
                if(response =='ok'){
                  console.log('response');
                  
                  // location.reload(true);
                }
                location.reload();
              }
            });
            }
          }
            
          
        });
       
});
  
</script>
  <!-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script> -->

<script>
  $('#myTable').DataTable({
    searching: false,
          paging: false,
          "showNEntries" : false,
          scrollY:        350,
          deferRender:    true,
          scroller:       true
        });
        
</script>






