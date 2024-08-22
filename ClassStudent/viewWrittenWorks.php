<?php
// Include database connection and session files
include '../Includes/dbcon.php';
include '../Includes/session.php';

// Check if a subject parameter is provided in the URL
if (isset($_GET['subject'])) {
    // Sanitize and retrieve the subject parameter from the URL
    $selectedSubject = mysqli_real_escape_string($conn, $_GET['subject']);

    // Construct the SQL query to fetch written works data for the selected subject
   $admissionNumber = $_SESSION['admissionNumber']; // Replace with your actual session variable

// Construct the SQL query to fetch written works data for the selected subject and admission number
   $query = "SELECT tblwrittenworks.*, tblterm.termName 
          FROM tblwrittenworks 
          JOIN tblterm ON tblwrittenworks.termId = tblterm.Id 
          WHERE tblwrittenworks.subjectName = '$selectedSubject' AND tblwrittenworks.studentId = '$admissionNumber'";
    
    // Execute the SQL query
    $result = $conn->query($query);
} else {
    $selectedSubject = 'No subject selected';
}


$data = range(1, 10);
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
                        <h1 class="h3 mb-0 text-gray-800">Written Works / <?php echo htmlspecialchars($selectedSubject); ?></h1>
                    </div>

                    <!-- Add a search bar -->
                    <div class="form-group col-lg-4 row mb-3 ">
                        <input type="text" class="form-control" id="searchInput" placeholder="Search...">
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Scores</h6>
                                </div>
                                <div class="table-responsive p-3">
                                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Subject</th>
                                                <th>Activity Name</th>
                                                <th>Score</th>
                                                <th>Term</th>

                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($result) && $result->num_rows > 0) {
                                                $sn = 0;
                                                while ($row = $result->fetch_assoc()) {
                                                    $sn++;
                                                    $markAsDoneText = $row['isMarked']
                                                    ? 'Successfully marked'
                                                    : '<button class="mark-as-done" data-id="' . $row['id'] . '">Mark as Done<span style="color: red;">*</span></button>';
                                                                                                    
                                                    echo '<tr>
                                                            <td>' . $sn . '</td>
                                                            <td>' . $row['subjectName'] . '</td>
                                                            <td>' . $row['activityName'] . '</td>
                                                           <td>' . $row['grade'] ."/" .$row['overallScore']. '</td>
                                                            <td>' . $row['termName'] . '</td>
                                                            <td>' . $markAsDoneText . '</td>
                                                        </tr>';
                                                }
                                            } else {
                                                echo '<tr><td colspan="5">No written works data found for the selected subject.</td></tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
    
    <script>
        // jQuery code to handle the "Mark as done" button click event
        $(document).ready(function () {
            $(".mark-as-done").on("click", function () {
                var button = $(this);
                var id = button.data("id");
                
                // Send an AJAX request to update the database
                $.ajax({
                    url: 'markAsDone.php', // Create a new PHP file for handling the update
                    method: 'POST',
                    data: { id: id },
                    success: function (response) {
                        if (response === 'success') {
                            // Update the button text and add a "Successfully marked" message
                            button.replaceWith('Successfully marked');

                            button.closest('tr').find('.mark-as-done-cell').text('Successfully marked');
                             location.reload(true);
                        } else {
                            alert('' + response);
                            button.replaceWith('Successfully marked');

                            button.closest('tr').find('.mark-as-done-cell').text('Successfully marked');
                             location.reload(true);
                        }
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            });

            // jQuery code to filter the table rows based on the search input
            $("#searchInput").on("keyup", function () {
                var searchText = $(this).val().toLowerCase();
                $("table tbody tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
                });
            });
        });
    </script>
</body>

</html>
