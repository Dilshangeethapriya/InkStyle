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




$searchValue = isset($_POST['searchValue'])? trim($_POST['searchValue']) : '';

$fetchCustomerDataQuery = "SELECT * FROM customer";

if(!empty($searchValue))
{
    $sanatizedInput = mysqli_real_escape_string($conn, $searchValue);
    $fetchCustomerDataQuery .= " WHERE fullName LIKE '%$sanatizedInput%'";
}

$fetchCustomerDataResult = mysqli_query($conn, $fetchCustomerDataQuery);

if(mysqli_num_rows($fetchCustomerDataResult) > 0){
    while($customerData = mysqli_fetch_assoc($fetchCustomerDataResult)){
         echo '
         <div class="user-list-item customer-list">
          <p>'.htmlspecialchars($customerData['fullName']).'</p>
          <p>'.htmlspecialchars($customerData['phone']).'</p>
          <p>'.htmlspecialchars($customerData['email']).'</p>
          <p>'.htmlspecialchars($customerData['address']).'</p>
        </div>
         ';
    }
}
else{
   echo '
   <div class="user-list-item customer-list">
    <p>No results found.</p>
  </div>
   ';
}

mysqli_close($conn);
?>