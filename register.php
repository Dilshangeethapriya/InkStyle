
<?php

include "./includes/dbConn.php";

if(isset($_POST['register_btn'])){
  
  $password = $_POST['password'];
  $confirm = $_POST['confirm'];

  if($password !== $confirm){
    echo '<script>
            alert("Password and Confirm Password does not match!");
            window.history.back();
          </script>';

    exit();
    }

  $name    = mysqli_real_escape_string($conn, $_POST['name']);
  $phone   = mysqli_real_escape_string($conn, $_POST['phone']);
  $email   = mysqli_real_escape_string($conn, $_POST['email']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  $sql = "INSERT INTO customer(fullName,phone,email,address,password) VALUES ('$name','$phone','$email','$address','$password')";

  if(mysqli_query($conn,$sql)){
     echo '<script>
            alert("Registration Successfull!");
            window.location.href = "./login.php";
            </script>';
  }else{
    echo "Error: ". mysqli_error($conn);
  }
  
}


mysqli_close($conn);
 ?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register | InkStyle by Dinu</title>
  <link rel="icon" type="image/x-icon" href="./resources/images/inkstyle_favicon.ico">
  <link rel="stylesheet" href="./resources/css/register.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>

  <section class="register-section">
    <div class="register-card">
      <h1>Create Account</h1>
      <p>Join InkStyle by Dinu and experience where ink meets style.</p>

      <form class="register-form" action="register.php" method="POST">
        <div class="form-group">
          <label for="name"><i class="fa-solid fa-user"></i> Full Name</label>
          <input type="text" id="name" name="name" placeholder="Enter your full name" required>
        </div>

        <div class="form-group">
           <label for="phone"><i class="fa-solid fa-square-phone"></i> Phone</label>
           <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
        </div>

        <div class="form-group">
          <label for="email"><i class="fa-solid fa-envelope"></i> Email</label>
          <input type="email" id="email" name="email" placeholder="Enter your email" required>
        </div>

        <div class="form-group">
          <label for="address"><i class="fa-solid fa-location-dot"></i> Address</label>
          <input type="address" id="address" name="address" placeholder="Enter your address" required>
        </div>
        
        <div class="form-group">
          <label for="password"><i class="fa-solid fa-lock"></i> Password</label>
          <input type="password" id="password" name="password" placeholder="Create a password" required>
        </div>

        <div class="form-group">
          <label for="confirm"><i class="fa-solid fa-lock"></i> Confirm Password</label>
          <input type="password" id="confirm" name="confirm" placeholder="Confirm password" required>
        </div>

        <button type="submit" class="register-btn" id="register_btn" name="register_btn">Register</button>
      </form>

      <p class="login-link">Already have an account? <a href="./login.php">Login here</a></p>
      
    </div>
  </section>
</body>
</html>


