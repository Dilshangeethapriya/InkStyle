<?php
session_start();
include "./includes/dbConn.php";


   if(!isset($_SESSION['userID'])){
      header("Location: login.php");
      exit();
    }

  $itemID = $_POST['itemID'];
  $qty = $_POST['qty'];


$updateQuery = "UPDATE cart_item SET quantity = '$qty' WHERE id = '$itemID'";
mysqli_query($conn, $updateQuery);
echo "ok";
?>