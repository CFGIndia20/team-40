<?php 
require_once "app/init.php";

if(!empty($_POST)){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rememberMe = $_POST['rem'] ?? null; 
    // from php 7 - short of ternary operator

    $validator = new Validator($database, $errorHandler);
    $validation = $validator->check($_POST, [
        'email' => [
            'required' => true
        ],
        'password' => [
            'required' => true
        ]
    ]);

    if($validation->fails()){
        //display the errors
        echo "<pre>", print_r($validation->errors()->all()), "</pre>";
    }else{
        $signin = $auth->signIn([
            'email' => $email,
            'password' => $password
        ]);
            
        if($signin){
            if($rememberMe){
                $token = $tokenHandler->createRememberMeToken($userHelper->getUserByEmail($email)->id);
                setcookie('token', $token, time()+1800); //time() returns time in milliseconds +1800 means 30minutes 
                //die(var_dump($token));
            }
            header('Location: index.php');
        }
    }
}

if(isset($_COOKIE['token']) && $tokenHandler->isValid($_COOKIE['token'], 1)){
    header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Sign In</title>
        <!-- Custom fonts for this template-->
        <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.css" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light  sticky border-0 shadow-lg my-5" style="margin: 0 !important";>
            <div class="col-md-9">
                <a class="navbar-brand" href="#">THE/<span class="text-my-color">NUDGE FOUNDATION</span></a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="col-md-3">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">LOGIN <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="signup.php">REGISTER</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link " href="#"></a>
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
                                <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
                                <div class="col-lg-12">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Welcome Back Admin!</h1>
                                        </div>
                                        <form class="user" action="signin.php" method="POST">
                                            <div class="form-group">
                                                <input type="email" name="email" class="form-control form-control-user" placeholder="Enter Email..." required>
                                            </div>
                                            <div class="form-group">
                        
                                                <input type="password" name="password" class="form-control form-control-user" placeholder="Password" required>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" name="rem"  class="custom-control-input" id="customCheck">
                                                    <label class="custom-control-label" for="customCheck">Remember Me</label>
                                                </div>
                                            </div>
                                            <!-- <label class="custom-control-label" for="customCheck">Remember Me</label> -->
                                            <input type="submit" value="Login" class="btn btn-primary btn-user btn-block">
                                            <hr>
                                            <a href="#" class="btn btn-google btn-user btn-block">
                                                <i class="fab fa-google fa-fw"></i> Login with Google
                                            </a>
                                            <a href="#" class="btn btn-facebook btn-user btn-block">
                                                <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                            </a>
                                        </form>
                                        <hr>
                                        <div class="text-center">
                                            <a class="small" href="forgot-password.php">Forgot Password?</a>
                                        </div>
                                        <div class="text-center">
                                            <a class="small" href="signup.php">Create an Account!</a>
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