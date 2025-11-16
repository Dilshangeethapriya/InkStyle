    <?php
      session_start();
      $title = "Update Staff Member | InkStyle by Dinu";
      $pageTitle = "Update Staff Member";

      include "../includes/admin/adminHeader.php";
      include "../includes/dbConn.php";

      $staffID = null;
      $staffData = null;
      if(isset($_GET['staffID'])){
          $staffID = mysqli_real_escape_string($conn, base64_decode($_GET['staffID']));

          $fetchStaffDataQuery = "SELECT * FROM staff WHERE staffID = '$staffID'";
          $fetchStaffDataResult = mysqli_query($conn, $fetchStaffDataQuery);

          if(mysqli_num_rows($fetchStaffDataResult) === 1){
            $staffData = mysqli_fetch_assoc($fetchStaffDataResult);
         }
        else{
        echo '<div class="status-message" style="position: absolute; width: 100%; top: 100px; color:red" ><p>Member data is not found!</p></div>';
            exit();
        }
        }
      else{
          echo '<div class="status-message" style="position: absolute; width: 100%; top: 100px; color:red"><p>Staff ID is not found!</p></div>';
          exit();
      }



      if(isset($_POST['update_staff_btn'])){

        $newPassword = mysqli_real_escape_string($conn, $_POST['new_password']);
        $confirm = mysqli_real_escape_string($conn, $_POST['confirm']);

         if($newPassword !== $confirm){
           echo '<script>
                   alert("Password and Confirm Password does not match!");
                   window.location.href = "./updateStaff.php?staffID='.base64_encode($staffData['staffID']).'";
                 </script>';
       
           exit();
           }
        
        $oldPassword = mysqli_real_escape_string($conn, $_POST['old_password']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $role = mysqli_real_escape_string($conn, $_POST['role']);

        // old password validation
        $staffID = mysqli_real_escape_string($conn, base64_decode($_GET['staffID']));

        $passwordCheckSql = "SELECT * FROM staff WHERE staffID = '$staffID' AND password ='$oldPassword'";
        $passwordCheckResults = mysqli_query($conn, $passwordCheckSql);
        if(mysqli_num_rows($passwordCheckResults) === 1){
            $staffData = mysqli_fetch_assoc($passwordCheckResults);
        }
        else{
            echo '<script>
            alert("Old password is incorrect!");
            window.location.href = "./updateStaff.php?staffID='.base64_encode($staffData['staffID']).'";
            </script>';

             exit(); 
        }
             
        
        

        // duplicate  staff Name or email check
        if($staffData['fullName'] !== $name){
        $nameCheckSql = "SELECT * FROM staff WHERE fullName = '$name'";
        $nameCheckResults = mysqli_query($conn, $nameCheckSql);
        
        if(mysqli_num_rows($nameCheckResults) > 0){
           echo '<script>
            alert("Entered Name already exists!. Enter a different name.");
            window.location.href = "./updateStaff.php?staffID='.base64_encode($staffData['staffID']).'";
            </script>';

          exit(); 
        }
        }

        if($staffData['email'] !== $email){
              $emailCheckSql = "SELECT * FROM staff WHERE email = '$email'";
              $emailCheckResults = mysqli_query($conn, $emailCheckSql);
        
        if(mysqli_num_rows($emailCheckResults) > 0){
           echo '<script>
            alert("Entered Email already exists!. Enter a different email.");
            window.location.href = "./updateStaff.php?staffID='.base64_encode($staffData['staffID']).'";
            </script>';

          exit(); 
        }
        }


        if(!empty($newPassword)){

            $updateStaffSql = "UPDATE staff SET fullName = '$name', phone = '$phone', email = '$email', address = '$address', role = '$role', password = '$newPassword' WHERE staffID = '$staffID'";

            if(mysqli_query($conn, $updateStaffSql)){
               echo '<script>
                   alert("Member updated successfully!");
                   window.location.href = "./adminPanel.php#admin-users";
               </script>';
            }
            else{
            echo '<script>
                   alert("Could not update the member!");
                   window.location.href = "./updateStaff.php?staffID='.base64_encode($staffData['staffID']).'";
                </script>';
            }

        }
        else{
            
            $updateStaffSql = "UPDATE staff SET fullName = '$name', phone = '$phone', email = '$email', address = '$address', role = '$role' WHERE staffID = '$staffID'";

            if(mysqli_query($conn, $updateStaffSql)){
               echo '<script>
                   alert("Member updated successfully!");
                   window.location.href = "./adminPanel.php#admin-users";
               </script>';
            }
            else{
            echo '<script>
                   alert("Could not update the member!");
                   window.location.href = "./updateStaff.php?staffID='.base64_encode($staffData['staffID']).'";
                </script>';
            }
        }
  
     
     
    }
    mysqli_close($conn); 
    ?>

        <main class="main-container">
            <div class="form-card">
                <form action="updateStaff.php?staffID=<?php echo base64_encode($staffData['staffID']); ?>" method="POST" class="product-form" id="staff_register_form">
                    
                    <div class="form-group">
                        <label for="name" >Full Name</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($staffData['fullName']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($staffData['phone']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($staffData['email']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($staffData['address']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role" id="role">
                            <option value="Staff" <?php if($staffData['role'] === 'Staff'){ echo 'selected';} ?>>Staff</option>
                            <option value="Admin" <?php if($staffData['role'] === 'Admin'){ echo 'selected';} ?>>Admin</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="old_password">Old Password</label>
                        <input type="password" id="old_password" name="old_password" required>
                    </div>

                    <div class="form-group">
                        <label for="new_password">Password</label>
                        <input type="password" id="new_password" name="new_password">
                    </div>

                    <div class="form-group">
                        <label for="confirm">Confirm Password</label>
                        <input type="password" id="confirm" name="confirm" >
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="submit-btn" id="update_staff_btn" name="update_staff_btn"><i class="fa-solid fa-plus-circle"></i>Update Member</button>
                        <a href="adminPanel.php#admin-users" class="cancel-btn"><i class="fa-solid fa-xmark-circle"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </main>
    </div>


    <script>
        window.addEventListener("DOMContentLoaded", function(){
            const staffRegisterForm = document.getElementById("staff_register_form");

            staffRegisterForm.addEventListener("submit", function(event){

                const password = document.getElementById("new_password").value;
                const confirm = document.getElementById("confirm").value;

                if(password !== confirm){
                    event.preventDefault();
                    alert('Password and Confirm Password does not match!'); 
                }
            });
        });
    </script>

    <script src="../resources/js/admin/sidebar.js"></script>
</body>
</html>