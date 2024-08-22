<?php
include 'Includes/dbcon.php';
session_start();

// Function to decrypt data
function decryptData($cipherText) {
    // Replace 'your_secure_key' and 'your_secure_iv' with your actual encryption key and initialization vector
    $key = 'your_secure_key';
    $iv = 'your_secure_iv';

    // Check if the cipher text is empty
    if (empty($cipherText)) {
        return false;
    }

    // Check if the IV is shorter than 16 bytes and pad it with null bytes
    $iv = str_pad($iv, 16, "\0");

    // Use AES-256-CBC decryption
    $decryptedData = openssl_decrypt($cipherText, 'aes-256-cbc', $key, 0, $iv);

    // Check if decryption was successful
    if ($decryptedData === false) {
        return false;
    }

    return $decryptedData;
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
    <link href="img/logo/blogo.png" rel="icon">
    <title>Student Monitoring System - Login</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-login" style="background-image: url('img/logo/Background.jpg');">
    <!-- Login Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                
                                    <div class="text-center">
                                        <img src="img/logo/blogo.png" style="width:100px;height:100px">
                                        <br><br>
                                        <h5 class="h5 text-gray-900 mb-4" >Student Monitoring System</h5>
                                    
                                        <h1 class="h4 text-gray-900 mb-4">Login Panel</h1>
                                    </div>
                                    <form class="user" method="Post" action="">
                                        <div class="form-group">
                                            <select required name="userType" class="form-control mb-3">
                                                <option value="">--Select User Roles--</option>
                                                <option value="Administrator">Administrator</option>
                                                <option value="ClassTeacher">ClassTeacher</option>
                                                <option value="Student">Student/Parent</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" required name="username" id="exampleInputEmail" placeholder="Enter Email / Admission Number">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" required class="form-control" id="exampleInputPassword" placeholder="Enter Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-info btn-block" value="Login" name="login" />
                                        </div>
                                    </form>

                                    <?php
                                    if (isset($_POST['login'])) {
                                        $userType = $_POST['userType'];
                                        $username = $_POST['username'];
                                        $password = $_POST['password'];

                                        $selectQuery = "";

                                        if ($userType == "Administrator") {
                                            $selectQuery = "SELECT * FROM tbladmin WHERE emailAddress = '$username'";
                                        } else if ($userType == "ClassTeacher") {
                                            $selectQuery = "SELECT * FROM tblclassteacher WHERE emailAddress = '$username'";
                                        } else if ($userType == "Student") {
                                            $selectQuery = "SELECT * FROM tblstudents WHERE admissionNumber = '$username'";
                                        }

                                        $rs = $conn->query($selectQuery);
                                        $num = $rs->num_rows;
                                        $rows = $rs->fetch_assoc();

                                        if ($num > 0) {
                                            $decryptedPassword = decryptData($rows['password']);

                                            // Check if either decrypted or raw password matches
                                            if ($password == $decryptedPassword || $password == $rows['password']) {
                                                // Password is correct, proceed with login
                                                $_SESSION['userId'] = $rows['Id'];
                                                $_SESSION['firstName'] = $rows['firstName'];
                                                $_SESSION['lastName'] = $rows['lastName'];
                                                $_SESSION['emailAddress'] = $rows['emailAddress'];

                                                if ($userType == "Administrator") {
                                                    echo "<script type = \"text/javascript\">
                                                    window.location = (\"Admin/index.php\")
                                                    </script>";
                                                } else if ($userType == "ClassTeacher") {
                                                    $_SESSION['classId'] = $rows['classId'];
                                                    $_SESSION['classArmId'] = $rows['classArmId'];
                                                    echo "<script type = \"text/javascript\">
                                                    window.location = (\"ClassTeacher/index.php\")
                                                    </script>";
                                                } else if ($userType == "Student") {
                                                    $_SESSION['admissionNumber'] = $rows['admissionNumber'];
                                                    $_SESSION['classId'] = $rows['classId'];
                                                    $_SESSION['classArmId'] = $rows['classArmId'];
                                                    echo "<script type = \"text/javascript\">
                                                    window.location = (\"ClassStudent/index.php\")
                                                    </script>";
                                                }
                                            } else {
                                                // Incorrect password
                                                echo "<div class='alert alert-danger' role='alert'>
                                                Invalid Username/Password!
                                                </div>";
                                            }
                                        } else {
                                            // User not found
                                            echo "<div class='alert alert-danger' role='alert'>
                                            Invalid Username/Password!
                                            </div>";
                                        }
                                    }
                                    ?>

                                    <div class="text-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Content -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
</body>

</html>
