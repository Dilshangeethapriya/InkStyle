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




if(isset($_GET['productID'])){
    $productID = mysqli_real_escape_string($conn, $_GET['productID']);

    $fetchImageQuery = "SELECT image FROM products WHERE productID = '$productID'";
    $fetchImageResult = mysqli_query($conn, $fetchImageQuery);

  if (mysqli_num_rows($fetchImageResult) === 1) {
    $product = mysqli_fetch_assoc($fetchImageResult);
    $imagePath = $product['image'];

    $productDeleteQuery = "DELETE FROM products WHERE productID = '$productID'";

    if(mysqli_query($conn, $productDeleteQuery)){

        $filePath = "." . $imagePath; 
        if (file_exists($filePath) && strpos($imagePath, 'Store/') !== false) {
            unlink($filePath);
        }

        echo '<script>
               alert("Product deleted Successfully!");
               window.location.href = "./adminPanel.php#admin-products";
             </script>';

        mysqli_close($conn); 
        exit();
    }
    else{
    echo '<script>
            alert("Could not delete the product!");
            window.history.back();
         </script>';

    mysqli_close($conn); 
    exit();
    }
  }
  else{
    echo '<script>
            alert("Cannot find the product!");
            window.history.back();
         </script>';

    mysqli_close($conn); 
    exit();
  }

    
    
}
else{
   echo '<script>
            alert("No product ID was provided!");
            window.history.back();
         </script>';

    mysqli_close($conn); 
    exit(); 
}


?>