<?php
      session_start();
      include "../includes/dbConn.php";
      $staffID = null;
      $role = null;
      if(isset($_SESSION['staffID']) && isset($_SESSION['roleOfUser'])){
        $staffID = mysqli_real_escape_string($conn, $_SESSION['staffID']);
        $role = mysqli_real_escape_string($conn, $_SESSION['roleOfUser']);
       
        // ---- for admin only pages  ----
        // if($role !== 'Admin'){
        //     echo '<script>
        //            alert("You dont have access to this page!");
        //            window.location.href = "./adminPanel.php";
        //          </script>';
        //    exit();
        // }
      }
      else{
       header("Location: staffLogin.php");
       exit();
      }
    header('Content-Type: application/json');


   
    $orderQuery = "
        SELECT DATE_FORMAT(created_at, '%b') AS month, COUNT(*) AS total
        FROM orders
        WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 5 MONTH)
        GROUP BY DATE_FORMAT(created_at, '%Y-%m')
        ORDER BY DATE_FORMAT(created_at, '%Y-%m') ASC";
    
    $orderResult = mysqli_query($conn, $orderQuery);
    
    $orders = [];
    while ($row = mysqli_fetch_assoc($orderResult)) {
        $orders[] = $row;
    }

    $bookQuery = "
        SELECT DATE_FORMAT(booking_date, '%b') AS month, COUNT(*) AS total
        FROM bookings
        WHERE booking_date >= DATE_SUB(CURDATE(), INTERVAL 5 MONTH)
        GROUP BY DATE_FORMAT(booking_date, '%Y-%m')
        ORDER BY DATE_FORMAT(booking_date, '%Y-%m') ASC";
    
    $bookResult = mysqli_query($conn, $bookQuery);
    
    $bookings = [];
    while ($row = mysqli_fetch_assoc($bookResult)) {
        $bookings[] = $row;
    }
    

    echo json_encode([
        "orders"   => $orders,
        "bookings" => $bookings
    ]);


?>