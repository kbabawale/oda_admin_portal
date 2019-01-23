<div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-car"></i> Store Types <a href="javascript:void(0);" id="addnewstoretypebtn" class="pull-right btn btn-success btn-sm"><i class="fa fa-cart-plus"></i>&nbsp;New Store Type</a></div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hovered table-sm" id="dataTable" width="100%" cellspacing="0">
          <thead class="text-center thead-dark">
            <tr>
              <th width="10%">S/N</th>
              <th width="">&nbsp;</th>
              <th width="">Store Type</th>
            </tr>
          </thead>
          <tbody id="searchtable" class="text-center">
            
          </tbody>
        </table>
      </div>
    </div>
  </div>

<!-- Add Vehicle Type -->
<div class="modal fade" id="newstoretype" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">New Store Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="storetypeform">
            <div class="form-group">
                <label for="exampleFormControlInput1">Store Type</label>
                <input type="text" class="form-control" id="storeType" name="storeType" placeholder="Supermarket" required>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button> -->
        <button type="submit" class="btn btn-success" id="addstoretypebutton">Add Store Type</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deletestoretype" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
        <button type="button" class="btn btn-danger" id="confirmdeletestoretype">Yes</button>
      </div>
    </div>
  </div>
</div>


<script>
$(document).ready(function(){
  var Token = $('#Token').val();
  function loadStoreTypes(){  
    $.ajax({
      url: '/api/admin/storetype/all',
      //url: 'http://sunrise-api.com.ng/api/admin/storetype/all',
      type: 'GET',
      beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
      success: function(xhtR) {
        

        var tbody = $('tbody#searchtable');
        tbody.empty();
        var k = 0;
        var storeType = xhtR.storeType;
        while (k < xhtR.storeType.length) {
            var sn = k+1;
            
            // create an <tr> element, append it to the <tbody> and cache it as a variable:
            var tr = $('<tr/>').appendTo(tbody);
            // append <td> elements to previously created <td> element:
            
            tr.append('<td>'+ sn + '</td>');
            tr.append('<td><a title="Delete Store Type" class="btn btn-sm btn-danger deletestoretypee" data-location="'+storeType[k]['id']+'"><i class="fa fa-close" style="color:#fff;"></i></a></td>');
            tr.append('<td>' + storeType[k]['name'] + '</td>');
            
            k++;
        }

        $('.deletestoretypee').click(function(){
            $('#deletestoretype').modal('show');        
            var id = $(this).attr("data-location");
            
            $('#hiddenuser').val($(this).attr("data-location"));
        });

      },
      error: function(){
        
      }
    });
  }
  loadStoreTypes();

  $('#addnewstoretypebtn').click(function(){
        $('#newstoretype').modal('show');  
        $('#storeType').val('');      
        
    });

    $('#addstoretypebutton').click(function(e){
        $('#newstoretype').modal('hide'); 
        e.preventDefault();
        $.ajax({
        url: '/api/admin/storetype/create',
        type: 'POST',
        beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
        data: $('#storetypeform').serialize(),
        success: function(xhtR) {
            
            $('#errormsg').removeClass('alert-warning').removeClass('alert-danger').addClass('alert-success').fadeIn('slow','linear',function(){
                $(this).html(xhtR.statusMsg);
            });
            loadStoreTypes();
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

  $('#confirmdeletestoretype').click(function(){
    $('#deletestoretype').modal('hide'); 
    $.ajax({
        url: '/api/admin/storetype/delete',
        type: 'POST',
        beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
        data: "id="+$('#hiddenuser').val(),
        success: function(xhtR) {
          loadStoreTypes();
          $('#errormsg').removeClass('alert-warning').removeClass('alert-danger').addClass('alert-success').fadeIn('slow','linear',function(){
                $(this).html(xhtR.statusMsg);
            });
            loadStoreTypes();
            setTimeout(closeAlert, 5000);  
        },
        error: function(request, status, error){
            request = JSON.parse(request.responseText);
            request = JSON.parse(request.responseText);
            $('#errormsg').removeClass('alert-warning').removeClass('alert-success').addClass('alert-danger').fadeIn('slow','linear',function(){
                $(this).html(request.statusMsg);
            });
            setTimeout(closeAlert, 7000);
        }
    });
  });

});
</script>