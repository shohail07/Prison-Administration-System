$(document).ready(function() {
    
    $("#upload_click").click(function(e) {
        e.preventDefault(); // prevent form submission
        var form_data = $('#upload_profile_photo').val(); // create a FormData object
        console.log(form_data);
        $.ajax({
            url: "../../config/upload_photo.php", // server script to handle the file upload
            type: "POST",
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                // handle success
            },
            error: function(xhr, status, error) {
                // handle error
            }
        });
    });
});

$(document).ready(function () {
    $('#list_table10').DataTable({
          searching: false,
          paging: false,
          "showNEntries" : false,
          scrollY:        350,
          deferRender:    true,
          scroller:       true
        });
  });
