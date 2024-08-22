<?php
// Include database connection
include '../Includes/dbcon.php';

// Check if the 'id' parameter is provided via POST request
if (isset($_POST['id'])) {
    // Sanitize and retrieve the ID from the POST data
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    
    // Update the 'isMarked' column in the database
    $updateQuery = "UPDATE tblquarterly SET isMarked = 1 WHERE id = $id";
    
    if ($conn->query($updateQuery) === TRUE) {
        // Return a success message or response back to the client
        echo 'Marked as done successfully!';
    } else {
        // Return an error message or response back to the client
        echo 'Error: ' . $conn->error;
    }
} else {
    // Return an error message if 'id' parameter is not provided
    echo 'Invalid request';
}

// Close the database connection
$conn->close();
?>
