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

$searchInquiryValue = isset($_POST['searchInquiryValue'])? trim($_POST['searchInquiryValue']) : '';
$filterInquiryValue = isset($_POST['filterInquiryStatusValue'])? trim($_POST['filterInquiryStatusValue']) : '';
$sortInquiryValue = isset($_POST['sortInquiryValue'])? trim($_POST['sortInquiryValue']) : '';


$searchQuery = "";
$filterQuery = "";
$sortQuery = "";
$sanitizedSearchInquiryValue ="";
$sanitizedFilterInquiryValue = "";
$sanitizedSortInquiryValue = "";

if(!empty($searchInquiryValue)){
    $sanitizedSearchInquiryValue = mysqli_real_escape_string($conn, $searchInquiryValue);
    $searchQuery = " WHERE name LIKE '%$sanitizedSearchInquiryValue%'";
}

if(!empty($filterInquiryValue)){
    $sanitizedFilterInquiryValue = mysqli_real_escape_string($conn, $filterInquiryValue);
    if(empty($searchInquiryValue)){
        $filterQuery =  " WHERE status = '$sanitizedFilterInquiryValue'";
    }
    else{
        $filterQuery = " AND status = '$sanitizedFilterInquiryValue'";
    }
}

if(!empty($sortInquiryValue)){
     $sanitizedSortInquiryValue = mysqli_real_escape_string($conn, $sortInquiryValue);
     if($sanitizedSortInquiryValue === "date_asc"){
        $sortQuery = " ORDER BY created_at ASC";
     }
      elseif($sanitizedSortInquiryValue === "date_desc"){
        $sortQuery = " ORDER BY created_at DESC";
     }
     else{
         $sortQuery = " ORDER BY created_at DESC";
     }
}
else{
         $sortQuery = " ORDER BY created_at DESC";
 }



$fetchInquiryDataQuery = "SELECT * FROM inquiry".$searchQuery.$filterQuery.$sortQuery;

$fetchInquiryDataResult = mysqli_query($conn, $fetchInquiryDataQuery);

if(mysqli_num_rows($fetchInquiryDataResult) > 0){
    while($inquiryData = mysqli_fetch_assoc($fetchInquiryDataResult)){
         $createdAtFormated = date("M j,  g:i A", strtotime($inquiryData['created_at']));
         echo '
         <a href="viewInquiry.php?inquiryID='.htmlspecialchars($inquiryData['inquiryID']).'">
            <div class="inquiry-list-item customer-question-list">
                <p>'.htmlspecialchars($inquiryData['inquiryID']).'</p>
                <p>'.htmlspecialchars($inquiryData['name']).'</p>
                <p>'.htmlspecialchars($inquiryData['phone']).'</p>
                <p>'.htmlspecialchars($createdAtFormated).'</p>
                <p>'.htmlspecialchars($inquiryData['message']).'</p>
                <p class="inquiry-'.htmlspecialchars($inquiryData['status']).'">'.htmlspecialchars($inquiryData['status']).'</p>
            </div>
          </a>
         ';
    }
}
else{
   echo '
   <div class="user-list-item staff-list">
    <p>No results found.</p>
  </div>
   ';
}

mysqli_close($conn);
?>