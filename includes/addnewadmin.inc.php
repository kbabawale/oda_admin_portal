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
<div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-user-md"></i> Add New Admin Account
    </div>
    <div class="card-body">
      <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form id="newadminform">
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
                        <label for="exampleFormControlInput1">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                        <input type="checkbox" onclick="myFunction()"><label for="exampleFormControlInput1">Show Password</label>
                    </div>
                    <input type="hidden" id="register_as" name="register_as" value="3" />
                    <input type="hidden" id="address" name="address" value="No address" />
                    <input type="hidden" id="date_of_birth" name="date_of_birth" value="00/00/0000" />
                    <input type="hidden" id="gender" name="gender" value="Male" />
                    <input type="hidden" id="fcmToken" name="fcmToken" value="0" />
                    <input type="hidden" id="refererCode" name="refererCode" value="0" />
                    <input type="hidden" id="vehicleType" name="vehicleType" value="0" />
                    
                    <div class="form-group">
                    <button type="submit" class="btn btn-success form-control" id="createbutton">Create Admin Account</button>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
    </div>
  </div>

<script>

$("#createbutton").click((e)=>{
    e.preventDefault();
    $('#createbutton')
    .text('Loading...');

    $.ajax({
        url: '/api/register/',
        type: 'POST',
        data: $('#newadminform').serialize(),
        success: function(xhtR) {
            $('#createbutton')
            .text('Create Admin Account');
            
            $('#errormsg').removeClass('alert-warning').removeClass('alert-danger').addClass('alert-success').fadeIn('slow','linear',function(){
                $(this).html(xhtR.statusMsg);
            });
            setTimeout(loadAllAdmin(), 2500);
            setTimeout(closeAlert, 5000);
        },
        error: function(request, status, error){
            $('#createbutton')
            .text('Create Admin Account');

            request = JSON.parse(request.responseText);
            $('#errormsg').removeClass('alert-warning').removeClass('alert-success').addClass('alert-danger').fadeIn('slow','linear',function(){
                $(this).html(request.statusMsg);
            });
            //setTimeout(closeAlert, 7000);
        }
    });
});
</script>
  