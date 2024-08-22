<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

// Initialize status message
$statusMsg = '';

// Handle form submission
if (isset($_POST['save'])) {
    $email = $_POST['emailAddress'];
    $oldPass = $_POST['oldPass'];
    $newPass = $_POST['newPass'];

    // Verify old password
    $selectQuery = mysqli_query($conn, "SELECT password FROM tblclassteacher WHERE emailAddress = '$email'");
    $row = mysqli_fetch_assoc($selectQuery);
    $encryptedOldPass = $row['password'];

    // Decrypt old password for comparison
    $decryptedOldPass = decryptData($encryptedOldPass);

    if ($oldPass == $decryptedOldPass) {
        // Old password is correct, proceed with the update

        // Encrypt the new password
        $encryptedNewPass = encryptData($newPass);

        $updateQuery = mysqli_query($conn, "UPDATE tblclassteacher SET password = '$encryptedNewPass' WHERE emailAddress = '$email'");

        if ($updateQuery) {
            // Password update successful
            $statusMsg = "<div class='alert alert-success' style='position: absolute; top: 15px; right: 15px;'>Password updated successfully!</div>";
        } else {
            // Password update failed
            $statusMsg = "<div class='alert alert-danger' style='position: absolute; top: 15px; right: 15px;'>An error occurred while updating the password.</div>";
        }
    } else {
        // Incorrect old password
        $statusMsg = "<div class='alert alert-danger' style='position: absolute; top: 15px; right: 15px;'>Incorrect old password. Password not updated.</div>";
    }
}

// Function to encrypt data using AES
function encryptData($data) {
    // Choose a secure key (do not hardcode in production)
    $key = 'your_secure_key';

    // Choose a secure initialization vector (IV)
    $iv = 'your_secure_iv';

    // Use AES-256-CBC encryption
    $cipherText = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);

    return $cipherText;
}

// Function to decrypt data using AES
function decryptData($cipherText) {
    // Choose a secure key (do not hardcode in production)
    $key = 'your_secure_key';

    // Choose a secure initialization vector (IV)
    $iv = 'your_secure_iv';

    // Use AES-256-CBC decryption
    $decryptedData = openssl_decrypt($cipherText, 'aes-256-cbc', $key, 0, $iv);

    return $decryptedData;
}

// Function to validate password format
function isValidPassword($password) {
    // Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, and one number
    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/";
    return preg_match($pattern, $password);
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
    <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include "Includes/sidebar.php";?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include "Includes/topbar.php";?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Change Password</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                        </ol>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Form Basic -->
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Change Password</h6>
                                    <?php echo $statusMsg; ?>
                                </div>
                                <div class="card-body">
                                    <form method="post" onsubmit="return confirmPasswordChange()">
                                        <div class="form-group row mb-3">
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Email<span class="text-danger ml-2">*</span></label>
                                                <input type="text" class="form-control" name="emailAddress" id="exampleEmailAddress" placeholder="Email Address">
                                            </div>
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Old Password<span class="text-danger ml-2">*</span></label>
                                                <input type="password" class="form-control" name="oldPass" id="exampleOldPass" placeholder="Old Password">
                                            </div>
                                            <div class="col-xl-6">
                                                <label class="form-control-label">New Password<span class="text-danger ml-2">*</span></label>
                                                <input type="password" class="form-control" name="newPass" id="exampleNewPass" placeholder="New Password">
                                                <small id="passwordHelp" class="form-text text-muted">
                                                    Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, and one number.
                                                </small>
                                            </div>
                                        </div>
                                        <button type="submit" name="save" class="btn btn-success">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!---Container Fluid-->
            </div>
            <!-- Footer -->
            <?php include "Includes/footer.php";?>
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
    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable(); // ID From dataTable 
            $('#dataTableHover').DataTable(); // ID From dataTable with Hover
        });

        // Client-side password validation
        function isValidPassword(password) {
            // Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, and one number
            var pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
            return pattern.test(password);
        }

        // Client-side confirmation for password change
        function confirmPasswordChange() {
            var newPassword = document.getElementById('exampleNewPass').value;

            // Validate password format
            if (!isValidPassword(newPassword)) {
                alert('Invalid password format! Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, and one number.');
                return false;
            }

            // Ask for confirmation
            var isConfirmed = confirm('Are you sure you want to change the password?');

            return isConfirmed;
        }
    </script>
</body>

</html>
