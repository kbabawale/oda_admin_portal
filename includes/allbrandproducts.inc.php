<div class="card mb-3">
  <div class="card-header">
    <i class="fa fa-user-md"></i> Brand Products</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hovered table-sm" id="dataTable" width="100%" cellspacing="0">
        <thead class="text-center thead-dark" style="font-size:.9em;">
          <tr>
            <th>S/N</th>
            <th>Title</th>
            <th>Category</th>
            <th>Sub Category</th>
            <th>Status</th>
            <th>Date</th>
          </tr>
        </thead>
        
        <tbody id="searchtable" class="text-center" style="font-size:.9em;">
          
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- View Brand Product Details [Edit status] -->
<div class="modal fade" id="bproddetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bprodtitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-borderless">
          <tr>
            <td><span class="h5">Description</span></td>
            <td><span id="bpdesc"></span></td>
          </tr>
          <tr>
            <td><span class="h5">Weight</span></td>
            <td><span id="bpweight"></span></td>
          </tr>
          <tr>
            <td><span class="h5">Category</span></td>
            <td><span id="bpcat"></span></td>
          </tr>
          <tr>
            <td><span class="h5">Sub Category</span></td>
            <td><span id="bpsubcat"></span></td>
          </tr>
          <tr>
            <td><span class="h5">Images</span></td>
            <td><span id="bpimages"></span></td>
          </tr>
          <tr>
            <td colspan="2">
              <div id="appdecsection">
                
              </div>
            </td>
          </tr>
          <tr id="commentrow" style="display:none;">
            <td>Comments to merchant <i style="font-size:.85em;">(Optional)</i></td>
            <td><textarea name="comment" class="form-control" id="bpcomment"></textarea></td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" id="confirmbpbutton" style="display:none;" class="btn btn-success">Confirm</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script>
$(document).ready(function(){
  var Token = $('#Token').val();
  
  function loadBrandProducts(tablestate){
    var table = '';
    $.ajax({
      url: '/api/product/brand/all',
      type: 'POST',
      beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
      data: 'id=',
      success: function(xhtR) {
        

        var tbody = $('tbody#searchtable');
        tbody.empty();
        var k = 0;
        
        bp = [];
        for(j=0;j<xhtR.products.length;j++){
          if(xhtR.products[j]['status'] == '0' || xhtR.products[j]['status'] == '2'){
            bp.push(xhtR.products[j]);
          }
        }
        
        while (k < bp.length) {
            var sn = k+1;
            var created = bp[k]['createdAt'];
            ind = created.indexOf('T');
            created = created.substring(0, ind);
            status = bp[k]['status'] == '0' ? 'Pending':'Declined';
            // create an <tr> element, append it to the <tbody> and cache it as a variable:
            var tr = $('<tr/>').appendTo(tbody);
            // append <td> elements to previously created <td> element:
            
            tr.append('<td>'+ sn + '</td>');
            tr.append('<td><a class="editlink" title="View Details" href="javascript:void(0);" data-location="'+bp[k]['uid']+'">' + bp[k]['title'] + '</a></td>');
            tr.append('<td>' + bp[k]['category'] + '</td>');
            tr.append('<td>' + bp[k]['subcategory'] + '</td>');
            tr.append('<td>' + status + '</td>');
            tr.append('<td>' + created + '</td>');
            
            k++;
        }

        $('.editlink').click(function(){
                                
            var id = $(this).attr("data-location");
            $('#bproddetails').modal('show');
            $.ajax({
                url: '/api/product/brand/all',
                type: 'POST',
                beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
                data: 'id='+id,
                success: function(xhtR) {
                    prod = xhtR.product;

                    $('#bprodtitle').html(prod.title);
                    $('#bpdesc').html(prod.description);
                    $('#bpcat').html(prod.category);
                    $('#bpsubcat').html(prod.subcategory);
                    $('#bpweight').html(prod.weight);
                    var divv = $('#appdecsection');
                    divv.empty();
                    
                    if(prod.status == 0){
                      var btn1 = $('<button/>')
                                .addClass('btn')
                                .addClass('m-2')
                                .addClass('btn-sm')
                                .addClass('btn-success')
                                .attr('id', 'bpapprovebutton')
                                .text('Approve Product')
                                .appendTo(divv);

                      var btn1 = $('<button/>')
                                .addClass('btn')
                                .addClass('m-2')
                                .addClass('btn-sm')
                                .addClass('btn-danger')
                                .attr('id', 'bpdeclinebutton')
                                .text('Decline Product')
                                .appendTo(divv);
                    }else if(prod.status == 1){
                      var btn1 = $('<button/>')
                                .addClass('btn')
                                .addClass('m-2')
                                .addClass('btn-sm')
                                .addClass('btn-danger')
                                .attr('id', 'bpdeclinebutton')
                                .text('Decline Product')
                                .appendTo(divv);
                    }else if(prod.status == 2){
                      var btn1 = $('<button/>')
                                .addClass('btn')
                                .addClass('m-2')
                                .addClass('btn-sm')
                                .addClass('btn-success')
                                .attr('id', 'bpapprovebutton')
                                .text('Approve Product')
                                .appendTo(divv);
                    }

                    var spaa = $('#bpimages');
                    spaa.empty();
                    prod.images.forEach((val)=>{
                      var img = $('<img/>')
                                .attr('src',val)
                                .addClass('float-left')
                                .addClass('rounded')
                                .addClass('mx-auto')
                                .attr('width', '30%')
                                .appendTo(spaa);
                    });

                    $('#bpdeclinebutton').click(()=>{
                      $('#commentrow').show();
    
                      $('#confirmbpbutton').show();

                      $('#confirmbpbutton').click(()=>{
                        $('#bproddetails').modal('hide');
                        $.ajax({
                          url: '/api/product/brand/decline',
                          type: 'POST',
                          beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
                          data: 'brandProductId='+id+'&comment='+$('#bpcomment').val(),
                          success: function(xhtR) {
                            $('#errormsg').removeClass('alert-warning').removeClass('alert-danger').addClass('alert-success').fadeIn('slow','linear',function(){
                              $(this).html(xhtR.statusMsg);
                              loadBrandProducts(true);
                            });
                            setTimeout(closeAlert, 5000);
                          },
                          error: function(){
                            $('#errormsg').removeClass('alert-warning').removeClass('alert-success').addClass('alert-danger').fadeIn('slow','linear',function(){
                                $(this).html("An Error Occurred. Try again!");
                            });
                            setTimeout(closeAlert, 3000);
                          }

                        });
                      });
                    });

                    $('#bpapprovebutton').click(()=>{
                      
                      $('#bproddetails').modal('hide');
                        $.ajax({
                          url: '/api/product/brand/approve',
                          type: 'POST',
                          beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
                          data: 'BrandProductId='+id,
                          success: function(xhtR) {
                            $('#errormsg').removeClass('alert-warning').removeClass('alert-danger').addClass('alert-success').fadeIn('slow','linear',function(){
                              $(this).html(xhtR.statusMsg);
                              loadBrandProducts(true);
                            });
                            setTimeout(closeAlert, 5000);
                          },
                          error: function(){
                            $('#errormsg').removeClass('alert-warning').removeClass('alert-success').addClass('alert-danger').fadeIn('slow','linear',function(){
                                $(this).html("An Error Occurred. Try again!");
                            });
                            setTimeout(closeAlert, 3000);
                          }

                        });
                      
                    });
                },
                error: function(){
                  $('#errormsg').removeClass('alert-warning').removeClass('alert-success').addClass('alert-danger').fadeIn('slow','linear',function(){
                      $(this).html("An Error Occurred. Try again!");
                  });
                  setTimeout(closeAlert, 3000);
                }

            });
            
            
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
        //   $('#errormsg').removeClass('alert-warning').removeClass('alert-success').addClass('alert-danger').fadeIn('slow','linear',function(){
        //       $(this).html("Couldn't Open Page. Try again!");
        //   });
        //   setTimeout(closeAlert, 3000);
      }
    });
  }

  loadBrandProducts();

});
</script>