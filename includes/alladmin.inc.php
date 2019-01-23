<div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-user-md"></i> Admin Accounts
      <button type="button" id="export_all_btn" class="pull-right btn btn-info" title="Export"><i class="fa fa-download"></i></button>
      </div>
      

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-sm table-hover" id="dataTable" width="100%" cellspacing="0">
          <thead class="text-center thead-dark" style="font-size:.9em;">
            <tr>
              <th>S/N</th>
              <th>&nbsp;</th>
              <th>Full Name</th>
              <th>Account Type</th>
              <th>Email</th>
              <th>Mobile</th>
              <th>Account Status</th>
              <th>Created</th>
            </tr>
          </thead>
          <!-- <tfoot>
            <tr>
              <th>Full Name</th>
              <th>Access Level</th>
              <th>Email</th>
              <th>Mobile</th>
              <th>Account Status</th>
              <th>Created</th>
            </tr>
          </tfoot> -->
          <tbody id="searchtable" class="text-center" style="font-size:.8em;">
            
          </tbody>
        </table>
      </div>
    </div>
  </div>


  <!-- Delete User Modal -->
<div class="modal fade" id="deleteuser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h5 class="modal-title" id="exampleModalCenterTitle">Are you sure</h5> -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4 class="modal-title text-center" id="exampleModalCenterTitle">Confirm Deactivation</h4>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button> -->
        <button type="button" class="btn btn-danger" id="confirmdeleteuser">Yes</button>
      </div>
    </div>
  </div>
</div>

  <!-- Activate User Modal -->
  <div class="modal fade" id="activateuser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h5 class="modal-title" id="exampleModalCenterTitle">Are you sure</h5> -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4 class="modal-title text-center" id="exampleModalCenterTitle">Confirm Activation</h4>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button> -->
        <button type="button" class="btn btn-danger" id="confirmactivateuser">Yes</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
  var Token = $('#Token').val();
  function loadUsers(tablestate){  
    $.ajax({
      url: '/api/admin/getusers',
      type: 'POST',
      beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
      success: function(xhtR) {
        let adminusers = [];
        //console.log(xhtR.users);
        for(i = 0; i < xhtR.users.length; i++){
          if(xhtR.users[i]['registerAs']=='ADMIN'){
            adminusers.push(xhtR.users[i]);
          }
        }
        //console.log(xhtR.users);

        var tbody = $('tbody#searchtable');
        tbody.empty();
        var k = 0;
        
        while (k < adminusers.length) {
            var sn = k+1;
            var access = adminusers[k]['registerAs'] == 'ADMIN' ? 'Admin':'Master Admin';
            var blocked = adminusers[k]['blocked'] === true ? 'Deactivated': 'Active';
            var created = adminusers[k]['createdAt'];
            ind = created.indexOf('T');
            created = created.substring(0, ind);
            // create an <tr> element, append it to the <tbody> and cache it as a variable:
            var tr = $('<tr/>').appendTo(tbody);
            // append <td> elements to previously created <tr> element:
            
            tr.append('<td>' + sn + '</td>');
            if(adminusers[k]['blocked'] ===  false){
              tr.append('<td><a title="Deactivate this user" class="btn btn-sm btn-danger deleteuserlink" data-location="'+adminusers[k]['uid']+'"><i class="fa fa-close" style="color:#fff;"></i></a></td>');
            }else{
              tr.append('<td><a title="Activate this user" class="btn btn-sm btn-success activateuserlink" data-location="'+adminusers[k]['uid']+'"><i class="fa fa-check" style="color:#fff;"></i></a></td>');             
            }
            tr.append('<td><a class="editlink" title="View & Edit Details" href="javascript:void(0);" data-location="'+adminusers[k]['uid']+'">' + adminusers[k]['fullName'] + '</a></td>');
            tr.append('<td>' + access + '</td>');
            tr.append('<td>' + adminusers[k]['email'] + '</td>');
            tr.append('<td>' + adminusers[k]['mobile'] + '</td>');
            if(adminusers[k]['blocked'] ===  false){
              tr.append('<td class="bg-success text-white">' + blocked + '</td>');
            }else{
              tr.append('<td class="bg-danger text-white">' + blocked + '</td>');
            }
            tr.append('<td>' + created + '</td>');
            
            k++;
        }

        $('.editlink').click(function(){
                                
            var id = $(this).attr("data-location");
            $.ajax({
                url: '/includes/editadmin.inc.php?id='+id,
                type: 'GET',
                success: function(xhtR) {
                    $('#adminbody').html(xhtR);   
                },
                error: function(){
                  $('#errormsg').removeClass('alert-warning').removeClass('alert-success').addClass('alert-danger').fadeIn('slow','linear',function(){
                      $(this).html("Couldn't Open Edit Page. Try again!");
                  });
                  setTimeout(closeAlert, 3000);
                }

            });
            
        });

        $('.deleteuserlink').click(function(){
            $('#deleteuser').modal('show');        
            var id = $(this).attr("data-location");
            
            $('#hiddenuser').val($(this).attr("data-location"));
        });

        $('.activateuserlink').click(function(){
            $('#activateuser').modal('show');        
            var id = $(this).attr("data-location");
            
            $('#hiddenuser').val($(this).attr("data-location"));
        });

        if(tablestate===true){
          table.destroy();
          table = $('#dataTable').DataTable( {
            "searching":true,
            "ordering":false
            
          } );
        }else{
          table = $('#dataTable').DataTable( {
            "searching":true,
            "ordering":false
          } );
        }

      },
      error: function(){
          $('#errormsg').removeClass('alert-warning').removeClass('alert-success').addClass('alert-danger').fadeIn('slow','linear',function(){
              $(this).html("Couldn't Open Page. Try again!");
          });
          setTimeout(closeAlert, 3000);
      }
    });
  }
  loadUsers();

  $('#confirmdeleteuser').click(function(){
    $('#deleteuser').modal('hide'); 
    $.ajax({
        url: '/api/account/delete',
        type: 'POST',
        beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
        data: "uid="+$('#hiddenuser').val()+"&toggle="+0,
        success: function(xhtR) {
            loadUsers(true);
            
        },
        error: function(request, status, error){
            request = JSON.parse(request.responseText);
            
        }
    });
  });

  $('#confirmactivateuser').click(function(){
    $('#activateuser').modal('hide'); 
    $.ajax({
        url: '/api/account/delete',
        type: 'POST',
        beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
        data: "uid="+$('#hiddenuser').val()+"&toggle="+1,
        success: function(xhtR) {
            loadUsers(true);
            
        },
        error: function(request, status, error){
            request = JSON.parse(request.responseText);
            
        }
    });
  });
});
</script>