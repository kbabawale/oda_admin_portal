<?php 
if(isset($_GET['id'])){
    $id = $_GET['id'];
}
?>
<script>
function myFunction() {
    var x = document.getElementById("newpass");
    if (x.type === "newpass") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
</script>
<input type="hidden" id="iid" value="<?= $id; ?>" />
<div class="row">
    <div class="col-lg-12">
        <h1 class="h4 mt-4"><i class="fa fa-users"></i>&nbsp;Profile Information
            <div class="btn-group pull-right" role="group" aria-label="">
                <!-- <button type="button" id="all_users_btn" class="btn btn-info"><i class="fa fa-users"></i> All Users</button> -->
                <!-- <button type="button" id="add_new_user_btn" class="btn btn-success"><i class="fa fa-user-plus"></i> Add New User</button> -->
            </div>
        </h1>
    </div>
</div>
<hr>

<div id="userbody" class="mb-3">

<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-user-md"></i> <span id="userNameSpan">Edit Account</span>
    </div>
    <div class="card-body">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form id="editadminform">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="John Appleseed" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Mobile</label>
                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="080123456789" required>
                    </div>
                    
                    
                    <input type="hidden" id="register_as" name="register_as" value="3" />
                    <input type="hidden" id="address" name="address" value="No address" />
                    <input type="hidden" id="date_of_birth" name="date_of_birth" value="00/00/0000" />
                    <input type="hidden" id="gender" name="gender" value="Male" />
                    <input type="hidden" id="uid" name="uid" value="<?= $id; ?>" />
                    
                    <div class="form-group">
                    <button type="submit" class="btn btn-success form-control" id="editbutton">Edit Account</button>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-user-md"></i> <span id="userNameSpan">Change Password</span>
    </div>
    <div class="card-body">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form id="resetform">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Current Password: </label>
                        <input type="password" class="form-control" id="currentpass" name="currentpass" placeholder="Enter Current Password" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">New Password: </label>
                        <input type="password" class="form-control" id="newpass" name="newpass" placeholder="Enter New Password" required>
                        <!-- <input type="checkbox" onclick="myFunction()"><label for="exampleFormControlInput1">Show Password</label> -->
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success form-control" id="resetpasswordbutton">Reset Password</button>
                        <div class="alert alert-warning" id="resetmsg" role="alert" style="display:none;margin-bottom:-1%;margin-top:10px;"></div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>


</div>

  <script>

var Token = $('#Token').val();
var user = $('#UserId').val();
var oldpass = $('#pass').val();
var newpass = $('#newpass').val();


//load user's details on form fields
var showUserDetails = ()=>{
    $.ajax({
        url: '/api/admin/getuser',
        beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
        type: 'POST',
        data: "uid="+$('#iid').val(),
        success: function(xhtR) {
            //console.log(xhtR);
        $('#name').val(xhtR.users['fullName']);
        $('#email').val(xhtR.users['email']);
        $('#mobile').val(xhtR.users['mobile']); 
        },
        error: function(request, status, error){
            request = JSON.parse(request.responseText);
            $('#errormsg').removeClass('alert-warning').removeClass('alert-success').addClass('alert-danger').fadeIn('slow','linear',function(){
                $(this).html(request.statusMsg);
            });
            loadAllAdmin();
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
        url: '/api/account/update',
        type: 'POST',
        beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
        data: $('#editadminform').serialize(),
        success: function(xhtR) {
            $('#editbutton')
            .text('Edit Account');
            
            $('#errormsg').removeClass('alert-warning').removeClass('alert-danger').addClass('alert-success').fadeIn('slow','linear',function(){
                $(this).html(xhtR.statusMsg);
            });
            setTimeout(loadAllAdmin(), 2500);
            setTimeout(closeAlert, 5000);
        },
        error: function(request, status, error){
            $('#editbutton')
            .text('Edit Account');

            request = JSON.parse(request.responseText);
            $('#errormsg').removeClass('alert-warning').removeClass('alert-success').addClass('alert-danger').fadeIn('slow','linear',function(){
                $(this).html(request.statusMsg);
            });
            //setTimeout(closeAlert, 7000);
        }
    });
});

$("#resetpasswordbutton").click((e)=>{
    e.preventDefault();
    $('#resetpasswordbutton')
    .text('Loading...');

    //if old passwords match
    if(oldpass.trim() == $('#currentpass').val().trim()){
        $.ajax({
            url: '/api/changepw',
            type: 'POST',
            beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
            data: "userId="+user+"&password="+$('#newpass').val(),
            success: function(xhtR) {
                $('#resetpasswordbutton')
                .text('Reset Password');
                
                $('#resetmsg').removeClass('alert-warning').removeClass('alert-danger').addClass('alert-success').fadeIn('slow','linear',function(){
                    $(this).html(xhtR.statusMsg+'. You\'ll be logged out shortly');
                });
                //setTimeout(loadAllAdmin(), 2500);
                setTimeout(logoutfunction(), 8000);
            },
            error: function(request, status, error){
                $('#resetpasswordbutton')
                .text('Reset Password');

                request = JSON.parse(request.responseText);
                $('#resetmsg').removeClass('alert-warning').removeClass('alert-success').addClass('alert-danger').fadeIn('slow','linear',function(){
                    $(this).html(request.statusMsg);
                });
                //setTimeout(closeAlert, 7000);
            }
        });
        
    }else{
        $('#resetpasswordbutton')
        .text('Reset Password');

        $('#errormsg').removeClass('alert-warning').removeClass('alert-danger').addClass('alert-success').fadeIn('slow','linear',function(){
            $(this).html('Old Password Is Not Correct');
        });
        setTimeout(closeAlert, 8000);
    }
});

</script>