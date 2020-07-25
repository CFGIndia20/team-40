<?php 

require_once "app/init.php";
// if($hash->verify('abcd1234', '$2y$10$cZwW.W5Qd9qjykYwzflECO.9Qp0vXsFNKbyqzXj9W2i2xivFpTHYC'))
// {
//     echo "correct!";
// }
// else{
//     echo "Wrong";
// }
//var_dump($database->query("SELECT * FROM contacts));
$auth->build(); //it automatically creates a table for me
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
                <a class="navbar-brand" href="#">THE<span class="text-my-color">/NUDGE FOUNDATION</span></a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="col-md-3">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="signin.php">LOGIN <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="signup.php">REGISTER</a>
                        </li>
                        
                        
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">

            <!-- Outer Row -->
            <div class="row justify-content-center" style="padding-top:200px;">

                <div class="col-xl-10 col-lg-12 col-md-9">
                    <!-- <div class="card o-hidden border-0 shadow-lg my-5"> -->
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row" >
                                <img src="images/nudge-logo.png" alt="" width="800px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </body>
</html>