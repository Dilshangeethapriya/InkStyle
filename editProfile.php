   <?php
     $title = "Edit Profile | InkStyle by Dinu";
     $cssFile = "editProfile.css";
   
     include "./includes/header.php";
    ?>
     
    <section class="edit-profile">
         <div id="profile" class="content active">
         <h2>Profile</h2>
                         
        <div class="edit-profile-card">
        <form action="#" method="post">
                <div class="form-group">
                  <label for="name"> Full Name</label>
                  <input type="text" id="name" name="name" value="Dilshan Geethappriya" required>
                </div>
        
                <div class="form-group">
                   <label for="phone"> Phone</label>
                   <input type="tel" id="phone" name="phone" value="077 3834851" required>
                </div>
        
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" id="email" name="email" value="dilshan.geethappriya@gmail.com" required>
                </div>
        
                <div class="form-group">
                  <label for="address">Address</label>
                  <input type="address" id="address" name="address" value=" No 05, Sumithrarama Road, Ewariyawaththa, Katunayake" required>
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

             
                 <button type="submit" class="save-btn">Save Changes</button>
       </form>
      </div>
                  
    </section>
                         
 <?php
  include "./includes/footer.php";
 ?>
    <script src="./resources/js/userPage.js"></script>
    <script src="./resources/js/header.js"></script>
</body>
</html>
