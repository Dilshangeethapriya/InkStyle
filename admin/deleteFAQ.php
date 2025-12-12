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




if(isset($_GET['faqID'])){
    $faqID = mysqli_real_escape_string($conn, $_GET['faqID']);

    $fetchFaqQuery = "SELECT * FROM faq WHERE faqID = '$faqID'";
    $fetchFaqResult = mysqli_query($conn, $fetchFaqQuery);

  if (mysqli_num_rows($fetchFaqResult) === 1) {
    $faq = mysqli_fetch_assoc($fetchFaqResult);

    $faqDeleteQuery = "DELETE FROM faq WHERE faqID = '$faqID'";

    if(mysqli_query($conn, $faqDeleteQuery)){

        echo '<script>
               alert("FAQ deleted Successfully!");
               window.location.href = "./adminPanel.php#admin-inquiries";
             </script>';

        mysqli_close($conn); 
        exit();
    }
    else{
    echo '<script>
            alert("Could not delete the FAQ!");
            window.history.back();
         </script>';

    mysqli_close($conn); 
    exit();
    }
  }
  else{
    echo '<script>
            alert("Cannot find the FAQ!");
            window.history.back();
         </script>';

    mysqli_close($conn); 
    exit();
  }

    
    
}
else{
   echo '<script>
            alert("No FAQ ID was provided!");
            window.history.back();
         </script>';

    mysqli_close($conn); 
    exit(); 
}


?>