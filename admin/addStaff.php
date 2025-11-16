    <?php
      session_start();
      $title = "Add New Staff Member | InkStyle by Dinu";
      $pageTitle = "Add New Staff Member";

      include "../includes/admin/adminHeader.php";
      include "../includes/dbConn.php";

      if(isset($_POST['add_staff_btn'])){

        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $confirm = mysqli_real_escape_string($conn, $_POST['confirm']);

         if($password !== $confirm){
           echo '<script>
                   alert("Password and Confirm Password does not match!");
                   window.location.href = "./addStaff.php";
                 </script>';
       
           exit();
           }

        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $role = mysqli_real_escape_string($conn, $_POST['role']);


        // duplicate  staff Name or email check
        $nameEmailCheckSql = "SELECT * FROM staff WHERE fullName = '$name' OR email = '$email'";
        $nameEmailCheckResults = mysqli_query($conn, $nameEmailCheckSql);
        
        if(mysqli_num_rows($nameEmailCheckResults) > 0){
           echo '<script>
            alert("Entered Name or Email already exists!. Enter a different one.");
            window.location.href = "./addStaff.php";
            </script>';

          exit(); 
        }

  
        $addStaffSql = "INSERT INTO staff(fullName, phone, email, address, role, password) VALUES ('$name', '$phone', '$email', '$address', '$role', '$password')";

            if(mysqli_query($conn, $addStaffSql)){
               echo '<script>
                   alert("Member added successfully!");
                   window.location.href = "./adminPanel.php#admin-users";
               </script>';
            }
            else{
            echo '<script>
                   alert("Could not add the member!");
                   window.history.back();
                </script>';
            }
     
    }
    mysqli_close($conn); 
    ?>

        <main class="main-container">
            <div class="form-card">
                <form action="addStaff.php" method="POST" class="product-form" id="staff_register_form">
                    
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" required>
                    </div>

                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role" id="role">
                            <option value="Staff">Staff</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <div class="form-group">
                        <label for="confirm">Confirm Password</label>
                        <input type="password" id="confirm" name="confirm" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="submit-btn" id="add_staff_btn" name="add_staff_btn"><i class="fa-solid fa-plus-circle"></i> Add Member</button>
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

                const password = document.getElementById("password").value;
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