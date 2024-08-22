<?php

include '../Includes/dbcon.php';

    $cid = intval($_GET['cid']);//

        $queryss=mysqli_query($conn,"select * from tblsubjects where classId=".$cid." and isAssigned = '0'");                        
        $countt = mysqli_num_rows($queryss);

        if($countt === 0){
           echo   
                           "<div class='alert alert-danger' role='alert'>
                            No Record Found!
                            </div>";
        }else{
              
        echo '
        <select required name="subjectId" class="form-control mb-3">';
        echo'<option value="">--Select Subject--</option>';
        }

        while ($row = mysqli_fetch_array($queryss)) {
        echo'<option value="'.$row['Id'].'" >'.$row['subjectName'].'</option>';
        }
        echo '</select>';
?>

