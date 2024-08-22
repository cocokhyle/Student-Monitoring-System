<?php
include '../Includes/dbcon.php';
include '../Includes/session.php';


$query = "SELECT tblclass.className,tblclassarms.classArmName 
    FROM tblclassteacher
    INNER JOIN tblclass ON tblclass.Id = tblclassteacher.classId
    INNER JOIN tblclassarms ON tblclassarms.Id = tblclassteacher.classArmId
    Where tblclassteacher.Id = '$_SESSION[userId]'";

$rs = $conn->query($query);
$num = $rs->num_rows;
$rrw = $rs->fetch_assoc();


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/attnlg.png" rel="icon">
  <title>Dashboard</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <link href="css/ruang-admin.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <?php include "Includes/sidebar.php"; ?>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <?php include "Includes/topbar.php"; ?>
        <!-- Topbar -->
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Student Dashboard</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>

          <div class="row mb-3">
           <?php

            $query1 = mysqli_query($conn, "SELECT * from tblstudents where classId = '$_SESSION[classId]' and classArmId = '$_SESSION[classArmId]'");
            $students = mysqli_num_rows($query1);
            ?>
            <div class="col-l-2 col-md-8 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    
                    
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1 text-center">Academic Standing</div>
                      <div class="align-items-center">
                        <div class="progress" style="width: 225px; height: 225px;" data-num="70">
                          <div class="position-absolute ">
                            <svg class="posistion-relative " style="width: 200px; height: 200px;" > 
                              <circle class="progress-circle__bg" r="90" cx="100" cy="100"></circle>
                              <circle class="progress-circle__fill" r="90" cx="100" cy="100" stroke-dasharray="300%">
                              </circle>
                              <text x="50%" y="50%" text-anchor="middle" class="progress-circle__text">70%</text>
                            </svg>
                          </div>
                        </div>

                      </div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <!-- <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 20.4%</span>
                        <span>Since last month</span> -->
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <!-- Earnings (Annual) Card Example -->
           

            <!-- Pending Requests Card Example -->
            <?php
            $query1 = mysqli_query($conn, "SELECT * from tblattendance where classId = '$_SESSION[classId]' and classArmId = '$_SESSION[classArmId]' and status = '1 '");
            $totAttendance = mysqli_num_rows($query1);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Student Attendance</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo $totAttendance; ?>
                      </div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <!-- <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                        <span>Since yesterday</span> -->
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-warning"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
    // Assuming you have already established a database connection.
    $querySubjects = mysqli_query($conn, "SELECT * FROM tblsubjects WHERE classId = " . $_SESSION['classId']);
    
    while ($subject = mysqli_fetch_assoc($querySubjects)) {
        $subjectName = $subject['subjectName'];
        
        // You can add more columns from the tblsubjects table as needed.
        // For example, $subjectCode = $subject['subject_code'];
        
        // You may want to query the related data for each subject here, like class percentages.
        // Replace the following query with your actual logic.
        // $queryClass = mysqli_query($conn, "SELECT * from tblclass WHERE subjectName='$subjectName'");
       
    ?>
    <div class="col-xl-3 col-md-6  mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="row align-items-center">
                     <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1"><?php echo $subjectName; ?></div>
                        <!-- Display your subject-specific data here, e.g., class percentage -->
                        <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">
                            <?php  ?>%
                        </div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                            <!-- Additional subject-specific data here -->
                        </div>
                    </div>
                    <div class="col-auto">
                        <!-- Use an appropriate icon for the subject -->
                        <i class="fas fa-chalkboard fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
          

            <!--Row-->

            <!-- <div class="row">
            <div class="col-lg-12 text-center">
              <p>Do you like this template ? you can download from <a href="https://github.com/indrijunanda/RuangAdmin"
                  class="btn btn-primary btn-sm" target="_blank"><i class="fab fa-fw fa-github"></i>&nbsp;GitHub</a></p>
            </div>
          </div> -->

          </div>
          <!---Container Fluid-->
        </div>
        <!-- Footer -->
        <?php include 'includes/footer.php'; ?>
  
        <!-- Footer -->
      </div>
    </div>

    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
    <script src="../vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>
</body>

</html>