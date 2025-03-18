<?php
define("PAGE_NAME","Add Prisoner");




session_start();
session_regenerate_id(true);

// print_r($_SESSION);


require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php');

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


// inbox
$data = getData();
$reciver = $data['unique_id_php'];

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
$sql_crime ="SELECT * FROM crime where status = 'yes';";
$result_sql_crime = mysqli_query($connect, $sql_crime);
$crime_list='';
if(mysqli_num_rows($result_sql_crime) > 0)
{
	
  
	while($list_crime = mysqli_fetch_array($result_sql_crime))
	{ 
    $cell_no =$list_crime['value'];
    $max =$list_crime['name'];
    
    

   
      $crime_list.= '<option value="'.$cell_no.'">'.$max.'</option>';
    
    
    
    
		
	}
	
}


if (isset($_POST['add_prisoner_submit'])) {

    $prisoner_id = mysqli_real_escape_string($connect, $_POST['prisoner_id']);
    $cell_no = mysqli_real_escape_string($connect, $_POST['cell_no'] );
    $prisoner_visitor = mysqli_real_escape_string($connect, $_POST['prisoner_visitor'] );
    $prisoner_name = mysqli_real_escape_string($connect, $_POST['prisoner_name']  );
    $prisoner_dob = mysqli_real_escape_string($connect, $_POST['prisoner_dob'] );
    $prisoner_address = mysqli_real_escape_string($connect, $_POST['prisoner_address']  );
    $prisoner_marital = mysqli_real_escape_string($connect, $_POST['prisoner_marital']);
    $prisoner_complexion = mysqli_real_escape_string($connect, $_POST['prisoner_complexion'] );
    $prisoner_eye = mysqli_real_escape_string($connect, $_POST['prisoner_eye']  );
    $prisoner_crimes = $_POST['prisoner_crimes'] ;
    $prisoner_sentence = mysqli_real_escape_string($connect, $_POST['prisoner_sentence']  );
    $prisoner_startday = mysqli_real_escape_string($connect, $_POST['prisoner_startday']  );
    $prisoner_endday = mysqli_real_escape_string($connect, $_POST['prisoner_endday'] );
    $prisoner_emergency_name = mysqli_real_escape_string($connect, $_POST['prisoner_emergency_name']  );
    $prisoner_emergency_contact = mysqli_real_escape_string($connect, $_POST['prisoner_emergency_contact'] ); 
    $prisoner_emergency_relation = mysqli_real_escape_string($connect, $_POST['prisoner_emergency_relation']);
    $file = $_FILES['prisoner_photo']['name'];
    $string1 = mysqli_real_escape_string($connect,implode(', ', $prisoner_crimes));
    $file_loc = $_FILES['prisoner_photo']['tmp_name'];
    $imageFileType = pathinfo($file,PATHINFO_EXTENSION);
    $folder=$_SERVER['DOCUMENT_ROOT']."/v3/assets/prisoner_img/";
    $new_file_name = strtolower($file);
    $final_file0 =str_replace(' ','-',$new_file_name);
    $final_file = $prisoner_id.'_'.getName(5).'_'.$final_file0;
    $prisoner_img = 'prisoner_img/'.$final_file;
    
    if (move_uploaded_file($file_loc,$folder.$final_file)) {
      
      $districts_sql ="SELECT * FROM cell_data WHERE cell_no='$cell_no';";
      $selection_option_result = mysqli_query($connect, $districts_sql);
      $list_row_option = mysqli_fetch_array($selection_option_result);
      $booked =$list_row_option['booked'];
      $booked = (int) $booked;
      $add = $booked + 1;
      $update_sql = "UPDATE cell_data SET booked='$add' WHERE cell_no='$cell_no';";
      
      $answer_upload_sql ="INSERT INTO prisoner_list(unique_id, cell_no, visitor, name, prisoner_img, address, dob, marital, complexion, eye, crimes, sentence, start_time, end_time, emergency_name, emergency_phone, emergency_relation) VALUES ('$prisoner_id','$cell_no','$prisoner_visitor','$prisoner_name','$prisoner_img','$prisoner_address','$prisoner_dob','$prisoner_marital','$prisoner_complexion','$prisoner_eye','$string1','$prisoner_sentence','$prisoner_startday','$prisoner_endday','$prisoner_emergency_name','$prisoner_emergency_contact','$prisoner_emergency_relation');";
      // echo $answer_upload_sql;
      if (mysqli_query($connect, $answer_upload_sql)) {
        mysqli_query($connect, $update_sql);
        $msg = "Added";
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/header.php') ?>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  
</head>
<body>
  <?php include_once($_SERVER['DOCUMENT_ROOT'].'/v3/user/user_dashboard.php') ?>


  <div class="data_show" >
              <style>
                .col-sm-4{
                  align-self: center;
                }
              </style>
<div class="back text-left"><a href="#" class="btn btn-warning" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
</svg></a></div>
                <form method="POST" enctype="multipart/form-data" >
                  <div class="row pb-5" style="height: 85vh; overflow-y: scroll; ">
                  <?php if(isset($msg)){ echo "<div class='alert alert-info alert-dismissable'>".$msg."</div>";}?>
                    <div class="col-sm-12 pb-5">
                      <h5 class="text-center fw-bold">Add Prisoner</h5>
                    </div>
                    <div class="col-sm-3 ">
                    <div class="text-center">
                      <div id="preview"><img src="<?php echo img_check('user_img'); ?>" class="avatar img-circle" width="250px" height="250px" alt="avatar"></div>
                      
                      <input type="file" id="prisoner_photo" name="prisoner_photo" class="form-control mt-2"   accept="image/*" required>
                      
                    </div>
                      <h6 class="text-center fw-bold mt-4">Prisoner Photo</h6>
                    </div>
                    <div class="col-sm-9 row">
                      <div class="col-sm-5 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-3 control-label">ID:</label>
                          <div class="col-sm-8">
                            <input class="form-control" name="prisoner_id" id="prisoner_id" type="text"  value="<?php echo time();?>" readonly>
                          </div>
                        </div> 
                      </div>
                      <div class="col-sm-5 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-3 control-label">Cell No:</label>
                          <div class="col-sm-8">
                            <select name="cell_no" id="prisoner_cell" class="form-control" required>
                              <option value="">Select  cell</option>
                              <?php echo $cell_list;?>
                            </select>
                          </div>
                        </div> 
                      </div>
                      <div class="col-sm-5 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-3 control-label">Visitor Access:</label>
                          <div class="col-sm-8">
                          <select name="prisoner_visitor" id="prisoner_visitor" class="form-control" required>
                              <option value="">Select </option>
                              <option value="allow">Allowed</option>
                              <option value="not">Not Allow</option>
                            </select>
                          </div>
                        </div> 
                      </div>
                      <div class="col-sm-5 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-3 control-label">Name:</label>
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
                          <label class="col-sm-3 control-label">Address:</label>
                          <div class="col-sm-8">
                            <input class="form-control" type="text" name="prisoner_address" id="prisoner_address" value="">
                          </div>
                        </div> 
                      </div>
                      <div class="col-sm-5 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-3 control-label">Marital Status:</label>
                          <div class="col-sm-8">
                            <input class="form-control" type="text" value="" name="prisoner_marital" id="prisoner_marital">
                          </div>
                        </div> 
                      </div>
                      <div class="col-sm-5 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-3 control-label">Complexion:</label>
                          <div class="col-sm-8">
                            <input class="form-control" type="text" value="" name="prisoner_complexion" id="prisoner_complexion">
                          </div>
                        </div> 
                      </div>
                      <div class="col-sm-5 mb-2">
                        <div class="form-group row">
                          <label class="col-sm-3 control-label">Eye Color:</label>
                          <div class="col-sm-8">
                            <input class="form-control" type="text" value="" name="prisoner_eye" id="prisoner_eye">
                          </div>
                        </div> 
                      </div>
                      
                    </div>
                    <div class="col-sm-12 pt-1 pb-2">
                      <h5 class="text-center"> Case info</h5>
                      
                    </div>
                    <div class="col-sm-10 mb-2">
                      <div class="form-group row">
                        <label class="col-sm-2 control-label">Crimes Committed:</label>
                        <div class="col-sm-10">
                          <!-- <input class="form-control" type="text" value="" name="prisoner_crimes" id="prisoner_crimes"> -->
                          <select  name="prisoner_crimes[]" id="prisoner_crimes" class="form-control" multiple>
                              <option value="">Select  cell</option>
                              <?php echo $crime_list;?>
                            </select>
                        </div>
                      </div> 
                    </div>
                    
                    <div class="col-sm-5 mb-2">
                      <div class="form-group row">
                        <label class="col-sm-4 control-label">Time Serve Starts:</label>
                        <div class="col-sm-8">
                          <input class="form-control" type="date" id="startday" name="prisoner_startday">
                        </div>
                      </div> 
                    </div>
                    <div class="col-sm-5 mb-2">
                      <div class="form-group row">
                        <label class="col-sm-4 control-label">Time Serve Ends:</label>
                        <div class="col-sm-8">
                          <input class="form-control" type="date" id="endday" name="prisoner_endday">
                        </div>
                      </div> 
                    </div>
                    <div class="col-sm-2 mb-2">
                      <a href="#" class="calculate btn-success btn">Calculate</a>
                    </div>
                    <div class="col-sm-5 mb-2">
                      <div class="form-group row">
                        <label class="col-sm-4 control-label">Sentence [days]:</label>
                        <div class="col-sm-8">
                          <input class="form-control" type="text" value=" " id="sentence" name=" prisoner_sentence"  readonly>
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
                          <input class="form-control" type="text" value="" name="prisoner_emergency_name" id="prisoner_emergency_name">
                        </div>
                      </div> 
                    </div>
                    <div class="col-sm-5 mb-2">
                      <div class="form-group row">
                        <label class="col-sm-4 control-label">Contact:</label>
                        <div class="col-sm-8">
                          <input class="form-control" type="text" value="" id="prisoner_emergency_contact" name="prisoner_emergency_contact">
                        </div>
                      </div> 
                    </div>
                    <div class="col-sm-5 mb-2">
                      <div class="form-group row">
                        <label class="col-sm-4 control-label">Relation:</label>
                        <div class="col-sm-8">
                          <input class="form-control" type="text" id="prisoner_emergency_relation" name="prisoner_emergency_relation" >
                        </div>
                      </div> 
                    </div>
                    <div class="col-sm-5 mt-2">
                      <input type="submit" name="add_prisoner_submit" class="btn btn-primary" value="Save Changes">
                      <span></span>
                      <input type="reset" class="btn btn-warning" value="reset">
                    </div>
                  </div>
                </form>
             
            </div>
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
</body>
</html>