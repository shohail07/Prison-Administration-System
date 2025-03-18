<?php
define("PAGE_NAME","Request Section");



session_start();
session_regenerate_id(true);



require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php');

checksame();
$approved_status_comment= approve();

if (isset($_POST['change_pass'])) {
  $_SESSION[pass_openssl_2_enc('password_change_trigger')] = pass_openssl_2_enc('change mode for logged user');
  header('location:../config/verification.php');
}


// inbox
$data = getData();
$reciver = $data['unique_id_php'];


$sql_crime ="SELECT * FROM request where unique_id = '$reciver';";
$result_sql_crime = mysqli_query($connect, $sql_crime);




if (isset($_POST['add_prisoner_submit'])) {

    $prisoner_id = mysqli_real_escape_string($connect, $_POST['prisoner_id']);
    $prisoner_name = mysqli_real_escape_string($connect, $_POST['prisoner_name']  );
    $prisoner_dob = mysqli_real_escape_string($connect, $_POST['prisoner_dob'] );
    $prisoner_emergency_relation = mysqli_real_escape_string($connect, $_POST['prisoner_emergency_relation']);
    $file = $_FILES['prisoner_photo']['name'];
   
    $file_loc = $_FILES['prisoner_photo']['tmp_name'];
    $imageFileType = pathinfo($file,PATHINFO_EXTENSION);
    $folder=$_SERVER['DOCUMENT_ROOT']."/v3/assets/request/";
    $new_file_name = strtolower($file);
    $final_file0 =str_replace(' ','-',$new_file_name);
    $final_file = $prisoner_id.'_'.getName(5).'_'.$final_file0;
    $prisoner_img = 'request/'.$final_file;
    
    if (move_uploaded_file($file_loc,$folder.$final_file)) {
      
      
      
      
      $answer_upload_sql ="INSERT INTO request(unique_id, prisoner_id, name, dob, relation, img, req, approve) VALUES ('$reciver','$prisoner_id','$prisoner_name','$prisoner_dob','$prisoner_emergency_relation','$prisoner_img','1','pending')";
      // echo $answer_upload_sql;
      if (mysqli_query($connect, $answer_upload_sql)) {
       
        $msg = "Request Send";
        header("Refresh:1");
      }else{
        $msg = "can't added";
        // header("Refresh:1");

      }
     
      
                
    }else{
      $msg = "error";
      header("Refresh:1");

    }

 
 
}

$query= "SELECT *  FROM request where unique_id ='$reciver';";

$edit_btn= '<button type="button" class="btn btn-primary click_re" data-toggle="modal" data-target="#exampleModal"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
</svg> Renew 
</button>';
$edit_btn2= '<button type="button" class="btn btn-WARNING click_re" data-toggle="modal" data-target="#exampleModal"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
</svg> Delete 
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
				
				<td>'.$list_row["prisoner_id"].'</td>
				<td>'.$list_row["name"].'</td>
				<td>'.$list_row["relation"].'</td>
				<td>'.$list_row["approve"].'</td>
				<td>'.$list_row["from_data"].'</td>
				<td>'.$list_row["from_time"].'</td>
				<td>'.$list_row["to_data"].'</td>
				<td>'.$list_row["to_time"].'</td>
				
        <td class="text-capitalize text-primary" data-a='.$val.' data-b='.$val2.'>'.$edit_btn.'</td>
        <td class="text-capitalize text-primary" data-a='.$val.' data-b='.$val2.'>'.$edit_btn2.'</td>
				
			</tr>
		';
	}
	
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php') ?>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  
</head>
<body>
  <?php include_once($_SERVER['DOCUMENT_ROOT'].'/v3/user/user_dashboard.php') ?>

  <script>
                  $(document).ready(function () {
                    var dekhi = '<?php if(mysqli_num_rows($result_sql_crime) > 0){echo 'lock';}else{echo 'unlock';}?>';
        if(dekhi == 'lock'){
          $('form').hide();
          $('.msg').text('You already sent request');
          $('.showing').show();
        }else{
          $('form').show();
          $('.showing').hide();
        }
                  });
                </script>
  <div class="data_show" >
    <div class="text-center text-warning">
  <p class="msg"></p>
    </div>
              <style>
                .col-sm-4{
                  align-self: center;
                }
              </style>


<div class="showing">
<table class="table table-bordered table-responsive-md list_table" id="list_table9999">
                          <thead>
                            <tr class="text-capitalize">
                              <th scope="col">#</th>
                              <th scope="col">Prisoner Photo</th>
                              
                              <th scope="col">prisoner id</th>
                              <th scope="col"> Prisoner Full Name</th>
                              <th scope="col">Relation</th>
                              <th scope="col">approve</th>
                              <th scope="col">From date</th>
                              <th scope="col">From time</th>
                              <th scope="col">To Date</th>
                              <th scope="col">To time</th>
                              
                              <th scope="col">Renew</th>
                              <th scope="col">Delete</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php echo $output_list; ?> 
                          
                          </tbody>
      </table>
</div>

                <form method="POST" enctype="multipart/form-data" >
                  <div class="row pb-5" style="height: 85vh; overflow-y: scroll; ">
                  <?php if(isset($msg)){ echo "<div class='alert alert-info alert-dismissable'>".$msg."</div>";}?>
                    <div class="col-sm-12 pb-5">
                      <h5 class="text-center fw-bold">Request For Visiting Prisoner</h5>
                    </div>
                    <div class="col-sm-12 pb-5 ">
                    <div class="text-center">
                      <div id="preview"><img src="<?php echo img_check('55'); ?>" class="avatar img-circle" width="250px" height="250px" alt="avatar"></div>
                      <h6 class="text-center fw-bold mt-4">Prisoner Photo</h6>
                      <input type="file" id="prisoner_photo" name="prisoner_photo" class="form-control  mt-2"   accept="image/*" required>
                      
                    </div>
                      
                    </div>
                    <div class="col-sm-12 row">
                      <div class="col-sm-5 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-3 control-label">ID:</label>
                          <div class="col-sm-8">
                            <input class="form-control" name="prisoner_id" id="prisoner_id" type="text"  value="" placeholder="Enter the prisoner id" >
                          </div>
                        </div> 
                      </div>
                      
                      
                      <div class="col-sm-5 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-3 control-label">Prisoner Name:</label>
                          <div class="col-sm-8">
                            <input class="form-control" name="prisoner_name" id="prisoner_name" type="text" value="" required>
                          </div>
                        </div> 
                      </div>
                      <div class="col-sm-5 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-3 control-label">Date of Birth:</label>
                          <div class="col-sm-8">
                            <input class="form-control" type="date" name="prisoner_dob" id="prisoner_dob" value="">
                          </div>
                        </div> 
                      </div>
                      
                      <div class="col-sm-5 mb-2">
                      <div class="form-group row">
                        <label class="col-sm-3 control-label">Relation:</label>
                        <div class="col-sm-8">
                          <input class="form-control" type="text" id="prisoner_emergency_relation" name="prisoner_emergency_relation" >
                        </div>
                      </div> 
                    </div>
                    <div class="col-sm-5 mt-auto">
                      <input type="submit" name="add_prisoner_submit" class="btn btn-primary" value="Send Request">
                      <span></span>
                      <input type="reset" class="btn btn-warning" value="Cancel">
                    </div>
                      
                    </div>
                    
                    
                    
                   
                  </div>
                </form>
             
            </div>


               <!-- Modal -->
               <!-- Modal -->

     
</section>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                
    <script>
      $(document).ready(function() {

        $('.click_re').click(function (e) { 
          e.preventDefault();
          var rule_id= $(this).parent().attr("data-b");
          var approve=$('.click_re').text();
          console.log(approve);
          myGlobalVariable = rule_id;
          $.ajax({
            type: "POST",
            url: "update.php",
            data:  {'id': rule_id, 'approve': approve},
            dataType: "text",
            success: function (response) {
              var response = $.trim(response);
              location.reload()
            }
          });
          
        });
        $('.click_del').click(function (e) { 
          e.preventDefault();
          var rule_id= $(this).parent().attr("data-b");
          myGlobalVariable = rule_id;
          $.ajax({
            type: "POST",
            url: "update.php",
            data:  {'id': rule_id, 'approve': 'del'},
            dataType: "text",
            success: function (response) {
              var response = $.trim(response);
              location.reload()
            }
          });
          
        });

        $("#prisoner_crimes").select2({
          
        });
        $(".calculate").click(function(e) {
          e.preventDefault();
          console.log(5);
          var startDate = new Date($("#startday").val());
          var endDate = new Date($("#endday").val());
          var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
          var dayCount = Math.ceil(timeDiff / (1000 * 3600 * 24));
  
          $("#sentence").val(dayCount);
        });
        $("#prisoner_photo").change(function (e) {
          var file = this.files[0];
          console.log(file);
          myGlobalVariable = file;
          var reader = new FileReader();
          console.log(reader);
          reader.onload = function(event) {
            var img = $('<img>').attr('src', event.target.result).attr('class', 'avatar img-circle').attr('width', '250px').attr('height', '250px').attr('alt', 'avatar');
            
            $('#preview').html(img);
            $('.update_photo').show();
            
          };
          
          // Read the file as a data URL
          reader.readAsDataURL(file); 
          e.preventDefault();
          
        });
        $('.back a').click(function (e) { 
              e.preventDefault();
              history.back();
              
            });

        
        
      });
    </script>
    <script>
  $(document).ready(function () {
    $('#list_table9999').DataTable({
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