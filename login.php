<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">  -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/odalogo.png" />

    <title>Login Page - Oda Admin Portal</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
  </head>

  <body class="text-center">
    
    <form class="form-signin">
      <img class="mb-4" src="images/odalogo.png" alt="Logo" width="150">
      <h1 class="h3 mb-3 font-weight-normal">Oda Admin Portal</h1>
      <label for="inputEmail" class="sr-only">Email address / Mobile Number</label>
      <input type="email" id="inputEmail" class="form-control" placeholder="Email address / Mobile Number" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
      <button class="sub btn btn-lg btn-primary btn-block">Sign in</button>
      <p id="errormsg" class="alert mt-3" style="font-weight:bold;display:none;"></p>
      <p id="errormsg2" class="alert alert-success mt-3" style="font-weight:bold;display:none;"></p>
      <p id="preloader" class="mt-3" style="display:none;"><img src="images/preloader.gif" width="15%"></p>
      <p class="mt-5 mb-3 text-muted"><small>© Maon Technology Limited <script>document.write(new Date().getFullYear());</script></small></p>
    </form>

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <script src="vendor/host.js"></script>

    <script>

        function closeAlert(){
            $('#errormsg').html('').fadeOut('slow');
        }

        function setSession(id, name, account_type, token, pass, reset){
            var data1 = "id="+id+"&fullname="+name+"&account_type="+account_type+"&token="+token+"&pass="+pass+"&reset="+reset;
            //set session variables
            $.ajax({
                url: '/includes/setSession.inc.php',
                type: 'GET',
                data: data1,
                success: function(xhtR) {
                    $('#errormsg').hide();
                    $('#errormsg2').fadeIn('slow','linear',function(){
                        $(this).html("Login Successful");
                        $("#preloader").hide();
                    });
                    setTimeout(function(){
                        window.location.href = 'home.php';  
                    }, 3000); 
                }
            });
            
        }
        
        $(document).ready(function(){
            $('.sub').click(function(e){
                e.preventDefault();
                $("#preloader").show();
                let mobile = $('#inputEmail').val();
                let email = $('#inputEmail').val();
                var password = $('#inputPassword').val();
                let type = isNaN($('#inputEmail').val()) ? 'email' : 'mobile';
                
                
                    $.ajax({
                        url: '/api/login',
                        type: 'POST',
                        data: "mobile="+mobile+"&email="+email+"&password="+password+"&type="+type,
                        success: function(xhtR) {
                            //xhtR = JSON.parse(xhtR);
                            console.log(xhtR);
                            //if he has reset password, set to 1
                            let resett = xhtR.user['firstreset'] === true ? '1' : '0';
                            console.log(resett);
                            if(xhtR.user['registerAs'] == 'MASTER ADMIN' || xhtR.user['registerAs'] == '4' || xhtR.user['registerAs'] == '3' || xhtR.user['registerAs'] == 'ADMIN'){
                                setSession(xhtR.user['uid'], xhtR.user['fullName'], xhtR.user['registerAs'], xhtR.token, password, resett);
                            }else{
                                $('#errormsg').removeClass('alert-warning').addClass('alert-danger').fadeIn('slow','linear',function(){
                                    $(this).html("This User Is Not An Admin");
                                    $("#preloader").hide();
                                
                                });
                            }
                        },
                        error: function(request, status, error){
                            request = JSON.parse(request.responseText);
                            $('#errormsg2').hide();
                            $('#errormsg').removeClass('alert-warning').addClass('alert-danger').fadeIn('slow','linear',function(){
                                $(this).html(request.statusMsg);
                                $("#preloader").hide();
                            
                            });
                            //setTimeout(closeAlert, 7000);
                        }
                    });
                    
            });  
        });
        
    </script>

  </body>
</html>