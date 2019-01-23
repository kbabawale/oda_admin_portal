<?php 
if(isset($_GET['id'])){
    $id = $_GET['id'];
}
?>

<input type="hidden" name="currentUser" id="currentUser" value="<?= $id; ?>" />
<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-user-md"></i> <span id="userNameSpan">Edit Market Leader</span>
    </div>
    <div class="card-body">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form id="editadminform">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Full Name</label>
                        <input type="text" class="form-control" id="fullName" name="fullName" placeholder="John Appleseed" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Mobile</label>
                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="080123456789" required>
                    </div>
                    <input type="hidden" id="refererCode" name="refererCode" value="<?= $id; ?>" />
                    
                    <div class="form-group">
                    <button type="submit" class="btn btn-success form-control" id="editbutton">Edit Market Leader</button>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>

<script>

    var Token = $('#Token').val();
    var user = $('#currentUser').val();
    var nothing = '';
    //load user's details on form fields
    var showUserDetails = ()=>{
        $.ajax({
            url: '/api/admin/marketlead/all',
            beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
            type: 'POST',
            data: "refererCode="+user,
            success: function(xhtR) {
                $('#fullName').val(xhtR.marketlead['fullName']);
                $('#mobile').val(xhtR.marketlead['mobile']);
            },
            error: function(request, status, error){
                request = JSON.parse(request.responseText);
                $('#errormsg').removeClass('alert-warning').removeClass('alert-success').addClass('alert-danger').fadeIn('slow','linear',function(){
                    $(this).html(request.statusMsg);
                });
                loadMarketLeaders(nothing);
                setTimeout(closeAlert, 3000);
            }
        });
    };

    showUserDetails();

$("#editbutton").click((e)=>{
    e.preventDefault();
    $('#editbutton')
    .text('Loading...');

    $.ajax({
        url: '/api/admin/marketlead/update',
        type: 'POST',
        beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
        data: $('#editadminform').serialize(),
        success: function(xhtR) {
            $('#editbutton')
            .text('Edit Market Leader');
            
            $('#errormsg').removeClass('alert-warning').removeClass('alert-danger').addClass('alert-success').fadeIn('slow','linear',function(){
                $(this).html(xhtR.statusMsg);
            });
            setTimeout(loadMarketLeaders(nothing), 2500);
            setTimeout(closeAlert, 5000);
        },
        error: function(request, status, error){
            $('#editbutton')
            .text('Edit Market Leader');

            request = JSON.parse(request.responseText);
            $('#errormsg').removeClass('alert-warning').removeClass('alert-success').addClass('alert-danger').fadeIn('slow','linear',function(){
                $(this).html(request.statusMsg);
            });
            setTimeout(closeAlert, 7000);
        }
    });
});

</script>