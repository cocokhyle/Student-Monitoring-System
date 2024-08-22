<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

$statusMsg = ""; // Initialize $statusMsg

// Retrieve termId and sessionName from the database
$query = "SELECT tblterm.Id AS termId, tblterm.termName, tblsessionterm.sessionName, tblsessionterm.id AS sessionId
FROM tblsessionterm
JOIN tblterm ON tblsessionterm.termId = tblterm.Id
WHERE tblsessionterm.isActive = 1";

$rs = $conn->query($query);
$num = $rs->num_rows;
$rrw = $rs->fetch_assoc(); // Fetch the data

if ($num > 0) {
    // Data was fetched Successfully
    $termId = $rrw['termId']; // Assign termId
    $sessionId = $rrw['sessionId']; // Assign sessionName
} else {
    // Handle the case where no data was retrieved
    $termId = 0; // Set a default value for termId
    $sessionName = ""; // Set a default value for sessionName
}

//------------------------SAVE--------------------------------------------------

if (isset($_POST['save'])) {
    // Check if any of the required fields are empty
    if (empty($_POST['taskName']) || empty($_POST['studentName']) || empty($_POST['scoreGrade']) || empty($_POST['overallScore'])) {
        $statusMsg = "<div class='alert alert-danger' style='margin-right: 10px;'>Please fill in all the required fields.</div>";
    } else {
        // Proceed with saving data if all required fields are filled

        // Get the selected subject ID
        $subjectName = $_GET['subject'];
        $studentId = $_POST['studentName']; // Modify to match your actual column name
        $scoreGrade = $_POST['scoreGrade']; // Modify to match your actual column name
        $taskName = $_POST['taskName'];
        $overallScore = $_POST['overallScore']; // Retrieve the overall score

        // Check if the student is already graded for this subject, term, and session
        $checkQuery = mysqli_query($conn, "SELECT * FROM tblperformance WHERE taskName = '$taskName' AND subjectName = '$subjectName' AND studentId = '$studentId' AND termId = '$termId' AND sessionId = '$sessionId'");

        if (!$checkQuery) {
            // Handle query execution error
            $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>Error: " . mysqli_error($conn) . "</div>";
        } else {
            // Check if a record was found
            $existingRecord = mysqli_fetch_array($checkQuery);
            if ($existingRecord) {
                $statusMsg = "<div class='alert alert-danger' style='margin-left:700px;'>The task name for the student is already graded for the selected subject!</div>";
            } else {
                // Insert the data into the tblgrades table
                $insertQuery = mysqli_query($conn, "INSERT INTO tblperformance(subjectName, taskName, studentId, grade, termId, sessionId, isGraded, overallScore) 
                VALUES ('$subjectName','$taskName','$studentId', '$scoreGrade', '$termId', '$sessionId', '1', '$overallScore')");

                if ($insertQuery) {
                    $statusMsg = "<div class='alert alert-success'  style='margin-left:700px;'>Created Successfully!</div>";
                } else {
                    $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error occurred while inserting data: " . mysqli_error($conn) . "</div>";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="img/logo/attnlg.jpg" rel="icon">
    <?php include 'includes/title.php';?>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="css/ruang-admin.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"></script>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include "Includes/sidebar.php";?>
        <div id="content-wrapper" class="d-flex flex-column">
            <?php include "Includes/topbar.php";?>
            <div class="container-fluid" id="container-wrapper">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800"><?php 
                    echo $rrw['termName']. ' / ' .$rrw['sessionName'] . ''; ?></h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="./">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Performance Task

                        </li>
                    </ol>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">
                                     <?php
                                       if (isset($_GET['subject'])) {
                                          $selectedSubject = $_GET['subject'];
                                          echo htmlspecialchars($selectedSubject);
                                        } else {
                                          echo 'No subject selected';
                                        }
                                      ?>
                                </h6>
                                <?php echo $statusMsg; ?>
                            </div>
                            <div class="card-body">
                                <form method="post" id="saveForm" onsubmit="return confirmSave()">
                                    <div class="form-group row mb-3">
                                        <div class="col-xl-4">
                                            <label class="form-control-label">Task Name<span class="text-danger ml-2">*</span></label>
                                            <input type="text" class="form-control" name="taskName" placeholder="Enter an Task name" required>
                                        </div>
                                        <div class="col-xl-4">
                                            <label class="form-control-label">Select Students<span class="text-danger ml-2">*</span></label>
                                            <?php
                                                $qry = "SELECT * FROM tblstudents where classId = '$_SESSION[classId]' and classArmId = '$_SESSION[classArmId]' ORDER BY firstName ASC";
                                                $result = $conn->query($qry);
                                                $num = $result->num_rows;
                                                if ($num > 0) {
                                                    echo '<select required name="studentName" class="form-control mb-3 select2" style="width: 100%">';
                                                    echo '<option value="">--Select Student--</option>';
                                                    while ($rows = $result->fetch_assoc()) {
                                                        echo '<option value="'.$rows['admissionNumber'].'">'.$rows['firstName'].' '.$rows['lastName'].'</option>';
                                                    }
                                                    echo '</select>';
                                                }
                                            ?>
                                        </div>
                                        <div class="col-xl-2">
                                            <label class="form-control-label">Overall Score<span class="text-danger ml-2">*</span></label>
                                            <select class="form-control" name="overallScore" required>
                                                <option value="">--Select Overall Score--</option>
                                                <?php
                                                for ($i = 5; $i <= 50; $i+=5) {
                                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-xl-2">
                                            <label class="form-control-label">Score<span class="text-danger ml-2">*</span></label>
                                            <input type="text" class="form-control" name="scoreGrade" placeholder="Enter a Score" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <!-- Add more form fields here if needed -->
                                    </div>
                                    <button type="submit" name="save" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Performance Tasks Table</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Student Name</th>
                                                <th>Task Name</th>
                                                <th>Score</th>
                                                <th>Edit</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $performanceQuery = "SELECT * FROM tblperformance INNER JOIN tblstudents ON tblperformance.studentId = tblstudents.admissionNumber WHERE subjectName = '$selectedSubject' AND termId = '$termId' AND sessionId = '$sessionId'";
                                                $performanceResult = $conn->query($performanceQuery);

                                                if ($performanceResult->num_rows > 0) {
                                                    while ($row = $performanceResult->fetch_assoc()) {
                                                        echo "<tr>";
                                                        echo "<td>".$row['firstName']." ".$row['lastName']." ".$row['otherName']."</td>";
                                                        echo "<td>".$row['taskName']."</td>";
                                                        echo "<td>".$row['grade']." / ".$row['overallScore']."</td>";
                                                        echo "<td><a href='editPerformanceScore.php?id=".$row['id']."'>Edit</a></td>";
                                                        echo "<td>";
                                                        if ($row['isMarked'] == 1) {
                                                            echo "Successfully Marked";
                                                        } else {
                                                            echo "For Approval";
                                                        }
                                                        echo "</td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='3'>No written works data available</td></tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <script>
            $(document).ready(function () {
                // Initialize Select2
                $('.select2').select2();

                // Initialize DataTable
                $('#dataTable').DataTable();

                function confirmSave() {
                    var confirmation = confirm("Are you sure you want to save the data?");
                    return confirmation;
                }
            });
        </script>
    </body>
</html>
