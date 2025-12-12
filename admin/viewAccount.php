    <?php
      session_start();
      include "../includes/dbConn.php";
     
      $staffID = null;
      $role = null;
      if(isset($_SESSION['staffID']) && isset($_SESSION['roleOfUser'])){
        $staffID = mysqli_real_escape_string($conn, $_SESSION['staffID']);
        $role = mysqli_real_escape_string($conn, $_SESSION['roleOfUser']);

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


      
      $title = "Staff Profile | InkStyle by Dinu";
      $pageTitle = "Staff Profile";
      include "../includes/admin/adminHeader.php";

      
      
      $fetchStaffDataQuery = "SELECT * FROM staff WHERE staffID = '$staffID'";
      $fetchStaffDataResult = mysqli_query($conn, $fetchStaffDataQuery);
      if(mysqli_num_rows($fetchStaffDataResult) === 1){
        $staffData = mysqli_fetch_assoc($fetchStaffDataResult);
         }
        else{
        echo '<div class="status-message" style="position: absolute; width: 100%; top: 100px; color:red" ><p>Profile data is not found!</p></div>';
            exit();
        }
        
   



      
     
     
    
    mysqli_close($conn); 
    ?>

        <main class="main-container">
            <div class="view-card">
                <a href="./adminPanel.php" class="close-btn"><i class="fa-solid fa-xmark-circle"></i></a>
                <h2>Staff Profile Details</h2>
                <div class="view-group">
                    <p class="view-bold-text">Full Name: </p>
                    <p><?php echo htmlspecialchars($staffData['fullName']); ?></p>
                </div>
                <div class="view-group">
                    <p class="view-bold-text">Phone: </p>
                    <p><?php echo htmlspecialchars($staffData['phone']); ?></p>
                </div>
                <div class="view-group">
                    <p class="view-bold-text">Email: </p>
                    <p><?php echo htmlspecialchars($staffData['email']); ?></p>
                </div>
                <div class="view-group">
                    <p class="view-bold-text">Address: </p>
                    <p><?php echo htmlspecialchars($staffData['address']); ?></p>
                </div>
                <div class="view-group">
                    <p class="view-bold-text">Role: </p>
                    <p><?php echo htmlspecialchars($staffData['role']); ?></p>
                </div>

                <a href="../logout.php" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>

           </div>
        </main>
    </div>
    <script src="../resources/js/admin/sidebar.js"></script>
</body>
</html>