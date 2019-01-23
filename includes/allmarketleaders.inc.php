<div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-user-md"></i> Market Leaders <a href="javascript:void(0);" id="addnewleaderbtn" class="pull-right btn btn-success btn-sm"><i class="fa fa-plus"></i>&nbsp;New Market Leader</a></div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hovered table-sm" id="dataTable" width="100%" cellspacing="0">
          <thead class="text-center thead-dark" style="font-size:.9em;">
            <tr>
              <th>S/N</th>
              <th>&nbsp;</th>
              <th>Full Name</th>
              <th>Mobile</th>
              <th>Referer Code</th>
              
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
          <tbody id="searchtable" class="text-center" style="font-size:.9em;">
            
          </tbody>
        </table>
      </div>
    </div>
  </div>

<!-- Add Market Leader -->
<div class="modal fade" id="newleader" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">New Market Leader</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- <h4 class="modal-title text-center" id="exampleModalCenterTitle">Confirm Activation</h4> -->
        <form id="marketleaderform">
            <div class="form-group">
                <label for="exampleFormControlInput1">Full Name</label>
                <input type="text" class="form-control" id="fullName" name="fullName" placeholder="John Appleseed" required>
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Referer Code</label>
                <input type="text" class="form-control" id="refererCode" name="refererCode" placeholder="ABC123" required>
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Mobile</label>
                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="080123456789" required>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button> -->
        <button type="submit" class="btn btn-success" id="addmarketleaderbutton">Add Market Leader</button>
      </div>
    </div>
  </div>
</div>

  <!-- Delete User Modal -->
  <div class="modal fade" id="deletemarketlead" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
        <button type="button" class="btn btn-danger" id="confirmdeletemarketlead">Yes</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
  var Token = $('#Token').val();
  function loadMarketLeaders(refererCode){
    var dataV = refererCode;  
    $.ajax({
      url: '/api/admin/marketlead/all',
      type: 'POST',
      beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
      data: 'refererCode='+dataV,
      success: function(xhtR) {
        

        var tbody = $('tbody#searchtable');
        tbody.empty();
        var k = 0;
        var marketlead = xhtR.marketlead;
        while (k < xhtR.marketlead.length) {
            var sn = k+1;
            var created = new Date(marketlead[k]['createdAt']);
            var date = created.getDate();
            var month = created.getMonth();
            var year = created.getYear();
            var fullDate = date+"/"+month+"/"+year;
            // create an <tr> element, append it to the <tbody> and cache it as a variable:
            var tr = $('<tr/>').appendTo(tbody);
            // append <td> elements to previously created <td> element:
            
            tr.append('<td>'+ sn + '</td>');
            tr.append('<td><a title="Delete Market Leader" class="btn btn-sm btn-danger deleteusermarketlead" data-location="'+marketlead[k]['refererCode']+'"><i class="fa fa-close" style="color:#fff;"></i></a></td>');
            tr.append('<td><a class="editlink" title="View & Edit Details" href="javascript:void(0);" data-location="'+marketlead[k]['refererCode']+'">' + marketlead[k]['fullName'] + '</a></td>');
            tr.append('<td>' + marketlead[k]['mobile'] + '</td>');
            tr.append('<td>' + marketlead[k]['refererCode'] + '</td>');
            
            
            k++;
        }

        $('.editlink').click(function(){
                                
            var id = $(this).attr("data-location");
            $.ajax({
                url: '/includes/editmarketleader.inc.php?id='+id,
                type: 'GET',
                success: function(xhtR) {
                    $('#syssetupbody').html(xhtR);   
                },
                error: function(){
                  $('#errormsg').removeClass('alert-warning').removeClass('alert-success').addClass('alert-danger').fadeIn('slow','linear',function(){
                      $(this).html("Couldn't Open Edit Page. Try again!");
                  });
                  setTimeout(closeAlert, 3000);
                }

            });
            
        });

        $('.deleteusermarketlead').click(function(){
            $('#deletemarketlead').modal('show');        
            var id = $(this).attr("data-location");
            
            $('#hiddenuser').val($(this).attr("data-location"));
        });


      },
      error: function(){
        //   $('#errormsg').removeClass('alert-warning').removeClass('alert-success').addClass('alert-danger').fadeIn('slow','linear',function(){
        //       $(this).html("Couldn't Open Page. Try again!");
        //   });
        //   setTimeout(closeAlert, 3000);
      }
    });
  }
  var para = "";
  loadMarketLeaders(para);

  $('#addnewleaderbtn').click(function(){
        $('#newleader').modal('show');        
        
    });

    $('#addmarketleaderbutton').click(function(e){
        $('#newleader').modal('hide'); 
        e.preventDefault();
        $.ajax({
        url: '/api/admin/marketlead/create',
        type: 'POST',
        beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
        data: $('#marketleaderform').serialize(),
        success: function(xhtR) {
            
            $('#errormsg').removeClass('alert-warning').removeClass('alert-danger').addClass('alert-success').fadeIn('slow','linear',function(){
                $(this).html(xhtR.statusMsg);
            });
            loadMarketLeaders(para);
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

  $('#confirmdeletemarketlead').click(function(){
    $('#deletemarketlead').modal('hide'); 
    $.ajax({
        url: '/api/admin/marketlead/delete',
        type: 'POST',
        beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
        data: "refererCode="+$('#hiddenuser').val(),
        success: function(xhtR) {
          loadMarketLeaders(para);
            
        },
        error: function(request, status, error){
            request = JSON.parse(request.responseText);
            
        }
    });
  });

});
</script>