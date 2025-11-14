<?php
include "../includes/dbConn.php";

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