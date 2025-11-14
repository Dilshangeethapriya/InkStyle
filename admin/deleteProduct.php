<?php
session_start();
include "../includes/dbConn.php";

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
            alert("NO product ID was provided!");
            window.history.back();
         </script>';

    mysqli_close($conn); 
    exit(); 
}


?>