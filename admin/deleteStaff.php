<?php
session_start();
include "../includes/dbConn.php";

if(isset($_GET['staffID'])){
    $staffID = mysqli_real_escape_string($conn, base64_decode($_GET['staffID']));

    $fetchStaffQuery = "SELECT * FROM staff WHERE staffID = '$staffID'";
    $fetchStaffResult = mysqli_query($conn, $fetchStaffQuery);

  if (mysqli_num_rows($fetchStaffResult) === 1) {

    $deleteStaffQuery = "DELETE FROM staff WHERE staffID = '$staffID'";

    if(mysqli_query($conn, $deleteStaffQuery)){

        echo '<script>
               alert("Staff member details removed Successfully!");
               window.location.href = "./adminPanel.php#admin-users";
             </script>';

        mysqli_close($conn); 
        exit();
    }
    else{
    echo '<script>
            alert("Could not delete the staff member details!");
            window.location.href = "./adminPanel.php#admin-users";
         </script>';

    mysqli_close($conn); 
    exit();
    }
  }
  else{
    echo '<script>
            alert("Cannot find the staff member details!");
            window.location.href = "./adminPanel.php#admin-users";
         </script>';

    mysqli_close($conn); 
    exit();
  }

    
    
}
else{
   echo '<script>
            alert("No staff ID was provided!");
            window.location.href = "./adminPanel.php#admin-users";
         </script>';

    mysqli_close($conn); 
    exit(); 
}


?>