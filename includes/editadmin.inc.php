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
                    
                    
                    <input type="hidden" id="register_as" name="register_as" value="3" />
                    <input type="hidden" id="address" name="address" value="No address" />
                    <input type="hidden" id="date_of_birth" name="date_of_birth" />
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
        <i class="fa fa-user-md"></i> <span id="userNameSpan">Assign Roles To Account</span>
    </div>
    <div class="card-body">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form id="maprolesform">
                    <div id="rolesdiv" class="form-group">
                        <select class="form-control" name="rolesdropdown" id="rolesdropdown">
                            <option value="0">Select A Role</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success form-control" id="maprolesbutton">Assign Roles To User</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <h5>Assigned Roles</h5>
                <div class="assignedrows">
                    
                </div>   
            </div>
        </div>
      </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-user-md"></i> <span id="userNameSpan">Reset Password</span>
    </div>
    <div class="card-body">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form id="resetform">
                    <!-- <div class="form-group">
                        <label for="exampleFormControlInput1">Current Password: </label>
                        <input type="password" class="form-control" id="currentpass" name="currentpass" placeholder="Enter Current Password" required>
                    </div> -->
                    <div class="form-group">
                        <label for="exampleFormControlInput1">New Password: </label>
                        <input type="password" class="form-control" id="newpass" name="newpass" placeholder="Enter New Password" required>
                        <!-- <input type="checkbox" onclick="myFunction()"><label for="exampleFormControlInput1">Show Password</label> -->
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success form-control" id="resetpasswordbutton">Reset Password</button>
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
    var oldpass = $('#pass').val();
    var newpass = $('#newpass').val();
    var roles = [];
    var assroles = [];
    
    
    //load user's details on form fields
    var showUserDetails = ()=>{
        $.ajax({
            url: '/api/admin/getuser',
            beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
            type: 'POST',
            data: "uid="+user,
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

    //load user's roles
    var showUserRoles = ()=>{
        $.ajax({
            url: '/api/admin/getallroles',
            beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
            type: 'GET',
            //data: "uid="+user,
            success: function(xhtR) {
                $.each(xhtR.roles, function(index, value)
                {
                    obj = new Object();
                    obj.id = value.id;
                    obj.name = value.roleName;
                    roles.push(obj);

                    var div = $('<div />')
                    .addClass('form-group')
                    .addClass('form-check')
                    .appendTo(maprolesform);

                    //populate select fields
                    var rolesdropdown = $('#rolesdropdown');
                    var i = 0;
                    
                    rolesdropdown.append($('<option>', {
                        value: value.id,
                        text: value.roleName
                    }));

                    i++;
                    
                });
                //console.log(roles, 'All Roles');
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

    var displayMappedRoles = ()=>{
        var assignedroles = $('.assignedrows');
        
        //clear div before anything
        assignedroles.html('');
        //empty assroles array
        assroles = [];

        $.ajax({
            url: '/api/admin/getroles',
            beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
            type: 'POST',
            data: "UserId="+user,
            success: function(xhtR) {
                

                //store already assigned in an array
                xhtR.roleNames.forEach((value)=>{
                    assroles.push(value);
                    
                    //display badge for each of them.
                    var mainSpan = $('<span/>')
                    .addClass('badge')
                    .addClass('badge-primary')
                    .addClass('p-1')
                    .addClass('mr-2')
                    .addClass('mt-2')
                    .appendTo(assignedroles);
                    var spaan = $('<span/>')
                    .addClass('pl-2')
                    .text(value)
                    .appendTo(mainSpan);
                    var aa = $('<a/>')
                    .attr('id', value)
                    .addClass('btn')
                    .addClass('badgebox')
                    .addClass('btn-sm')
                    .attr('onClick', 'removeRole(\''+value+'\')')
                    .appendTo(mainSpan);
                    var i = $('<i/>')
                    .addClass('fa')
                    .addClass('fa-close')
                    .appendTo(aa);

                });

                console.log(assroles, 'Assigned Roles (At Display)');
            },
            error: function(request, status, error){
                request = JSON.parse(request.responseText);
                
            }
        });
    };

    showUserDetails();
    showUserRoles();
    displayMappedRoles();

function removeRole(role){
    dataid = [];
    //remove role from assigned roles
    indexx = assroles.indexOf(role);
    assroles.splice(indexx, 1);
    //console.log(assroles, "New Assigned Roles (Remove Role)");

    //fetch the ids of roles from assroles array
    assroles.forEach((assvalue)=>{
        for(i=0;i<roles.length;i++){
            if(roles[i]['name'] == assvalue){
                dataid.push(roles[i]['id']);
            }
        }
    });

    dataid = dataid.join(',');
    console.log(dataid, "New Assigned Roles[Data] (Remove Role)");
        
    $.ajax({
        url: '/api/admin/maproles',
        type: 'POST',
        beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
        data: "user_id="+user+"&role_ids="+dataid,
        success: function(xhtR) {
            //reload assigned roles
            displayMappedRoles();
        },
        error: function(request, status, error){
            request = JSON.parse(request.responseText);
            $('#errormsg').removeClass('alert-warning').removeClass('alert-success').addClass('alert-danger').fadeIn('slow','linear',function(){
                $(this).html('Temp Error');
            });
            //setTimeout(closeAlert, 7000);
        }
    });
}    

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

$("#maprolesbutton").click((e)=>{
    e.preventDefault();
    $('#maprolesbutton')
    .text('Mapping...');

    //construct data
    var chkdata = []; var sw = false;
    
    roleselectedid = $("#rolesdropdown").val();
    
    if(roleselectedid != '0' || roleselectedid != ''){
        //check if selected index is already in assroles array, if not, push to it
        roles.forEach((value)=>{
            if(value.id == roleselectedid){
                if(assroles.includes(value.name) === false){
                    assroles.push(value.name);
                }
            }
        });
        //add remaining already assigned roles to chkdata
        assroles.forEach((value)=>{
            roles.forEach((roless)=>{
                if(roless.name == value){
                    chkdata.push(parseInt(roless.id));
                }
            });
        });
    }

    chkdata = chkdata.join(',');
    
    console.log(assroles, 'New Assigned Roles (At Addition)');
    console.log(chkdata, 'New Assigned Roles[Data] (At Addition)');

    // if(!sw){
        $.ajax({
            url: '/api/admin/maproles',
            type: 'POST',
            beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
            data: "user_id="+user+"&role_ids="+chkdata,
            success: function(xhtR) {
                $('#maprolesbutton')
                .text('Assign Roles To User');
                
                $('#errormsg').removeClass('alert-warning').removeClass('alert-danger').addClass('alert-success').fadeIn('slow','linear',function(){
                    $(this).html(xhtR.statusMsg);
                });
                displayMappedRoles();
                //setTimeout(loadAllAdmin(), 2500);
                //setTimeout(closeAlert, 5000);
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
    //}
});

$("#resetpasswordbutton").click((e)=>{
    e.preventDefault();
    $('#resetpasswordbutton')
    .text('Loading...');

    //if old passwords match
    //if(oldpass != '' && oldpass == currentpass){
        $.ajax({
            url: '/api/changepw',
            type: 'POST',
            beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
            data: "userId="+currentUser+"&password="+newpass,
            success: function(xhtR) {
                $('#resetpasswordbutton')
                .text('Reset Password');
                
                $('#errormsg').removeClass('alert-warning').removeClass('alert-danger').addClass('alert-success').fadeIn('slow','linear',function(){
                    $(this).html(xhtR.statusMsg);
                });
                setTimeout(loadAllAdmin(), 2500);
                setTimeout(closeAlert, 5000);
            },
            error: function(request, status, error){
                $('#resetpasswordbutton')
                .text('Reset Password');

                request = JSON.parse(request.responseText);
                $('#errormsg').removeClass('alert-warning').removeClass('alert-success').addClass('alert-danger').fadeIn('slow','linear',function(){
                    $(this).html(request.statusMsg);
                });
                //setTimeout(closeAlert, 7000);
            }
        });
    // }else{
    //     $('#resetpasswordbutton')
    //     .text('Reset Password');

    //     $('#errormsg').removeClass('alert-warning').removeClass('alert-danger').addClass('alert-success').fadeIn('slow','linear',function(){
    //         $(this).html('Old Password Is Not Correct');
    //     });
    //     setTimeout(closeAlert, 8000);
    // }
});
</script>