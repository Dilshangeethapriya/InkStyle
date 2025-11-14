<?php
include "../includes/dbConn.php";

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
                           <a href="updateUser.php?staffID='.htmlspecialchars($staffData['staffID']).'"><button class="staff-update btn-update" id="staff-update"><i class="fa-solid fa-pen-to-square"></i> Update</button></a>
                           <button class="staff-delete btn-delete" id="staff-delete"><i class="fa-solid fa-trash"></i> Delete</button>
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