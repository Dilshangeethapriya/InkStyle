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





$searchByName = isset($_POST['searchNameValue']) ? mysqli_real_escape_string($conn, trim($_POST['searchNameValue'])) : '';
$filterByDate = isset($_POST['filterByDateValue']) ? mysqli_real_escape_string($conn, $_POST['filterByDateValue']) : '';
$filterByStatus = isset($_POST['filterByStatusValue']) ? mysqli_real_escape_string($conn, $_POST['filterByStatusValue']) : '';
$sortByDate = isset($_POST['sortByDateValue']) ? mysqli_real_escape_string($conn, $_POST['sortByDateValue']) : '';


$mainQuery = "SELECT b.*, c.fullName FROM bookings b JOIN customer c ON b.userID = c.id WHERE 1 = 1";

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
        $filterByDateQuery = " AND DATE(b.booking_date) = '$today'";
    }
    elseif($filterByDate === "this_week"){
        $endOfWeek = date("Y-m-d", strtotime("next sunday"));
        $filterByDateQuery = " AND DATE(b.booking_date) BETWEEN '$today' AND '$endOfWeek'";
    }
    elseif($filterByDate === "this_month"){
        $endOfMonth = date("Y-m-t");
        $filterByDateQuery = " AND DATE(b.booking_date) BETWEEN '$today' AND '$endOfMonth'";
    }
    elseif($filterByDate === "this_year"){
        $endOfYear = date("Y-12-31");
        $filterByDateQuery = " AND DATE(b.booking_date) BETWEEN '$today' AND '$endOfYear'";
    }
    else{
        $filterByDateQuery = "";
    }
}


if(!empty($filterByStatus)){
    $filterByStatusQuery = " AND b.status = '$filterByStatus'";
}

if(!empty($sortByDate)){
     if($sortByDate === "date_asc"){
        $sortbyDateQuery = " ORDER BY b.booking_date ASC";
     }
     elseif($sortByDate === "date_desc"){
        $sortbyDateQuery = " ORDER BY b.booking_date DESC";
     }
    
}



$finalFetchBookingDataQuery = $mainQuery.$searchByNameQuery.$filterByDateQuery.$filterByStatusQuery.$sortbyDateQuery;

$fetchBookingDataResult = mysqli_query($conn, $finalFetchBookingDataQuery);

if(mysqli_num_rows($fetchBookingDataResult) > 0){
    while($bookingData = mysqli_fetch_assoc($fetchBookingDataResult)){
        $bookingID = $bookingData['bookingID'];
        $serviceList = [];

        $bookedServicesQuery = "SELECT serviceID FROM booking_services WHERE bookingID = '$bookingID'";
        $bookedServicesResult =  mysqli_query($conn, $bookedServicesQuery);

         if(mysqli_num_rows($bookedServicesResult) > 0){
         while($bookedService = mysqli_fetch_assoc($bookedServicesResult)){

              $serviceID = $bookedService['serviceID'];
              $serviceDataQuery = "SELECT serviceName FROM services WHERE serviceID = '$serviceID'";
              $serviceDataResult =  mysqli_query($conn,$serviceDataQuery);

              if(mysqli_num_rows($serviceDataResult) > 0){
              while($serviceData = mysqli_fetch_assoc($serviceDataResult)){
                   $serviceList[] = $serviceData['serviceName']; 
              }
             }

            }
        }

         echo '
            <a href="viewBooking.php?bookingID='.htmlspecialchars($bookingData['bookingID']).'">
                    <div class="booking-list-item">
                        <p>'.htmlspecialchars($bookingData['bookingID']).'</p>
                        <p>'.htmlspecialchars($bookingData['fullName']).'</p>
                        <p>'.htmlspecialchars(implode(" , ", $serviceList)).'</p>
                        <p>'.htmlspecialchars(date("Y/m/d",strtotime($bookingData['booking_date']))).'</p>
                        <p>'.htmlspecialchars(date("g:i A",strtotime($bookingData['booking_start_time'])))."-".htmlspecialchars(date("g:i A",strtotime($bookingData['booking_end_time']))).'</p>
                        <p>'.htmlspecialchars(date("Y/m/d \a\\t g:i A",strtotime($bookingData['created_at']))).'</p>
                        <p class="booking-'.htmlspecialchars($bookingData['status']).'">'.htmlspecialchars(ucfirst($bookingData['status'])).'</p>
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