<div class="row">
    <div class="col-lg-12">
        <h1 class="h4 mt-4"><i class="fa-cart-plus"></i>&nbsp;Stores
            <div class="btn-group pull-right" role="group" aria-label="">
                <!-- <button type="button" id="all_brandproducts_btn" class="btn btn-info"><i class="fa fa-table"></i> All Stores</button>-->
                <button type="button" id="add_store_btn" class="btn btn-warning"><i class="fa fa-plus"></i> Add New Store</button>
            </div>
        </h1>
    </div>
</div>
<hr>

<div id="storebody" class="mb-3">
  
</div>
  
  <script>
    function loadAllStores(){
      
        $.ajax({
          url: '/includes/allstores.inc.php',
          type: 'GET',
          success: function(xhtR) {
              $('#storebody').html(xhtR);   
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
        loadAllStores();
      
      
  
      
      
    });
  </script>