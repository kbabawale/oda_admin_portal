<?php 
if(isset($_GET['id'])){
    $id = $_GET['id'];
}
?>

<script>
function myFunction() {
    var x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
</script>

<input type="hidden" name="currentUser" id="currentUser" value="<?= $id; ?>" />
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
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Address</label>
                        <textarea class="form-control" id="address" name="address"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Gender</label>
                        <select name="gender" id="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Referer Code</label>
                        <input type="text" class="form-control" id="refererCode" name="refererCode" placeholder="XXX123" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Date of Birth</label>
                        <input type="text" class="form-control" id="date_of_birth" name="date_of_birth" placeholder="MM/DD/YYYY">
                    </div>
                    <!-- <div class="form-group">
                        <label for="exampleFormControlInput1">Vehicle Type</label>
                        <select name="vehicleType" id="vehicleType">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div> -->
                    
                    <input type="hidden" id="register_as" name="register_as" />
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
        <i class="fa fa-user-md"></i> <span id="userNameSpan">Change User Type</span>
    </div>
    <div class="card-body">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form id="editusertypeform">
                    <input type="hidden" id="uid" name="uid" value="<?= $id; ?>" />
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Change User Type To:</label>
                        <select name="register_as" id="acc_register_as">
                            <option value="0">Select One:</option>
                            <option value="1">Merchant</option>
                            <option value="2">Delivery Rep</option>
                        </select>
                    </div>
                    <div id="merchantdiv" style="display:none;">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Address</label>
                            <textarea class="form-control" id="address" name="address"></textarea>
                        </div>
                    </div>
                    <div id="delrepdiv" style="display:none;">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Vehicle Type</label>
                            <select name="vehicleType" id="vehicleType">
                                <option value="0">Select One:</option>
                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Date of Birth</label>
                            <input type="text" class="form-control" id="date_of_birth" name="date_of_birth" placeholder="MM/DD/YYYY">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-success form-control" id="editaccounttypebutton">Change Account Type</button>
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

    //load user's details on form fields
    var showUserDetails = ()=>{
        $.ajax({
            url: '/api/admin/getuser',
            beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
            type: 'POST',
            data: "uid="+user,
            success: function(xhtR) {
                //console.log(xhtR);
                
                gender = xhtR.users['gender'];
                gender = gender.toLowerCase();

                reg = xhtR.users['registerAs'] == 'MERCHANT'? '1':'2';

                $('#name').val(xhtR.users['fullName']);
                $('#email').val(xhtR.users['email']);
                $('#mobile').val(xhtR.users['mobile']); 
                $('#address').val(xhtR.users['address']);
                $('#register_as').val(reg); 
                $('#gender option[value='+gender+']').attr('selected', 'selected');
                $('#date_of_birth').val(xhtR.users['date_of_birth']);
                $('#refererCode').val(xhtR.users['referer']);
            },
            error: function(request, status, error){
                request = JSON.parse(request.responseText);
                $('#errormsg').removeClass('alert-warning').removeClass('alert-success').addClass('alert-danger').fadeIn('slow','linear',function(){
                    $(this).html(request.statusMsg);
                });
                //loadUsers();
                setTimeout(closeAlert, 3000);
            }
        });
    };

    showUserDetails();

    var showVehicleType = ()=>{
        $.ajax({
            url: '/api/admin/vehicle/all',
            beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
            type: 'GET',
            //data: "uid="+user,
            success: function(xhtR) {
                //console.log(xhtR);
                var vehicleType = $('#vehicleType');
                var j = 0;
                while (j < xhtR.vehicles.length) {
                    vehicleType.append($('<option>', {
                        value: xhtR.vehicles[j]['vehicle'],
                        text: xhtR.vehicles[j]['vehicle']
                    }));

                    j++;
                }
            },
            error: function(request, status, error){
                request = JSON.parse(request.responseText);
                $('#errormsg').removeClass('alert-warning').removeClass('alert-success').addClass('alert-danger').fadeIn('slow','linear',function(){
                    $(this).html(request.statusMsg);
                });
                //loadUsers();
                setTimeout(closeAlert, 3000);
            }
        });
    };

    showVehicleType();

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
            .text('Info Saved');
            
            $('#errormsg').removeClass('alert-warning').removeClass('alert-danger').addClass('alert-success').fadeIn('slow','linear',function(){
                $(this).html(xhtR.statusMsg);
            });
            //setTimeout(loadUsers(), 2500);
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

$('#acc_register_as').on('change', function() {
    var val = $(this).find(":selected").val();

    if(val == '1'){
        $('#merchantdiv').show();
        $('#delrepdiv').hide();
    }else{
        $('#delrepdiv').show();
        $('#merchantdiv').hide();
    }
});

$('#editaccounttypebutton').click((e)=>{
    e.preventDefault();
    $('#editaccounttypebutton')
    .text('Loading...');

    $.ajax({
        url: '/api/account/type/update',
        type: 'POST',
        beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
        data: $('#editusertypeform').serialize(),
        success: function(xhtR) {
            $('#editaccounttypebutton')
            .text('Account Type Changed');
            
            $('#errormsg').removeClass('alert-warning').removeClass('alert-danger').addClass('alert-success').fadeIn('slow','linear',function(){
                $(this).html(xhtR.statusMsg);
            });
            setTimeout(closeAlert, 5000);
        },
        error: function(request, status, error){
            $('#editaccounttypebutton')
            .text('Change Account Type');

            request = JSON.parse(request.responseText);
            $('#errormsg').removeClass('alert-warning').removeClass('alert-success').addClass('alert-danger').fadeIn('slow','linear',function(){
                $(this).html(request.statusMsg);
            });
            setTimeout(closeAlert, 7000);
        }
    });
});

</script>