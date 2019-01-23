<div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-car"></i> Vehicle Types <a href="javascript:void(0);" id="addnewvehicletypebtn" class="pull-right btn btn-success btn-sm"><i class="fa fa-plus"></i>&nbsp;New Vehicle Type</a></div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hovered table-sm" id="dataTable" width="100%" cellspacing="0">
          <thead class="text-center thead-dark">
            <tr>
              <th width="10%">S/N</th>
              <th width="">&nbsp;</th>
              <th width="">Vehicle</th>
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
          <tbody id="searchtable" class="text-center">
            
          </tbody>
        </table>
      </div>
    </div>
  </div>

<!-- Add Vehicle Type -->
<div class="modal fade" id="newvehicletype" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">New Vehicle Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- <h4 class="modal-title text-center" id="exampleModalCenterTitle">Confirm Activation</h4> -->
        <form id="vehicletypeform">
            <div class="form-group">
                <label for="exampleFormControlInput1">Vehicle Name</label>
                <input type="text" class="form-control" id="vehicleName" name="vehicleName" placeholder="Car" required>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button> -->
        <button type="submit" class="btn btn-success" id="addvehicletypebutton">Add Vehicle Type</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deletevehicletype" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h5 class="modal-title" id="exampleModalCenterTitle">Are you sure</h5> -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4 class="modal-title text-center" id="exampleModalCenterTitle">Confirm Deletion</h4>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button> -->
        <button type="button" class="btn btn-danger" id="confirmdeletevehicletype">Yes</button>
      </div>
    </div>
  </div>
</div>


<script>
$(document).ready(function(){
  var Token = $('#Token').val();
  function loadVehicleTypes(){  
    $.ajax({
      url: '/api/admin/vehicle/all',
      type: 'GET',
      beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
      success: function(xhtR) {
        

        var tbody = $('tbody#searchtable');
        tbody.empty();
        var k = 0;
        var vehicles = xhtR.vehicles;
        while (k < xhtR.vehicles.length) {
            var sn = k+1;
            
            // create an <tr> element, append it to the <tbody> and cache it as a variable:
            var tr = $('<tr/>').appendTo(tbody);
            // append <td> elements to previously created <td> element:
            
            tr.append('<td>'+ sn + '</td>');
            tr.append('<td><a title="Delete Vehicle Type" class="btn btn-sm btn-danger deletevehicletype" data-location="'+vehicles[k]['id']+'"><i class="fa fa-close" style="color:#fff;"></i></a></td>');
            tr.append('<td>' + vehicles[k]['vehicle'] + '</td>');
            
            k++;
        }

        $('.deletevehicletype').click(function(){
            $('#deletevehicletype').modal('show');        
            var id = $(this).attr("data-location");
            
            $('#hiddenuser').val($(this).attr("data-location"));
        });

      },
      error: function(){
        
      }
    });
  }
  loadVehicleTypes();

  $('#addnewvehicletypebtn').click(function(){
        $('#newvehicletype').modal('show');  
        $('#vehicleName').val('');      
        
    });

    $('#addvehicletypebutton').click(function(e){
        $('#newvehicletype').modal('hide'); 
        e.preventDefault();
        $.ajax({
        url: '/api/admin/vehicle/create',
        type: 'POST',
        beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
        data: $('#vehicletypeform').serialize(),
        success: function(xhtR) {
            
            $('#errormsg').removeClass('alert-warning').removeClass('alert-danger').addClass('alert-success').fadeIn('slow','linear',function(){
                $(this).html(xhtR.statusMsg);
            });
            loadVehicleTypes();
            setTimeout(closeAlert, 5000);
        },
        error: function(request, status, error){
            request = JSON.parse(request.responseText);
            $('#errormsg').removeClass('alert-warning').removeClass('alert-success').addClass('alert-danger').fadeIn('slow','linear',function(){
                $(this).html(request.statusMsg);
            });
            setTimeout(closeAlert, 7000);
        }
    });
    });

  $('#confirmdeletevehicletype').click(function(){
    $('#deletevehicletype').modal('hide'); 
    $.ajax({
        url: '/api/admin/vehicle/delete',
        type: 'POST',
        beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
        data: "id="+$('#hiddenuser').val(),
        success: function(xhtR) {
          loadVehicleTypes();
            
        },
        error: function(request, status, error){
            request = JSON.parse(request.responseText);
            
        }
    });
  });

});
</script>