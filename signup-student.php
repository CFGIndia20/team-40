<?php 
require_once "app/init.php";
if(!empty($_POST)){
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];

    $validator = new Validator($database, $errorHandler);
    $validation = $validator->check($_POST, [
        'email' => [
            'required' => true,
            'maxlength' => 255,
            'unique' => 'users',
            'email' => true
        ],
        'name' => [
            'required' => true,
            'minlength' => 2,
            'maxlength' => 20,
            'unique' => 'users'
        ],
        'password' => [
            'required' => true,
            'minlength' => 8 
        ]
    ]);

    if($validation->fails()){
        //display the errors
        echo "<pre>", print_r($validation->errors()->all()), "</pre>";
    }else{
        //create the user
        $created = $auth->create([
            'email' => $email,
            'name' => $name,
            'password' => $password
        ]);
        if($created){
            header("Location: index.php");
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
        <title>Sign Up</title>

        <!-- Custom fonts for this template-->
        <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.css" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light  sticky border-0 shadow-lg my-5" style="margin-top: 0 !important";>
            <div class="col-md-9">
                <a class="navbar-brand" href="#">THE/ <span class="text-my-color">NUDGE FOUNDATION</span></a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="col-md-3">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="signin.php">LOGIN </a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="#">REGISTER <span class="sr-only">(current)</span></a>
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
                        <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Create an Account Student!</h1>
                                </div>
                                <form action="signin-student.php" method="POST" class="user">
                                    <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                
                                            <input type="text" name="name" class="form-control form-control-user" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="form-group">

                                        <input type="text" name="email" class="form-control form-control-user" placeholder="Email Address" required>
                                    </div>
                                    <div class="form-group">

                                        <input type="tel" name="phone" class="form-control form-control-user" placeholder="Phone Number" required>
                                    </div>
                                    <div class="form-group">
                                    <input type="number" name="age" class="form-control form-control-user" placeholder="Age" required>
                                    </div>
                                    
                        
                                    <?php 
                                        if($validation->errors()->has('email')):
                                        ?>
                                        <p class="danger">
                                        <?= $validation->errors()->first('email');?>
                                        </p>
                                    <?php endif; ?>
                    
                                    <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <input type="password" name="password" class="form-control form-control-user" placeholder="Password" minlength="8" required >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                    <input type="text" name="aadhar" class="form-control form-control-user" placeholder="Aadhar Number" required>
                                    </div>
                                    <!-- <div class="form-group"> -->
                                    <input type="file" name="file" class="" style="margin-bottom:30px;"  required>
                                    
                    
                                    <input type="submit" value="Register Account" class="btn btn-primary btn-user btn-block">
                                    <hr>
                                    <a href="#" class="btn btn-google btn-user btn-block">
                                        <i class="fab fa-google fa-fw"></i> Register with Google
                                    </a>
                                    <a href="#" class="btn btn-facebook btn-user btn-block">
                                        <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                    </a>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="forgot-password.php">Forgot Password?</a>
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