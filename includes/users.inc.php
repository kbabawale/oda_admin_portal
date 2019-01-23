<div class="row">
    <div class="col-lg-12">
        <h1 class="h4 mt-4"><i class="fa fa-users"></i>&nbsp;Users
            <div class="btn-group pull-right" role="group" aria-label="">
                <!-- <button type="button" id="all_users_btn" class="btn btn-info"><i class="fa fa-users"></i> Export</button> -->
                <!-- <button type="button" id="add_new_user_btn" class="btn btn-success"><i class="fa fa-user-plus"></i> Add New User</button> -->
            </div>
        </h1>
    </div>
</div>
<hr>

<div id="userbody" class="mb-3">
  
  </div>
  
  <script>
    function loadAllUsers(){
      
        $.ajax({
          url: '/includes/allusers.inc.php',
          type: 'GET',
          success: function(xhtR) {
              $('#userbody').html(xhtR);   
          },
          error: function(){
              $('#errormsg').removeClass('alert-warning').addClass('alert-danger').fadeIn('slow','linear',function(){
                  $(this).html("Couldn't Open Page. Try again!");
              });
              setTimeout(closeAlert, 3000);
          }
        });
    
    }
  
    $(document).ready(function(){
      loadAllUsers();
      
      $("#all_users_btn").click(function(){
        loadAllUsers();
      });
  
      $("#add_new_user_btn").click(function(){
        $.ajax({
          url: '/includes/addnewuser.inc.php',
          type: 'GET',
          success: function(xhtR) {
              $('#userbody').html(xhtR);   
          },
          error: function(){
              $('#errormsg').removeClass('alert-warning').addClass('alert-danger').fadeIn('slow','linear',function(){
                  $(this).html("Couldn't Open Page. Try again!");
              });
              setTimeout(closeAlert, 3000);
          }
        });
      });
  
      
      
    });
  </script>