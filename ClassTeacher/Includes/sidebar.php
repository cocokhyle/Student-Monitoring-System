<?php
$query = "SELECT * FROM tblsubjects WHERE classId = " . $_SESSION['classId'] . "";
$rs = $conn->query($query);
$num = $rs->num_rows;
?>

<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
  <a class="sidebar-brand d-flex align-items-center bg-gradient-info justify-content-center" href="index.php">
    <div class="sidebar-brand-icon">
      <img src="img/logo/blogo.png" alt="Logo">
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
  <div class="sidebar-heading">Students</div>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStudents"
      aria-expanded="true" aria-controls="collapseStudents">
      <i class="fas fa-user-graduate"></i>
      <span>Manage Students</span>
    </a>
    <div id="collapseStudents" class="collapse" aria-labelledby="headingStudents" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Manage Students</h6>
        <a class="collapse-item" href="viewStudents.php">View Students</a>
      </div>
    </div>
  </li>
  <hr class="sidebar-divider">
  <div class="sidebar-heading">Manage Written Works</div>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseWrittenWorks"
      aria-expanded="true" aria-controls="collapseWrittenWorks">
      <i class="fas fa-book-open"></i>
      <span>Written Works</span>
    </a>
    <div id="collapseWrittenWorks" class="collapse" aria-labelledby="headingWrittenWorks" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Select Subjects</h6>
        <?php
        if ($num > 0) {
          while ($row = $rs->fetch_assoc()) {
            $subjectName = $row['subjectName'];
            // Add a query parameter to the URL with the subject name
            echo '<a class="collapse-item" href="writtenWorks.php?subject=' . urlencode($subjectName) . '">' . $subjectName . '</a>';
          }
        } else {
          echo '<p class="text-muted">No subjects assigned.</p>';
        }
        ?>
      </div>
    </div>
  </li>
  <hr class="sidebar-divider">
  <div class="sidebar-heading">Manage Performance Tasks</div>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePerformanceTasks"
      aria-expanded="true" aria-controls="collapsePerformanceTasks">
      <i class="fas fa-tasks"></i>
      <span>Performance Tasks</span>
    </a>
    <div id="collapsePerformanceTasks" class="collapse" aria-labelledby="headingPerformanceTasks" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Select Subjects</h6>
        <?php
        // Reset the data pointer in the result set to start over
        $rs->data_seek(0);
        if ($num > 0) {
          while ($row = $rs->fetch_assoc()) {
            $subjectName = $row['subjectName'];
            // Add a query parameter to the URL with the subject name
            echo '<a class="collapse-item" href="performanceTasks.php?subject=' . urlencode($subjectName) . '">' . $subjectName . '</a>';
          }
        } else {
          echo '<p class="text-muted">No subjects assigned.</p>';
        }
        ?>
      </div>
    </div>
  </li>
  <hr class="sidebar-divider">
  <div class="sidebar-heading">Manage Quarterly Assessment</div>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseQuarterlyAssessment"
      aria-expanded="true" aria-controls="collapseQuarterlyAssessment">
      <i class="fas fa-clipboard-list"></i>
      <span>Quarterly Assessment</span>
    </a>
    <div id="collapseQuarterlyAssessment" class="collapse" aria-labelledby="headingQuarterlyAssessment" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Select Subjects</h6>
        <?php
        // Reset the data pointer in the result set to start over
        $rs->data_seek(0);
        if ($num > 0) {
          while ($row = $rs->fetch_assoc()) {
            $subjectName = $row['subjectName'];
            // Add a query parameter to the URL with the subject name
            echo '<a class="collapse-item" href="quarterlyAssessment.php?subject=' . urlencode($subjectName) . '">' . $subjectName . '</a>';
          }
        } else {
          echo '<p class="text-muted">No subjects assigned.</p>';
        }
        ?>
      </div>
    </div>
  </li>
  <hr class="sidebar-divider">
  <div class="sidebar-heading">Activities</div>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrapassests"
      aria-expanded="true" aria-controls="collapseBootstrapassests">
      <i class="fas fa-chalkboard-teacher"></i>
      <span>Manage Academic Grades</span>
    </a>
    <div id="collapseBootstrapassests" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Select Subject</h6>
        <a class="collapse-item" href="academicGrade.php">Quarterly Grades</a>
        <!-- <a class="collapse-item" href="assetsCategoryList.php">Assets Category List</a> -->
        <!-- <a class="collapse-item" href="createAssets.php">Create Assets</a> -->
      </div>
    </div>
  </li>
  <hr class="sidebar-divider">
  <div class="sidebar-heading">Attendance</div>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrapcon"
      aria-expanded="true" aria-controls="collapseBootstrapcon">
      <i class="fa fa-calendar-alt"></i>
      <span>Manage Attendance</span>
    </a>
    <div id="collapseBootstrapcon" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Manage Attendance</h6>
        <a class="collapse-item" href="takeAttendance.php">Take Attendance</a>
        <a class="collapse-item" href="viewAttendance.php">View Class Attendance</a>
        <a class="collapse-item" href="viewStudentAttendance.php">View Student Attendance</a>
        <a class="collapse-item" href="downloadRecord.php">Today's Report (xls)</a>
        <!-- <a class="collapse-item" href="addMemberToContLevel.php ">Add Member to Level</a> -->
      </div>
    </div>
  </li>
  <hr class="sidebar-divider">
</ul>
