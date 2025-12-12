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

     
     


    $topProductsChartQuery = "SELECT oi.product_id,p.productName,SUM(oi.quantity) AS total_qty FROM order_items oi JOIN products p ON oi.product_id = p.productID GROUP BY product_id ORDER BY total_qty DESC LIMIT 5";


     $topProductsChartQueryResult = mysqli_query($conn, $topProductsChartQuery);

     $topSellingProducts = [];
     while($row = mysqli_fetch_assoc($topProductsChartQueryResult)){
       $topSellingProducts[] = $row;
     }

     echo json_encode( $topSellingProducts);           
 ?>