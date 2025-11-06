<?php
session_start();

include "./includes/dbConn.php";

if(isset($_POST['login_btn'])){
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  $sql = "SELECT * FROM customer WHERE email = '$email' AND password = '$password'";

  $results = mysqli_query($conn, $sql);
  
  if(mysqli_num_rows($results) > 0){
    $row = mysqli_fetch_assoc($results);
    $_SESSION['userID'] = $row['id'];
    $_SESSION['userEmail'] = $row['email'];

    echo '
    <script>
     alert("Login Successfull!");
     window.location.href = "./index.php";
    </script>
    ';
  }
  else{
    echo '
    <script>
    alert("Incorrect email or password!");
    window.history.back();
    </script>
    ';
  }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | InkStyle by Dinu</title>
    <link rel="icon" type="image/x-icon" href="./resources/images/inkstyle_favicon.ico">
    <link rel="stylesheet" href="./resources/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
</head>
<body>
       <section class="login-section">
         <div class="login-card">
            <h1>Welcome Back</h1>
            <p>Login to manage your bookings, orders, and account details.</p>  
            <form class="login-form" action="#" method="post" >
             <div class="form-group">
               <label for="email"><i class="fa-solid fa-envelope"></i> Email</label>
               <input type="email" id="email" name="email" placeholder="Enter your email" required>
             </div>
     
             <div class="form-group">
               <label for="password"><i class="fa-solid fa-lock"></i> Password</label>
               <input type="password" id="password" name="password" placeholder="Enter your password" required>
             </div>

             <button type="submit" class="login-btn" id="login_btn" name="login_btn">Login</button>
             <p>Don't have an account? <a href="./register.php">Register</a></p>
             <a href="./index.php" class="back-home"><i class="fa-solid fa-arrow-left"></i> Back to Home</a>
         </form>

         </div>
       </section>
      
</body>
</html>