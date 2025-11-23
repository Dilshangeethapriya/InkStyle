<?php
session_start();
include "./includes/dbConn.php";


   if(!isset($_SESSION['userID'])){
      header("Location: login.php");
      exit();
    }

  if(isset($_GET['itemID'])){
      $itemID = mysqli_real_escape_string($conn, $_GET['itemID']);
      $updateQuery = "DELETE FROM cart_item  WHERE id = '$itemID'";

      if(mysqli_query($conn, $updateQuery)){
        header("Location: user.php#cart");
        exit();
      }
  }
   
?>