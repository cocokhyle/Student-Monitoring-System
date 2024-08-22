<?php
include '../Includes/dbcon.php';
include '../Includes/session.php';

$query = "SELECT tblclass.className, tblclassarms.classArmName 
    FROM tblclassteacher
    INNER JOIN tblclass ON tblclass.Id = tblclassteacher.classId
    INNER JOIN tblclassarms ON tblclassarms.Id = tblclassteacher.classArmId
    WHERE tblclassteacher.Id = '$_SESSION[userId]'";

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
                        <h1 class="h3 mb-0 text-gray-800">Student Grades</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Manage Grades</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View Grades</li>
                        </ol>
                    </div>

                    <div class="row mb-3">
    <?php

    // Fetch subjects from the database
    $querySubjects = "SELECT * FROM tblsubjects WHERE classId = " . $_SESSION['classId'];
    $resultSubjects = $conn->query($querySubjects);

    if ($resultSubjects) {
        while ($rowSubject = $resultSubjects->fetch_assoc()) {
            $subjectId = $rowSubject['Id'];
            $subjectName = $rowSubject['subjectName'];
            ?>
            <!-- Generate HTML for each subject -->
            <div class="col-xl-12 col-md-6 mb-4 mt-n4">
                <div class="card">
                    <div class="card-body">
                        <div class="text-xl font-weight-bold text-uppercase mb-1 text-center"><?php echo $subjectName; ?></div>
                        <div class="row align-items-center">
                            <?php
                            // Fetch grading records for each grading period
                            $queryGrades = "SELECT grade, termName FROM tblgrades
                                INNER JOIN tblterm ON tblgrades.termId = tblterm.Id
                                WHERE subjectId = $subjectId
                                AND studentId = " . $_SESSION['admissionNumber'] . "
                                ORDER BY tblterm.Id"; // Assuming termId represents grading periods sequentially

                            $resultGrades = $conn->query($queryGrades);

                            // Initialize an array to store grades
                            $gradesArray = array();

                            if ($resultGrades) {
                                while ($rowGrade = $resultGrades->fetch_assoc()) {
                                    $grade = $rowGrade['grade'];
                                    $termName = $rowGrade['termName'];

                                    // Store the grade in the array
                                    $gradesArray[] = array("termName" => $termName, "grade" => $grade);
                                }
                            }

                            // If there are no grades for this subject, display "N/A" for all grading periods
                            if (empty($gradesArray)) {
                                for ($i = 1; $i <= 4; $i++) { // Assuming 3 grading periods
                                    ?>
                                    <div class="col-xl-6 col-md-4 mb-4">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs text-uppercase mb-1 text-center">
                                                            Grading Period <?php echo $i; ?> <br>
                                                            <h4 class="text-xs-1 font-weight-bold text-uppercase mt-1">
                                                                N/A
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                // Loop through the gradesArray and display grades
                                foreach ($gradesArray as $gradeItem) {
                                    ?>
                                    <div class="col-xl-6 col-md-4 mb-4">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs text-uppercase mb-1 text-center">
                                                            <?php echo $gradeItem['termName']; ?> <br>
                                                            <h4 class="text-xs-1 font-weight-bold text-uppercase mt-1">
                                                                <?php echo $gradeItem['grade'] != '' ? $gradeItem['grade'] : 'N/A'; ?>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                // Check if there are any remaining grading periods and add "N/A"
                                for ($i = count($gradesArray); $i < 4; $i++) { // Assuming 3 grading periods
                                    ?>
                                    <div class="col-xl-6 col-md-4 mb-4">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs text-uppercase mb-1 text-center">
                                                            Grading Period <?php echo $i + 1; ?> <br>
                                                            <h4 class="text-xs-1 font-weight-bold text-uppercase mt-1">
                                                                N/A
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } // End of while ($rowSubject = $resultSubjects->fetch_assoc())
    } else {
        echo "No subjects found in the database.";
    }
    ?>
</div>

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
