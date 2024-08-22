<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

$statusMsg = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve the student's data based on the provided ID
    $query = "SELECT * FROM tblwrittenworks WHERE id = '$id'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $studentId = $row['studentId'];
        $activityName = $row['activityName'];
        $scoreGrade = $row['grade'];
        $selectedSubject = $row['subjectName']; // Get the subjectName from the row
        // Handle form submission for updating the score
        if (isset($_POST['update'])) {
            $newScoreGrade = $_POST['newScoreGrade'];

            // Update the score in the database
            $updateQuery = "UPDATE tblwrittenworks SET grade = '$newScoreGrade' WHERE id = '$id'";
            if ($conn->query($updateQuery) === TRUE) {
                // Score updated successfully
                $statusMsg = "Score updated successfully!";

                // Redirect back to the previous page with the subject information
                echo "<script>
                        setTimeout(function() {
                            window.location.href = 'writtenWorks.php?subject=" . urlencode($selectedSubject) . "'; // Include subject information in the URL
                        }, 1000); // Delay for 2 seconds
                      </script>";
            } else {
                $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>Error updating score: " . $conn->error . "</div>";
            }
        }
    } else {
        // Student not found, handle error
        $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>Student not found.</div>";
    }
} else {
    // Handle the case where the 'id' parameter is not set in the URL
    header("Location: writtenWorks.php"); // Replace with the actual URL of the previous page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Add your head content here -->
</head>

<body>
    <!-- Add your HTML content for the score editing form here -->
    <form method="post">
        <label for="newScoreGrade">New Score:</label>
        <input type="text" name="newScoreGrade" id="newScoreGrade" value="<?php echo $scoreGrade; ?>" required>
        <button type="submit" name="update">Update</button>
    </form>
   <script>
    // Get the status message from PHP
    var statusMsg = "<?php echo $statusMsg; ?>";

    // Check if the status message is not empty
    if (statusMsg !== "") {
        // Display the status message as an alert
        alert(statusMsg);
    }
</script>
</body>

</html>
