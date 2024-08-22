<?php
$query = "SELECT * FROM tblsubjects WHERE classId = " . $_SESSION['classId'];
$rs = $conn->query($query);
$num = $rs->num_rows;

$admissionNumber = $_SESSION['admissionNumber'];
// Initialize notification counters
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
$queryPerformance = "SELECT COUNT(*) AS count FROM tblperformance WHERE isMarked = 0 and studentId =  '$admissionNumber' ";
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
?>


<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
  <a class="sidebar-brand d-flex align-items-center bg-gradient-info justify-content-center" href="index.php">
    <div class="sidebar-brand-icon">
      <img src="img/logo/blogo.png">
    </div>
    <div class="sidebar-brand-text mx-3">SAPMS</div>
  </a>
  <hr class="sidebar-divider my-0">
  <li class="nav-item active">
    <a class="nav-link" href="index.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>
  <hr class="sidebar-divider">
  <div class="sidebar-heading">
    Student scores
  </div>
  <!-- Written Works -->
<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseWrittenWorks"
           aria-expanded="true" aria-controls="collapseWrittenWorks">
            <i class="fas fa-book-open"></i>
            <span>Written Works</span>
            <?php if ($writtenWorksNotifications > 0) { ?>
                <span class="badge badge-danger ml-auto" style="font-size: 0.50rem;"><?= $writtenWorksNotifications ?></span>
            <?php } ?>
        </a>
    <div id="collapseWrittenWorks" class="collapse" aria-labelledby="headingWrittenWorks"
         data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Select Subjects</h6>
            <?php
            if ($num > 0) {
              $rs->data_seek(0); // Reset the result set pointer
              while ($row = $rs->fetch_assoc()) {
                  $subjectName = $row['subjectName'];
                  
                  // Check if the subjectName exists in tblwrittenworks with isMarked = 0
                  $isMarkedQuery = "SELECT COUNT(*) AS count FROM tblwrittenworks WHERE subjectName = '$subjectName' AND isMarked = 0 and studentId =  '$admissionNumber'";
                  $isMarkedResult = $conn->query($isMarkedQuery);
                  
                  if ($isMarkedResult && $isMarkedResult->num_rows > 0) {
                      $isMarkedRow = $isMarkedResult->fetch_assoc();
                      $count = $isMarkedRow['count'];
                      
                      // Apply red color if the subject is found in tblwrittenworks with isMarked = 0
                      if ($count > 0) {
                          echo '<a class="collapse-item text-danger" href="viewWrittenWorks.php?subject=' . urlencode($subjectName) . '">' . $subjectName . '</a>';
                      } else {
                          echo '<a class="collapse-item" href="viewWrittenWorks.php?subject=' . urlencode($subjectName) . '">' . $subjectName . '</a>';
                      }
                  } else {
                      // Handle database query error here if needed
                      echo '<a class="collapse-item" href="viewWrittenWorks.php?subject=' . urlencode($subjectName) . '">' . $subjectName . '</a>';
                  }
              }
          }

            ?>
        </div>
    </div>
</li>

<!-- Performance Task -->
 <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePerformanceTask"
           aria-expanded="true" aria-controls="collapsePerformanceTask">
            <i class="fas fa-book-open"></i>
            <span>Performance Task</span>
            <?php if ($performanceTaskNotifications > 0) { ?>
                <span class="badge badge-danger ml-auto" style="font-size: 0.50rem;"><?= $performanceTaskNotifications ?></span>
            <?php } ?>
        </a>
    <div id="collapsePerformanceTask" class="collapse" aria-labelledby="headingPerformanceTask"
         data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Select Subjects</h6>
            <?php
            if ($num > 0) {
    $rs->data_seek(0); // Reset the result set pointer
    while ($row = $rs->fetch_assoc()) {
        $subjectName = $row['subjectName'];
        
        // Check if the subjectName exists in tblwrittenworks with isMarked = 0
        $isMarkedQuery = "SELECT COUNT(*) AS count FROM tblperformance WHERE subjectName = '$subjectName' AND isMarked = 0 and studentId =  '$admissionNumber'";
        $isMarkedResult = $conn->query($isMarkedQuery);
        
        if ($isMarkedResult && $isMarkedResult->num_rows > 0) {
            $isMarkedRow = $isMarkedResult->fetch_assoc();
            $count = $isMarkedRow['count'];
            
            // Apply red color if the subject is found in tblwrittenworks with isMarked = 0
            if ($count > 0) {
                echo '<a class="collapse-item text-danger" href="viewPerformance.php?subject=' . urlencode($subjectName) . '">' . $subjectName . '</a>';
            } else {
                echo '<a class="collapse-item" href="viewPerformance.php?subject=' . urlencode($subjectName) . '">' . $subjectName . '</a>';
            }
        } else {
            // Handle database query error here if needed
            echo '<a class="collapse-item" href="viewPerformance.php?subject=' . urlencode($subjectName) . '">' . $subjectName . '</a>';
        }
    }
}

            ?>
        </div>
    </div>
</li>

<!-- Quarterly Assessment -->
<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseQuarterlyAssessment"
           aria-expanded="true" aria-controls="collapseQuarterlyAssessment">
            <i class="fas fa-book-open"></i>
            <span>Quarterly Assessment</span>
            <?php if ($quarterlyAssessmentNotifications > 0) { ?>
                <span class="badge badge-danger ml-auto" style="font-size: 0.50rem;"><?= $quarterlyAssessmentNotifications ?></span>
            <?php } ?>
        </a>
    <div id="collapseQuarterlyAssessment" class="collapse" aria-labelledby="headingQuarterlyAssessment"
         data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Select Subjects</h6>
            <?php
            if ($num > 0) {
    $rs->data_seek(0); // Reset the result set pointer
    while ($row = $rs->fetch_assoc()) {
        $subjectName = $row['subjectName'];
        
        // Check if the subjectName exists in tblwrittenworks with isMarked = 0
        $isMarkedQuery = "SELECT COUNT(*) AS count FROM tblquarterly WHERE subjectName = '$subjectName' AND isMarked = 0 and studentId =  '$admissionNumber'";
        $isMarkedResult = $conn->query($isMarkedQuery);
        
        if ($isMarkedResult && $isMarkedResult->num_rows > 0) {
            $isMarkedRow = $isMarkedResult->fetch_assoc();
            $count = $isMarkedRow['count'];
            
            // Apply red color if the subject is found in tblwrittenworks with isMarked = 0
            if ($count > 0) {
                echo '<a class="collapse-item text-danger" href="viewQuarterly.php?subject=' . urlencode($subjectName) . '">' . $subjectName . '</a>';
            } else {
                echo '<a class="collapse-item" href="viewQuarterly.php?subject=' . urlencode($subjectName) . '">' . $subjectName . '</a>';
            }
        } else {
            // Handle database query error here if needed
            echo '<a class="collapse-item" href="viewQuarterly.php?subject=' . urlencode($subjectName) . '">' . $subjectName . '</a>';
        }
    }
}

            ?>
        </div>
    </div>
</li>
  <hr class="sidebar-divider">
  <div class="sidebar-heading">
    Student Grades
  </div>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrapcon"
      aria-expanded="true" aria-controls="collapseBootstrapcon">
      <i class="fa fa-calendar-alt"></i>
      <span>Grades</span>
    </a>
    <div id="collapseBootstrapcon" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Manage Grades</h6>
        <a class="collapse-item" href="viewGrades.php">View Grades</a>
      </div>
    </div>
  </li>
 
  <hr class="sidebar-divider">
  <div class="sidebar-heading">
    Attendance
  </div>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
      aria-expanded="true" aria-controls="collapseBootstrap">
      <i class="fas fa-chalkboard"></i>
      <span>My Attendance</span>
    </a>
    <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">View Attendance</h6>
        <a class="collapse-item" href="viewStudentAttendance.php">View</a>
      </div>
    </div>
  </li>
</ul>
