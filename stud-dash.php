<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Student dashboard</title>
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

                        <li class="nav-item">
                            <a class="nav-link" href=#>HELLO STUDENT</a>
                        </li>


                        <!-- <li class="nav-item">
                            <a class="nav-link " href="index.php">DASHBOARD</a><!--Change link-->
                        <!-- </li>  -->
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>


    </div>
    <!--Link to go to slot assignment page-->
    <!-- Content Row -->
    <h1 class="h3 mb-0 text-gray-800">Available courses</h1>
    <div class="row">
        <?php
            require_once "app/init.php";
            $con = mysqli_connect("localhost","root","","nudge");
            $get_batch_query = "select * from batch";
            $date_now = date('Y-m-d');
            $batch_queries = mysqli_query($con,$get_batch_query);
            $tot_row = mysqli_num_rows($batch_queries);
            //echo $tot_row;
            if($tot_row>0){
                while($row= mysqli_fetch_row($batch_queries)){
                    if($date_now<$row[2]){
                        $get_student_query = "select Student_id from studentbatch where Batch_id=$row[0]";
                        $student_queries = mysqli_query($con,$get_student_query);
                        $tot_row_stud = mysqli_num_rows($student_queries);
                        $full = false;
                        if($tot_row_stud>21){
                            $full=true;
                        }
                        echo '<div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                              <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                  <div class="col mr-2">

                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Batch id : '.$row[0].'</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Start Date :'.$row[1].'</div><br>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Start time :'.$row[2].'</div><br>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">End time :'.$row[3].'</div><br>';
                        if($full){
                            echo '<button type="button" class="btn btn-secondary"disabled>Full</button>
                        <div class="progress" style="margin-top:10px">
                            <div class="progress-bar bg-danger" style="width:100%"></div>
                         </div>';
                        }else{
                            echo '<button type="button" class="btn btn-success">Enroll</button>
                                    <div class="progress" style="margin-top:10px">
                                        <div class="progress-bar bg-warning" style="width:40%"></div>
                                     </div>';
                        }
                        echo '</div>
                                  <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>';
                    }
                }
            }
          ?>


    </div>
            <!--
              <h1 class="h3 mb-0 text-gray-800">Enrolled courses</h1><br>
              <br>

              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Batch id</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Start Date</div><br>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Start time</div><br>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">End time</div><br>

                        <button type="button" class="btn btn-secondary" disabled>Enrolled</button>
                        <!--  <button type="button" class="btn btn-danger">Enroll</button>
                        <div class="progress" style="margin-top:10px">
                            <div class="progress-bar bg-warning" style="width:40%"></div>
                         </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>-->
              </div>
              </div>

              </body>
              </html>
