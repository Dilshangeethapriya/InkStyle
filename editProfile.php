   <?php
    session_start();

     $title = "Edit Profile | InkStyle by Dinu";
     $cssFile = "editProfile.css";
   
     include "./includes/header.php";
     include "./includes/dbConn.php";

    if (!isset($_SESSION['userID'])) {
      header("Location: login.php");
      exit();
    }

    $userID = $_SESSION['userID'];

    $userDataSql = "SELECT * FROM customer WHERE id = '$userID'";
    $userDataResults = mysqli_query($conn, $userDataSql);
    
    // fetching user profile data
    if(mysqli_num_rows($userDataResults) === 1){
      $userData = mysqli_fetch_assoc($userDataResults); 
    }
    else{
      echo '<script>
      alert("User data not found. Please log in again!"); 
      window.location.href="./logout.php";
      </script>';

      exit();
    }

    if(isset($_POST['save_btn'])){
       $name = mysqli_real_escape_string($conn, $_POST['name']);
       $phone = mysqli_real_escape_string($conn, $_POST['phone']);
       $email = mysqli_real_escape_string($conn, $_POST['email']);
       $address = mysqli_real_escape_string($conn, $_POST['address']);
       $oldPassword = mysqli_real_escape_string($conn, $_POST['oldPassword']);
       $newPassword =  $_POST['password'];
       $newPasswordConfirm =  $_POST['confirm'];

      // checking the old password
      if($oldPassword !== $userData['password']){
       echo '<script>
      alert("Old Password is incorrect!"); 
      window.history.back();
      </script>';
      
      exit();
      }
      
      // checking exixting email
      if($email !== $userData['email']){

        $checkExistingEmailQuery = "SELECT email from customer WHERE email='$email'";
        $checkExistingEmailResult = mysqli_query($conn, $checkExistingEmailQuery);

        if(mysqli_num_rows($checkExistingEmailResult) > 0){
          echo '<script>
                  alert("Email you entered is already registered! Enter a different email");
                  window.history.back();
                  </script>';
      
          exit();
        }
      }

    // validating the new password
    $passwordFieldQuery = "";
    if(!empty($newPassword)){
         if($newPassword !== $newPasswordConfirm){
            echo '<script>
            alert("New Password and Confirm Password does not match!");
            window.history.back();
            </script>';

            exit();
         }

         $newConfirmedPassword = mysqli_real_escape_string($conn, $_POST['password']);
         $passwordFieldQuery = ", password = '$newConfirmedPassword'";
    }

   $profileUpdateQuery = "UPDATE customer SET fullName = '$name', phone = '$phone', email = '$email', address = '$address'$passwordFieldQuery WHERE id = '$userID' ";

    if(mysqli_query($conn, $profileUpdateQuery)){
      echo '<script>
      alert("Profile updated successfully!"); 
      window.location.href="./user.php";
      </script>';
    }
    else{
      echo '<script>
      alert("Could not Update the Profile!"); 
      </script>';
    }

    }



    ?>
     
    <section class="edit-profile">
         <div id="profile" class="content active">
         <h2>Profile</h2>
                         
        <div class="edit-profile-card">
        <form action="#" method="post">
                <div class="form-group">
                  <label for="name"> Full Name</label>
                  <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($userData['fullName']); ?>" required>
                </div>
        
                <div class="form-group">
                   <label for="phone"> Phone</label>
                   <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($userData['phone']); ?>" required>
                </div>
        
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>" required>
                </div>
        
                <div class="form-group">
                  <label for="address">Address</label>
                  <input type="address" id="address" name="address" value="<?php echo htmlspecialchars($userData['address']); ?>" required>
                </div>

                 <div class="form-group">
                  <label for="oldPassword">Old Password</label>
                  <input type="password" id="oldPassword" name="oldPassword" placeholder="Enter your old password" required>
                </div>
                
                <div class="form-group">
                  <label for="password">New Password</label>
                  <input type="password" id="password" name="password" placeholder="Enter new password">
                </div>

                <div class="form-group">
                  <label for="confirm"> Confirm  Password</label>
                  <input type="password" id="confirm" name="confirm" placeholder="Confirm new password">
                </div>

             
                 <button type="submit" class="save-btn" id="save_btn" name="save_btn">Save Changes</button>
       </form>
      </div>
                  
    </section>
                         
 <?php
  mysqli_close($conn);
  include "./includes/footer.php";
 ?>
    <script src="./resources/js/userPage.js"></script>
    <script src="./resources/js/header.js"></script>
</body>
</html>
