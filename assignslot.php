<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Assign Slots</title>
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
                            <a class="nav-link" href=#>HELLO ADMIN</a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link " href="admindash.html">DASHBOARD</a><!--Change link-->
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
                                <table class="table">
                                    <thead class="thead-dark">
                                      <tr>
                                        <th scope="col">Teachers</th>
                                        <th scope="col">Time-Slots</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      require 'app/classes/connect.php';
                                      $query1='select Teacher_id,Batch_id from timetable';
                                      $result1 = mysqli_query($connection,$query1);


                                      $sql = "SELECT * FROM timetable";
                                  if($result1 = mysqli_query($connection, $sql)){
                                    if(mysqli_num_rows($result1) > 0){
                                        echo "<table>";

                                        while($row = mysqli_fetch_array($result1)){
                                            echo "<tr>";

                                              $Teacher_id=$row['Teacher_id'];
                                              $Batch_id=$row['Batch_id'];

                                              $sq2="select Name from teacher where Teacher_id=$Teacher_id";
                                              $result2 = mysqli_query($connection, $sq2);
                                              $row = mysqli_fetch_array($result2);
                                              $Name=$row[0];
                                                  echo "<td> ".$Name." </td>";
                                              if($result2 = mysqli_query($connection, $sq2)){
                                              if(mysqli_num_rows($result2) > 0){
                                              while($row = mysqli_fetch_array($result2)){

                                                  // echo "</tr>";
                                                  // echo "<td>";
                                                 ?>


                                              <?php
                                              $sq3="select Time from batch where Batch_id=$Batch_id";
                                              if($result3 = mysqli_query($connection, $sq3)){
                                              if(mysqli_num_rows($result3) > 0){
                                              while($row = mysqli_fetch_array($result3)){
                                                  $Time=$row[0];
                                                  // print_r($row[0]);
                                                  // echo $Time;
                                                  ?>

                                                  <ul class="tags">
                                                  <td><a class="tag"><?php echo $Time ?> </a></td>


                                            </ul>

                                        </tr>
                                        <?php
                                          }
                                        }
                                      }

                                        }
                                      }

                                      }
                                    }
                                  }

                                }
                                ?>


                                    </tbody>
                                  </table>
                                <!--<div class="col-lg-12">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Assign slots</h1>
                                        </div>
                                        <form action="#">
                                            <label for="batchdate" style="padding-right:22px;">Batch Date  </label>
                                            <input type="date" id="batchdate" name="batchdate"><br>
                                            <label for="slot_st_time">Slot start time</label>
                                            <input type="text" id="slot_st_time" name="slot_st_time">
                                            <label for="am_pm_1">AM/PM</label>
                                            <select id="am_pm_1" name="am_pm_1"><br>
                                            <option value="AM">AM</option>
                                            <option value="PM">PM</option>
                                            </select>
                                            <label for="slot_sp_time">Slot stop time</label>
                                            <input type="text" id="slot_sp_time" name="slot_sp_time">
                                            <label for="am_pm_2">AM/PM</label>
                                            <select id="am_pm_2" name="am_pm_2">
                                            <option value="AM">AM</option>
                                            <option value="PM">PM</option>
                                            </select>

                                            <input type="submit" value="Submit" class="btn btn-warning btn-user btn-block" style="margin:15px;">
                                        </form>
                                    </div>
                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
  </div>




      </body>
          </html>
