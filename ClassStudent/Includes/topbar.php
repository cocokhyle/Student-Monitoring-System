
<?php 

  $query = "SELECT * FROM tblstudents WHERE Id = ".$_SESSION['userId']."";
  $rs = $conn->query($query);
  $num = $rs->num_rows;
  $rows = $rs->fetch_assoc();
  $fullName = $rows['firstName']." ".$rows['lastName'];
  
$admissionNumber = $_SESSION['admissionNumber'];

// Initialize notification counters for each category
$writtenWorksNotifications = 0;
$performanceTaskNotifications = 0;
$quarterlyAssessmentNotifications = 0;

// Count records where isMarked = 0 in tblwrittenworks
$queryWrittenWorks = "SELECT COUNT(*) AS count FROM tblwrittenworks WHERE isMarked = 0 and studentId =  '$admissionNumber'";
$resultWrittenWorks = $conn->query($queryWrittenWorks);
if ($resultWrittenWorks) {
    $rowWrittenWorks = $resultWrittenWorks->fetch_assoc();
    $writtenWorksNotifications = $rowWrittenWorks['count'];
}

// Count records where isMarked = 0 in tblperformance
$queryPerformance = "SELECT COUNT(*) AS count FROM tblperformance WHERE isMarked = 0 and studentId =  '$admissionNumber'";
$resultPerformance = $conn->query($queryPerformance);
if ($resultPerformance) {
    $rowPerformance = $resultPerformance->fetch_assoc();
    $performanceTaskNotifications = $rowPerformance['count'];
}

// Count records where isMarked = 0 in tblquarterly
$queryQuarterly = "SELECT COUNT(*) AS count FROM tblquarterly WHERE isMarked = 0 and studentId =  '$admissionNumber'";
$resultQuarterly = $conn->query($queryQuarterly);
if ($resultQuarterly) {
    $rowQuarterly = $resultQuarterly->fetch_assoc();
    $quarterlyAssessmentNotifications = $rowQuarterly['count'];
}

// Calculate the total notification count
$totalNotifications = $writtenWorksNotifications + $performanceTaskNotifications + $quarterlyAssessmentNotifications;

?>


<nav class="navbar navbar-expand navbar-light bg-gradient-info topbar mb-4 static-top">
    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">

        <i class="fa fa-bars"> <?php if ($totalNotifications > 0) { ?>
            <span class="badge badge-danger ml-1" style="font-size: 0.75rem;"><?= $totalNotifications ?></span>
        <?php } ?></i>
       
    </button>

    <div class="text-white big" style="margin-left:10px;"></div>

    <!-- User Profile Dropdown -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="img/logo/user-icn.png" style="max-width: 60px">
                <span class="ml-2 d-none d-lg-inline text-white small"><b>Welcome <?php echo $fullName;?></b></span>
                 <i class="fas fa-chevron-down ml-1"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <!-- User Profile Dropdown Items -->
                <!-- ... (your existing dropdown items) ... -->
                 <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="changePassword.php">
                <i class="fas fa-key fa-fw mr-2 text-info"></i> <!-- Change to fa-key icon -->
                Change Password
              </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">
                    <i class="fa fa-sign-out-alt fa-fw mr-2 text-danger"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>