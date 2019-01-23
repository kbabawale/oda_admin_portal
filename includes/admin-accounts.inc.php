<div class="row">
    <div class="col-lg-12">
    <h1 class="h4 mt-4"><i class="fa fa-user-md"></i>&nbsp;Admin Accounts
        <div class="btn-group pull-right" role="group" aria-label="">
            <button type="button" id="all_users_btn" class="btn btn-info"><i class="fa fa-users"></i> Admin Accounts</button>
            <button type="button" id="add_new_user_btn" class="btn btn-success"><i class="fa fa-user-plus"></i> Add New Admin</button>
        </div>
    </h1>
    </div>
</div>
<hr>

<div id="adminbody" class="mb-3">
  
</div>

<script>
  function loadAllAdmin(){
    
      $.ajax({
        url: '/includes/alladmin.inc.php',
        type: 'GET',
        success: function(xhtR) {
            $('#adminbody').html(xhtR);   
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
    loadAllAdmin();
    
    $("#all_users_btn").click(function(){
      loadAllAdmin();
    });

    $("#add_new_user_btn").click(function(){
      $.ajax({
        url: '/includes/addnewadmin.inc.php',
        type: 'GET',
        success: function(xhtR) {
            $('#adminbody').html(xhtR);   
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