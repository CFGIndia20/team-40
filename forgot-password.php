<?php
require 'app/init.php';
// require 'helper/init.php';
if(!empty($_POST)){
    $email = $_POST['email'];
    $user = $userHelper->getUserByEmail($email);
    if($user){
        $token = $tokenHandler->createForgotPasswordToken($user->id);
        if($token){
            $mail->addAddress($user->email);
            $mail->Subject = "Reset Password";
            $mail->Body = "Use the below link within 15 minutes to reset your password, <br> <a href= 'http://localhost:8888/reset-password.php?token={$token}&email={$email}'>Reset Password</a>";
            if($mail->send()){
                // echo "password reset link has been sent";
                ?>
                <!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/sb-admin-2.css">
<style>
#snackbar {
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  background-color: #5bc0de;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 16px;
  position: fixed;
  z-index: 1;
  left: 50%;
  top: 30px;
  border-radius: 5px;

  font-size: 14px;
}

#snackbar.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 5s;
  animation: fadein 0.5s, fadeout 0.5s 5s;
}

@-webkit-keyframes fadein {
  from {top: 0; opacity: 0;} 
  to {top: 30px; opacity: 1;}
}

@keyframes fadein {
  from {top: 0; opacity: 0;}
  to {top: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {top: 30px; opacity: 1;} 
  to {top: 0; opacity: 0;}
}

@keyframes fadeout {
  from {top: 30px; opacity: 1;}
  to {top: 0; opacity: 0;}
}
</style>
</head>
<body>

<!-- <h2>Snackbar / Toast</h2> -->
<!-- <p>Snackbars are often used as a tooltips/popups to show a message at the bottom of the screen.</p> -->
<!-- <p>Click on the button to show the snackbar. It will disappear after 3 seconds.</p> -->



<div class="shadow-lg p-3 mb-5 bg-white rounded" id="snackbar">The password reset link has been sent!</div>

<script>
function myFunction() {
  var x = document.getElementById("snackbar");
  x.className = "show";
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
}
myFunction();
</script>

</body>
</html>

              <?php
                // (ADD_SUCCESS, "The record have been added successfully!");
            }else{
                echo $mail->ErrorInfo;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password</title>

    <!-- Custom fonts for this template-->
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light  sticky border-0 shadow-lg my-5" style="margin-top: 0 !important";>
        <div class="col-md-9">
            <a class="navbar-brand" href="#">MY <span class="text-my-color">WEBSITE</span></a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="col-md-3">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item ">
                        <a class="nav-link" href="#">LOGIN <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="signin.php">REGISTER</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link " href="signup.php"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="index.php">HOME</a>
                    </li>
                </ul>
            </div>
        </div>
        </nav>
<div class="container">

<!-- Outer Row -->
<div class="row justify-content-center">

  <div class="col-xl-6 col-lg-6 col-md-6">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <!-- <div class="col-lg-6 d-none d-lg-block bg-password-image"></div> -->
          <div class="col-lg-12">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                <p class="mb-4">We get it, stuff happens. Just enter your email address below and we'll send you a link to reset your password!</p>
              </div>
    <form action="forgot-password.php" method="POST" class="user">
                    <div class="form-group">
                <input type="email" name="email" class="form-control form-control-user" placeholder="Enter Email Address...">
                    </div>
            
            <input type="submit" value="Reset Password" class="btn btn-primary btn-user btn-block">
        
    </form>
    <hr>
                  <div class="text-center">
                    <a class="small" href="signup.php">Create an Account!</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="signin.php">Already have an account? Login!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
</body>
</html>