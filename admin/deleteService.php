<?php
session_start();
include "../includes/dbConn.php";

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
               window.history.back();
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
            alert("NO service ID was provided!");
            window.history.back();
         </script>';

    mysqli_close($conn); 
    exit(); 
}


?>