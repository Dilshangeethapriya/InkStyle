<?php
session_start();
include "../includes/dbConn.php";
 $staffID = null;
 $role = null;
 if(isset($_SESSION['staffID']) && isset($_SESSION['roleOfUser'])){
   $staffID = mysqli_real_escape_string($conn, $_SESSION['staffID']);
   $role = mysqli_real_escape_string($conn, $_SESSION['roleOfUser']);
   //
   // ---- for admin only pages  ----
   if($role !== 'Admin'){
       echo '<script>
              alert("You dont have access to this page!");
              window.location.href = "./adminPanel.php";
            </script>';
      exit();
   }
 }
 else{
  header("Location: staffLogin.php");
  exit();
 }




if(isset($_GET['serviceID'])){
    $serviceID = mysqli_real_escape_string($conn, $_GET['serviceID']);

    $fetchServiceQuery = "SELECT * FROM services WHERE serviceID = '$serviceID'";
    $fetchServiceResult = mysqli_query($conn, $fetchServiceQuery);

  if (mysqli_num_rows($fetchServiceResult) === 1) {
    $service = mysqli_fetch_assoc($fetchServiceResult);

    $serviceDeleteQuery = "DELETE FROM services WHERE serviceID = '$serviceID'";

    if(mysqli_query($conn, $serviceDeleteQuery)){

        echo '<script>
               alert("Service deleted Successfully!");
               window.location.href = "./adminPanel.php#admin-services";
             </script>';

        mysqli_close($conn); 
        exit();
    }
    else{
    echo '<script>
            alert("Could not delete the service!");
            window.history.back();
         </script>';

    mysqli_close($conn); 
    exit();
    }
  }
  else{
    echo '<script>
            alert("Cannot find the service!");
            window.history.back();
         </script>';

    mysqli_close($conn); 
    exit();
  }

    
    
}
else{
   echo '<script>
            alert("No service ID was provided!");
            window.history.back();
         </script>';

    mysqli_close($conn); 
    exit(); 
}


?>