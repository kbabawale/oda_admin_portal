<div class="card mb-3">
  <div class="card-header">
    <i class="fa fa-user-md"></i> Generic Products 
    <div class="pull-right btn-group-sm btn-group" role="group" aria-label="Button group with nested dropdown">
        <button type="button" id="showgpbutton" class="btn btn-primary">New Generic Product</button>
       
        <div class="btn-group" role="group">
            <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            
            </button>
            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <a class="dropdown-item" href="javascript:void(0);" id="showaddbulkgpbutton">Add Bulk Generic Products</a>
            <!-- <a class="dropdown-item" href="#">Dropdown link</a> -->
            </div>
        </div>
        </div>
    </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hovered table-sm" id="dataTable" width="100%" cellspacing="0">
        <thead class="text-center thead-dark" style="font-size:.9em;">
          <tr>
            <th>S/N</th>
            <th>Title</th>
            <th>Category</th>
            <th>Sub Category</th>
            <!-- <th>Status</th> -->
            <th>Date</th>
          </tr>
        </thead>
        
        <tbody id="searchtable" class="text-center" style="font-size:.9em;">
          
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- View Generic Product Details -->
<div class="modal fade" id="gproddetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="gprodtitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-borderless">
          <tr>
            <td><span class="h5">Description</span></td>
            <td><span id="gpdesc"></span></td>
          </tr>
          <tr>
            <td><span class="h5">Weight</span></td>
            <td><span id="gpweight"></span></td>
          </tr>
          <tr>
            <td><span class="h5">Category</span></td>
            <td><span id="gpcat"></span></td>
          </tr>
          <tr>
            <td><span class="h5">Sub Category</span></td>
            <td><span id="gpsubcat"></span></td>
          </tr>
          <tr>
            <td><span class="h5">Images</span></td>
            <td><span id="gpimages"></span></td>
          </tr>
          
          
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Add Generic Product-->
<div class="modal fade" id="gpnew" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Generic Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="gpnewform">
            <div class="form-group">
                <label for="exampleFormControlInput1">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Milo Drink" required>
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Description</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Description" required>
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Weight <span style="font-size:0.8em;">(kg)</span></label>
                <input type="number" class="form-control" id="weight" name="weight" placeholder="Weight" required>
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Category</label>
                <select name="categoryId" id="categoryId">
                    <option value="0">Select One:</option>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Sub Category</label>
                <select name="subcategoryId" id="subcategoryId">
                    
                </select>
            </div>
        </form>
            <div class="form-group">
                <label for="exampleFormControlInput1">Image URL <span style="font-size:0.8em;">(Paste image links here)</span></label>
                <input type="text" class="form-control" id="image1" name="imageURL1" placeholder="Image URL 1">
                <input type="text" class="form-control" id="image2" name="imageURL2" placeholder="Image URL 2">
                <input type="text" class="form-control" id="image3" name="imageURL3" placeholder="Image URL 3">
                <input type="text" class="form-control" id="image4" name="imageURL4" placeholder="Image URL 4">
            </div>

        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="addgpbutton">Add Generic Product</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Add Bulk Generic Product-->
<div class="modal fade" id="bulkgpnew" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Bulk Generic Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="gpnewform">
            <div class="form-group">
                <label for="exampleFormControlInput1">Upload Excel File:</label>
                <input type="file" class="form-control" id="gpfile" name="gpfile" required>
            </div>
            
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="addgpbutton">Upload Bulk Generic Products</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>




$(document).ready(function(){
  var Token = $('#Token').val();

  $('#showgpbutton').click(()=>{
    $('#gpnew').modal('show');

    $.ajax({
      url: '/api/product/categories',
      type: 'GET',
      beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
      success: function(xhtR) {
            k = 0;
            var catselect = $('#categoryId');
            while(k < xhtR.categories.length){
                
                
                catselect.append($('<option>', {
                    value: xhtR.categories[k]['id'],
                    text: xhtR.categories[k]['name']
                }));

                
                k++;
            }
     }
    });
  });

  $('#categoryId').on('change', function() {
    catid = $(this).find(":selected").val();
    $.ajax({
      url: '/api/product/subcategories?categoryId='+catid,
      type: 'GET',
      beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
      success: function(xhtR) {
            k = 0;
            var catselect = $('#subcategoryId');
            catselect.empty();
            while(k < xhtR.subCategories.length){
                
                catselect.append($('<option>', {
                    value: xhtR.subCategories[k]['id'],
                    text: xhtR.subCategories[k]['name']
                }));

                
                k++;
            }
     }
    });
  });

  $('#addgpbutton').click((e)=>{
    $('#gpnew').modal('hide'); 
        image1=$('#image1').val();
        image2=$('#image2').val();
        image3=$('#image3').val();
        image4=$('#image4').val();

        img1 = [image1, image2, image3, image4];
        img2 = [];
        img1.forEach((val)=>{
            if(val != ''){
                img2.push(val);
            }
        });
        
        e.preventDefault();
        $.ajax({
            url: '/api/product/generic/create',
            type: 'POST',
            beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
            data: $('#gpnewform').serialize()+'&imageURL='+img2,
            success: function(xhtR) {
                
                $('#errormsg').removeClass('alert-warning').removeClass('alert-danger').addClass('alert-success').fadeIn('slow','linear',function(){
                    $(this).html(xhtR.statusMsg);
                });
                loadGenericProducts(true);
                setTimeout(closeAlert, 5000);

                $('#title').val();
                $('#description').val();
                $('#weight').val();
                $('#categoryId').val();
                $('#subcategoryId').val();
                $('#image1').val();$('#image2').val();$('#image3').val();$('#image4').val();
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

  $('#showaddbulkgpbutton').click(()=>{
    $('#bulkgpnew').modal('show');
  });
  
  function loadGenericProducts(tablestate){
    var table = '';
    $.ajax({
      url: '/api/product/generic/all',
      type: 'POST',
      beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
      data: 'id=',
      success: function(xhtR) {
        

        var tbody = $('tbody#searchtable');
        tbody.empty();
        var k = 0;
        
        bp = [];
        for(j=0;j<xhtR.products.length;j++){
            bp.push(xhtR.products[j]);
        }
        
        while (k < bp.length) {
            var sn = k+1;
            var created = bp[k]['createdAt'];
            ind = created.indexOf('T');
            created = created.substring(0, ind);
            // create an <tr> element, append it to the <tbody> and cache it as a variable:
            var tr = $('<tr/>').appendTo(tbody);
            // append <td> elements to previously created <td> element:
            
            tr.append('<td>'+ sn + '</td>');
            tr.append('<td><a class="editlink" title="View Details" href="javascript:void(0);" data-location="'+bp[k]['uid']+'">' + bp[k]['title'] + '</a></td>');
            tr.append('<td>' + bp[k]['category'] + '</td>');
            tr.append('<td>' + bp[k]['subcategory'] + '</td>');
            tr.append('<td>' + created + '</td>');
            
            k++;
        }

        $('.editlink').click(function(){
                                
            var id = $(this).attr("data-location");
            $('#gproddetails').modal('show');
            $.ajax({
                url: '/api/product/generic/all',
                type: 'POST',
                beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', Token);},
                data: 'id='+id,
                success: function(xhtR) {
                    prod = xhtR.product;

                    $('#gprodtitle').html(prod.title);
                    $('#gpdesc').html(prod.description);
                    $('#gpcat').html(prod.category);
                    $('#gpsubcat').html(prod.subcategory);
                    $('#gpweight').html(prod.weight);
                    
                    var spaa = $('#gpimages');
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

  loadGenericProducts();

});
</script>