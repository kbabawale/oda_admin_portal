<div class="row">
    <div class="col-lg-12">
        <h1 class="h4 mt-4"><i class="fa fa-table"></i>&nbsp;Products
            <div class="btn-group pull-right" role="group" aria-label="">
                <button type="button" id="all_brandproducts_btn" class="btn btn-info"><i class="fa fa-table"></i> Brand Products</button>
                <button type="button" id="all_genericproducts_btn" class="btn btn-warning"><i class="fa fa-table"></i> Generic Products</button>
            </div>
        </h1>
    </div>
</div>
<hr>

<div id="productbody" class="mb-3">
  
</div>
  
  <script>
    function loadAllBrandProducts(){
      
        $.ajax({
          url: '/includes/allbrandproducts.inc.php',
          type: 'GET',
          success: function(xhtR) {
              $('#productbody').html(xhtR);   
          },
          error: function(){
              $('#errormsg').removeClass('alert-warning').addClass('alert-danger').fadeIn('slow','linear',function(){
                  $(this).html("Couldn't Open Page. Try again!");
              });
              setTimeout(closeAlert, 3000);
          }
        });
    
    }

    function loadAllGenericProducts(){
      
      $.ajax({
        url: '/includes/allgenericproducts.inc.php',
        type: 'GET',
        success: function(xhtR) {
            $('#productbody').html(xhtR);   
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
        loadAllBrandProducts();
      
      $("#all_brandproducts_btn").click(function(){
        loadAllBrandProducts();
      });

      
      $("#all_genericproducts_btn").click(function(){
        loadAllGenericProducts();
      });
      
  
      
      
    });
  </script>