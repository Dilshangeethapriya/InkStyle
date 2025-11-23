<?php
session_start();
include "./includes/dbConn.php";

if(!isset($_SESSION['userID'])){
      header("Location: login.php");
      exit();
    }

$userID = mysqli_real_escape_string($conn, $_SESSION['userID']);

if(isset($_GET['orderID'])){
    $orderID = mysqli_real_escape_string($conn, $_GET['orderID']);

    $fetchOrderQuery = "SELECT * FROM orders WHERE order_id = '$orderID' AND user_id ='$userID' AND status IN ('pending', 'failedDelivery')";
    $fetchOrderResult = mysqli_query($conn, $fetchOrderQuery);

  if (mysqli_num_rows($fetchOrderResult) === 1) {
    
    $cancelOrderQuery = "UPDATE orders SET status = 'cancelled' WHERE order_id = '$orderID'";

    if(mysqli_query($conn,  $cancelOrderQuery)){

        echo '<script>
               alert("Order cancelled successfully!");
               window.location.href = "./user.php#orders";
             </script>';

        mysqli_close($conn); 
        exit();
    }
    else{
    echo '<script>
            alert("Could not cancel Order!");
            window.location.href = "./user.php#orders";
         </script>';

    mysqli_close($conn); 
    exit();
    }
  }
  else{
    echo '<script>
            alert("You are not allowed to cancel this Order!");
            window.location.href = "./user.php#orders";
         </script>';

    mysqli_close($conn); 
    exit();
  }

    
    
}
else{
   echo '<script>
            alert("No order ID was provided!");
            window.location.href = "./user.php#orders";
         </script>';

    mysqli_close($conn); 
    exit(); 
}


?>