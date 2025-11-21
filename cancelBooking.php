<?php
session_start();
include "./includes/dbConn.php";

if(!isset($_SESSION['userID'])){
      header("Location: login.php");
      exit();
    }

$userID = mysqli_real_escape_string($conn, $_SESSION['userID']);

if(isset($_GET['bookingID'])){
    $bookingID = mysqli_real_escape_string($conn, $_GET['bookingID']);

    $fetchBookingQuery = "SELECT * FROM bookings WHERE bookingID = '$bookingID' AND userID ='$userID' AND status NOT IN ('completed', 'cancelled', 'confirmed')";
    $fetchBookingResult = mysqli_query($conn, $fetchBookingQuery);

  if (mysqli_num_rows($fetchBookingResult) === 1) {
    
    $cancelBookingQuery = "UPDATE bookings SET status = 'cancelled' WHERE bookingID = '$bookingID'";

    if(mysqli_query($conn,  $cancelBookingQuery)){

        echo '<script>
               alert("Booking cancelled successfully!");
               window.location.href = "./user.php#bookings";
             </script>';

        mysqli_close($conn); 
        exit();
    }
    else{
    echo '<script>
            alert("Could not cancel the booking!");
            window.location.href = "./user.php#bookings";
         </script>';

    mysqli_close($conn); 
    exit();
    }
  }
  else{
    echo '<script>
            alert("You are not allowed to cancel this booking!");
            window.location.href = "./user.php#bookings";
         </script>';

    mysqli_close($conn); 
    exit();
  }

    
    
}
else{
   echo '<script>
            alert("No booking ID was provided!");
            window.location.href = "./user.php#bookings";
         </script>';

    mysqli_close($conn); 
    exit(); 
}


?>