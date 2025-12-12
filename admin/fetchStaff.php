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

$searchStaffValue = isset($_POST['searchStaffValue'])? trim($_POST['searchStaffValue']) : '';
$filterStaffValue = isset($_POST['filterStaffValue'])? trim($_POST['filterStaffValue']) : '';

$fetchStaffDataQuery = "SELECT * FROM staff";

$sanatizedSearchStaffValue = "";
$sanatizedFilterStaffValue = "";
if(!empty($searchStaffValue) && !empty($filterStaffValue))
{
    $sanatizedSearchStaffValue = mysqli_real_escape_string($conn, $searchStaffValue);
    $sanatizedFilterStaffValue = mysqli_real_escape_string($conn, $filterStaffValue);
    $fetchStaffDataQuery .= " WHERE fullName LIKE '%$sanatizedSearchStaffValue%' AND role = '$sanatizedFilterStaffValue'";
}
elseif(!empty($searchStaffValue) && empty($filterStaffValue)){
    $sanatizedSearchStaffValue = mysqli_real_escape_string($conn, $searchStaffValue);
    $fetchStaffDataQuery .= " WHERE fullName LIKE '%$sanatizedSearchStaffValue%'";
}elseif(empty($searchStaffValue) && !empty($filterStaffValue))
{
    $sanatizedFilterStaffValue = mysqli_real_escape_string($conn, $filterStaffValue);
    $fetchStaffDataQuery .= " WHERE role = '$sanatizedFilterStaffValue'";
}

$fetchStaffDataResult = mysqli_query($conn, $fetchStaffDataQuery);

if(mysqli_num_rows($fetchStaffDataResult) > 0){
    while($staffData = mysqli_fetch_assoc($fetchStaffDataResult)){
         echo '
         <div class="user-list-item staff-list">
          <p>'.htmlspecialchars($staffData['fullName']).'</p>
          <p>'.htmlspecialchars($staffData['phone']).'</p>
          <p>'.htmlspecialchars($staffData['email']).'</p>
          <p>'.htmlspecialchars($staffData['address']).'</p>
          <p>'.htmlspecialchars($staffData['role']).'</p>
          <div class="action-btns">
                           <a href="updateStaff.php?staffID='.base64_encode($staffData['staffID']).'"><button class="staff-update btn-update" ><i class="fa-solid fa-pen-to-square"></i> Update</button></a>
                           <button class="staff-delete btn-delete"  onclick="deleteStaff(\''.base64_encode($staffData['staffID']).'\')" '.(($role !== 'Admin')? "disabled": "").'><i class="fa-solid fa-trash" ></i> Delete</button>
         </div>  
        </div>
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