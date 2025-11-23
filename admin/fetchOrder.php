<?php
include "../includes/dbConn.php";


$searchByName = isset($_POST['searchNameValue']) ? mysqli_real_escape_string($conn, trim($_POST['searchNameValue'])) : '';
$filterByDate = isset($_POST['filterOrderByDateValue']) ? mysqli_real_escape_string($conn, $_POST['filterOrderByDateValue']) : '';
$filterByStatus = isset($_POST['filterOrderByStatusValue']) ? mysqli_real_escape_string($conn, $_POST['filterOrderByStatusValue']) : '';
$sortByDate = isset($_POST['sortOrderByDateValue']) ? mysqli_real_escape_string($conn, $_POST['sortOrderByDateValue']) : '';


$mainQuery = "SELECT o.order_id, o.created_at, o.amount, o.status, c.fullName FROM orders o JOIN customer c ON c.id = o.user_id WHERE 1=1";

$searchByNameQuery = "";
$filterByDateQuery = "";
$filterByStatusQuery = "";
$sortbyDateQuery = "";


if(!empty($searchByName)){
    $searchByNameQuery = " AND c.fullName LIKE '%$searchByName%'";
}

if(!empty($filterByDate)){
    $today = date("Y-m-d");
    if($filterByDate === "today"){
        $filterByDateQuery = " AND DATE(o.created_at) = '$today'";
    }
    elseif($filterByDate === "this_week"){
        $startOfWeek = date("Y-m-d", strtotime("monday this week"));
        $endOfWeek = date("Y-m-d", strtotime("sunday this week"));
        $filterByDateQuery = " AND DATE(o.created_at) BETWEEN '$startOfWeek' AND '$endOfWeek'";
    }
    elseif($filterByDate === "this_month"){
        $startOfMonth = date("Y-m-01");
        $endOfMonth = date("Y-m-t");
        $filterByDateQuery = " AND DATE(o.created_at) BETWEEN '$startOfMonth' AND '$endOfMonth'";
    }
    elseif($filterByDate === "this_year"){
        $startOfYear = date("Y-01-01");
        $endOfYear = date("Y-12-31");
        $filterByDateQuery = " AND DATE(o.created_at) BETWEEN '$startOfYear' AND '$endOfYear'";
    }
    else{
        $filterByDateQuery = "";
    }
}


if(!empty($filterByStatus)){
    $filterByStatusQuery = " AND o.status = '$filterByStatus'";
}

if(!empty($sortByDate)){
     if($sortByDate === "date_asc"){
        $sortbyDateQuery = " ORDER BY o.created_at ASC";
     }
     elseif($sortByDate === "date_desc"){
        $sortbyDateQuery = " ORDER BY o.created_at DESC";
     }
    
}



$finalFetchOrderDataQuery = $mainQuery.$searchByNameQuery.$filterByDateQuery.$filterByStatusQuery.$sortbyDateQuery;

$fetchOrderDataResult = mysqli_query($conn, $finalFetchOrderDataQuery);

if(mysqli_num_rows($fetchOrderDataResult) > 0){
    while($orderData = mysqli_fetch_assoc($fetchOrderDataResult)){
         echo '
              <a href="viewOrder.php?OrderID='.intval($orderData['order_id']).'">
                    <div class="orders-list-item">
                        <p>'.intval($orderData['order_id']).'</p>
                        <p>'.htmlspecialchars(date("Y/m/d",strtotime($orderData['created_at']))).'</p>
                        <p>'.htmlspecialchars($orderData['fullName']).'</p>
                        <p>LKR '.htmlspecialchars(number_format(floatval($orderData['amount']), 2)).'</p>
                        <p class="order-'.htmlspecialchars($orderData['status']).'">'.htmlspecialchars(ucfirst($orderData['status'])).'</p>
                    </div>
                </a> 
         ';
    }
}
else{
   echo '
   <div class="booking-list-item">
    <p>No results found.</p>
  </div>
   ';
}

mysqli_close($conn);
?>