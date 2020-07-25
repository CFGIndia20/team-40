<?php
require "app/init.php";
if(!empty($_POST)){
    $email = $_POST['email'];
    $token = $_POST['token'];
    $password = $_POST['password'];

    if($tokenHandler->isValid($token,0)){
        $password_update_flag = $auth->resetUserPassword($token, $password);
    $token_update_flag = $tokenHandler->deleteToken($token);

    if($password_update_flag && $token_update_flag){
      header("Location: signin.php");
      ?>
      <!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="assets/css/sb-admin-2.css">
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
<div class="shadow-lg p-3 mb-5 bg-white rounded" id="snackbar">Your password has been reset successfully!</div>

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
        
    }else{
        echo "Sorry, there was some issue while updating your password, please retry later!";
    }
    }
    else{
        echo "<p>Your time to reset the password has expired!</p>";
    }

    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>

    <!-- Custom fonts for this template-->
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.css" rel="stylesheet">
</head>
<body>

    <?php
    if(isset($_GET['token']) && isset($_GET['email'])):
        $token = $_GET['token'];
        $email = $_GET['email'];

        if($tokenHandler->isValid($token, 0)):
    ?>
    <div class="container">

<!-- Outer Row -->
<div class="row justify-content-center">

  <div class="col-xl-10 col-lg-12 col-md-9">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
          <div class="col-lg-6">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-2">Reset Your Password</h1>
              </div>
            
    <form action="reset-password.php" method="POST" class="user">
            <input type="hidden" name="token" value="<?=$token;?>">
            <div class="form-group">
                <input type="text" value="<?= $email;?>" name="email" class="form-control form-control-user" readonly>
            </div>
            <div class="form-group">
                
                <input type="password" name="password" class="form-control form-control-user" placeholder="Password">
            </div>
            
            <input type="submit" value="Reset My Password" class="btn btn-primary btn-user btn-block">
    </form>
    </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
<?php
    else:
        header("Location: something-fishy.html");

        // echo "<a href='something-fishy.html'>Something Fishy! I'll report to admin!</a>";
    endif;
else:
// header("Location: omg.html");

endif;
?>
</body>
</html>