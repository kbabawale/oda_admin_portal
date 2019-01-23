<div class="row">
    <div class="col-lg-12">
        <h1 class="h4 mt-4"><i class="fa fa-cog"></i>&nbsp;System Setup
            <div class="btn-group pull-right" role="group" aria-label="">
                <button type="button" id="all_users_btn" class="btn btn-info"><i class="fa fa-users"></i> Market Leaders</button>
                <button type="button" id="all_vehicletypes_btn" class="btn btn-warning"><i class="fa fa-car"></i> Vehicle Types</button>
                <button type="button" id="all_storetypes_btn" class="btn btn-primary"><i class="fa fa-cart-plus"></i> Store Types</button>
            </div>
        </h1>
    </div>
</div>
<hr>

<div id="syssetupbody" class="mb-3">
  
  </div>
  
  <script>
    function loadAllMarketLeaders(){
      
        $.ajax({
          url: '/includes/allmarketleaders.inc.php',
          type: 'GET',
          success: function(xhtR) {
              $('#syssetupbody').html(xhtR);   
          },
          error: function(){
              $('#errormsg').removeClass('alert-warning').addClass('alert-danger').fadeIn('slow','linear',function(){
                  $(this).html("Couldn't Open Page. Try again!");
              });
              setTimeout(closeAlert, 3000);
          }
        });
    
    }

    function loadAllVehicleTypes(){
        $.ajax({
          url: '/includes/allvehicletypes.inc.php',
          type: 'GET',
          success: function(xhtR) {
              $('#syssetupbody').html(xhtR);   
          },
          error: function(){
              $('#errormsg').removeClass('alert-warning').addClass('alert-danger').fadeIn('slow','linear',function(){
                  $(this).html("Couldn't Open Page. Try again!");
              });
              setTimeout(closeAlert, 3000);
          }
        });
    }

    function loadAllStoreTypes(){
        $.ajax({
          url: '/includes/allstoretypes.inc.php',
          type: 'GET',
          success: function(xhtR) {
              $('#syssetupbody').html(xhtR);   
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
        loadAllMarketLeaders();
      
      $("#all_users_btn").click(function(){
        loadAllMarketLeaders();
      });

      $("#all_vehicletypes_btn").click(function(){
        loadAllVehicleTypes();
      });

      $("#all_storetypes_btn").click(function(){
        loadAllStoreTypes();
      });

      
  
      
      
    });
  </script>