    <?php
      session_start();
      include "../includes/dbConn.php";

      if (isset($_SESSION['staffID'])) {
          header("Location: adminPanel.php");
          exit();
      }



      if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['staff_login_btn'])){
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $staffCheckQuery = "SELECT * FROM staff WHERE email = '$email' AND password ='$password'";
        $staffCheckResult  = mysqli_query($conn, $staffCheckQuery);

        if(mysqli_num_rows($staffCheckResult) === 1 ){
            $staffMember = mysqli_fetch_assoc($staffCheckResult);
             $_SESSION['staffID'] = $staffMember['staffID'];
             $_SESSION['staffEmail'] = $staffMember['email'];
             $_SESSION['roleOfUser'] = $staffMember['role'];

             echo '
                  <script>
                   alert("Login Successfull!");
                   window.location.href = "./adminPanel.php";
                  </script>
                  ';


            mysqli_close($conn);
            exit();
        }
        else{
             echo '
                <script>
                alert("Incorrect email or password!");
                window.location.href = "./staffLogin.php";
                </script>
                ';

             mysqli_close($conn);
             exit();
        }
      }

      
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login | InkStyle</title>
    <link rel="stylesheet" href="../resources/css/admin/staffLogin.css">
    <link rel="icon" type="image/x-icon" href="../resources/images/inkstyle_favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
</head>
<body>

<section class="staff-login-section">
    <div class="staff-login-card">
        <img class="logo-img" src="../resources/images/headerLogo.png" alt="InkStyle">
        <h1>Staff Login</h1>

        <form action="" method="POST" class="staff-login-form">

            <div class="form-group">
                <label for="email"><i class="fa-solid fa-envelope"></i> Email</label>
                <input type="email" name="email" id="email" placeholder="Enter email" required>
            </div>

            <div class="form-group">
                <label for="password"><i class="fa-solid fa-lock"></i> Password</label>
                <input type="password" name="password" id="password" placeholder="Enter password" required>
            </div>

            <button type="submit" class="staff-login-btn" name="staff_login_btn">
                Login
            </button>

            <a href="../index.php" class="back-home">
                <i class="fa-solid fa-arrow-left"></i> Back to Website
            </a>

        </form>
    </div>
</section>

</body>
</html>
