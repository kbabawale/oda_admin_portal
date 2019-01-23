<?php
if(!isset($_SESSION)) {session_start();}
//check login status and set access levels
require_once 'includes/checkaccess.inc.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="images/odalogo.png" />
  <title>Welcome <?= $sessiondisplayname; ?> - Sunrise Admin Portal</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <input type="hidden" id="UserId" value="<?= $sessionid; ?>" />
  <input type="hidden" id="FullName" value="<?= $sessionfullname; ?>" />
  <input type="hidden" id="Token" value="<?= $sessiontoken; ?>" />
  <input type="hidden" id="hiddenuser" value="" />
  <input type="hidden" id="pass" value="<?= $sessionpass; ?>" />
  <input type="hidden" id="reset" value="<?= $sessionreset; ?>" />
  <input type="hidden" id="type" value="<?= $sessionaccounttype; ?>" />

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="javascript:void(0);"><img src="images/odalogowhite.png" width="25%" /></a> 
    <!-- &nbsp;<span style="font-size:1.1em;">Admin Portal</span> -->
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav pt-3" id="exampleAccordion">
        
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <span id="preloader"><img src="images/preloader.gif" width="8%"></span>
        </li>
        <li class="nav-item">
          <a href="javascript:void(0);" id="profilelink" class="text-center text-light mt-2 mr-4"><i class="fa fa-fw fa-user"></i>Hello <?= $sessiondisplayname; ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="logoutlink" style="color: coral;" title="Logout">
              <i class="fa fa-fw fa-sign-out"></i>&nbsp;Logout</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="dim content-wrapper mb-3">
    <div style="background:#fff;min-height:550px;" class="container-fluid mb-3">

      <!-- Body Content goes here -->
      <div class="container mb-3">
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-warning" id="errormsg" role="alert" style="display:none;margin-bottom:-1%;margin-top:10px;"></div>
            </div>
        </div>
        <div id="wrapper" style="background:#fff;width:100%;" class="container">
          
        </div>
      </div>


    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>© Maon Technology Limited <script>document.write(new Date().getFullYear());</script></small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="login.html">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <!-- <script src="vendor/chart.js/Chart.min.js"></script> -->
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>
    <script src="vendor/host.js"></script>

    <script>
    function closeAlert(){
        $('#errormsg').html('').fadeOut('slow');
    }

    String.prototype.capitalize = function() {
      return this.charAt(0).toUpperCase() + this.slice(1);
    }

    function logoutfunction(){
        $.ajax({
            url: '/includes/logout.inc.php',
            type: 'GET',
            success: function(xhtR) {
                window.location = 'login.php';   
            },
            error: function(){

                $('#errormsg').removeClass('alert-warning').addClass('alert-danger').fadeIn('slow','linear',function(){
                    $(this).html("Couldn't logout. Try again!");
                });
                
            }
        
        });
    }
    
    $('#logoutlink').click(()=>{
      logoutfunction();
    });

    function showInitUsers(){
      //show users page
      $.ajax({
          url: '/includes/users.inc.php',
          type: 'GET',
          success: function(xhtR) {
              $('#wrapper').html(xhtR);   
          },
          error: function(){
              $('#errormsg').removeClass('alert-warning').addClass('alert-danger').fadeIn('slow','linear',function(){
                  $(this).html("Couldn't Open Page. Try again!");
              });
              setTimeout(closeAlert, 3000);
          }
      
      });
    }

    function showprofilepage(){
        //smooth scroll to the top of page
        $("this, body").animate({scrollTop:0},"slow");
        
        $.ajax({
            url: '/includes/profile.inc.php?id='+$('#UserId').val(),
            type: 'GET',
            success: function(xhtR) {
                $('#wrapper').html(xhtR);   
            },
            error: function(request, status, error){
                request = JSON.parse(request.responseText);
                $('#errormsg').removeClass('alert-warning').addClass('alert-danger').fadeIn('slow','linear',function(){
                    $(this).html(request.statusMsg);
                    $("#preloader").hide();
                
                });
                //setTimeout(closeAlert, 7000);
            }
        
        });
    }

    $('#profilelink').click((e)=>{
      e.preventDefault();
      showprofilepage(); 
    });

    function doInitLoad(data1, data2){
      $.ajax({
          url: '/api/admin/getroles',
          //url: 'http://sunrise-api.com.ng/api/admin/getroles',
          type: 'POST',
          data: data1,
          beforeSend: function(xhr){xhr.setRequestHeader('Sunrise-Token', data2);},
          success: function(xhtR) {
            showInitUsers();
            xhtR.roleNames.sort();
            $("#preloader").hide();
            //populate li for each result item
            var cList = $('ul#exampleAccordion');
            $.each(xhtR.roleNames, function(index, value)
            {
                var li = $('<li/>')
                    .addClass('nav-item')
                    .attr('data-placement', 'right')
                    .attr('data-toggle', 'tooltip')
                    .attr('title', value)
                    .appendTo(cList);
                var aaa = $('<a/>')
                    .attr('data-location', value.toLowerCase())
                    .addClass('sidebarlink')
                    .addClass('nav-link')
                    .attr('href', 'javascript:void(0);')
                    .appendTo(li);
                var i = $('<i/>')
                    .addClass('fa')
                    .addClass('fa-fw')
                    .appendTo(aaa);
                var spaan = $('<span/>')
                    .addClass('nav-link-text')
                    .text(value);
                
                if(value=='Users') i.addClass('fa-users');
                if(value=='Stores') i.addClass('fa-cart-plus');
                if(value=='Products') i.addClass('fa-table');
                if(value=='Orders') i.addClass('fa-inbox');
                if(value=='System-Setup') i.addClass('fa-cog');
                if(value=='Admin-Accounts') i.addClass('fa-user-md');

                spaan.appendTo(aaa);
            });

            $(".dim").css('opacity', '1');
            $('.sidebarlink').click(function(e){
                e.preventDefault();
                //smooth scroll to the top of page
                $("this, body").animate({scrollTop:0},"slow");
                
                var location = $(this).attr('data-location');
                console.log(location);
                $.ajax({
                    url: '/includes/'+location+'.inc.php',
                    type: 'GET',
                    success: function(xhtR) {
                        $('#wrapper').html(xhtR);   
                    },
                    error: function(request, status, error){
                        request = JSON.parse(request.responseText);
                        $('#errormsg').removeClass('alert-warning').addClass('alert-danger').fadeIn('slow','linear',function(){
                            $(this).html(request.statusMsg);
                            $("#preloader").hide();
                        
                        });
                        //setTimeout(closeAlert, 7000);
                    }
                
                });
              });        
               
          },
          error: function(request, status, error){
            request = JSON.parse(request.responseText);
            $('#errormsg').removeClass('alert-warning').addClass('alert-danger').fadeIn('slow','linear',function(){
                if(request.statusMsg.toLowerCase() == 'authentication failed.'){
                  $(this).html('An Error Occurred. Kindly Re-Login');
                }else{
                  $(this).html(request.statusMsg+". Kindly See Administrator."); //User has no roles
                }
                $("#preloader").hide();
            });
            //setTimeout(closeAlert, 20000);
            $(".dim").css('opacity', '1');
          }
      });
    }

    $(document).ready(function(){
      let UserId = $('#UserId').val();
      let FullName = $('#FullName').val();
      var Token = $('#Token').val();

      let data1 = "UserId="+UserId;
      let data2 = Token;

  
      //dim opacity of screen
      $(".dim").css('opacity', '0.4');
      $("#preloader").show();

      //show reset password if never reset
      if($('#type').val() == '3' || $('#type').val() == 'ADMIN'){
        if($('#reset').val() == '0'){
          showprofilepage();
          $("#preloader").hide();
          $(".dim").css('opacity', '1');
          $('#errormsg').removeClass('alert-danger').removeClass('alert-success').addClass('alert-warning').fadeIn('slow','linear',function(){
              $(this).html('Change Your Password Before Proceeding');
              $("#preloader").hide();
          });
          setTimeout(closeAlert, 7000);
        }else{
          //list nav link items for user
          doInitLoad(data1, data2);
        }
      }else{
        //list nav link items for user
        doInitLoad(data1, data2);
      }
      

    });

    </script>
  </div>
</body>

</html>
