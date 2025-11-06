<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : "InkStyle by Dinu" ;  ?></title>
    <link rel="icon" type="image/x-icon" href="./resources/images/inkstyle_favicon.ico">
    <link rel="stylesheet" href="./resources/css/header.css">
    <link rel="stylesheet" href="./resources/css/footer.css">
    <link rel="stylesheet" href="./resources/css/fab_btn.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    <?php if(isset($cssFile)){ ?>
        <link rel="stylesheet" href="./resources/css/<?php echo $cssFile; ?>">
    <?php  } ?>
</head>
<body>
    <header class="main-header" id="main-header">
         <a href="./index.php">
             <div class="header-container">
              <img class="header-logo" src="./resources/images/headerLogo.png" alt="">
             </div>    
         </a>
         <nav class="nav-bar">
              <ul class="nav-side-bar">
                <li onclick=hideSidebar()><i class="fa-solid fa-xmark"></i></li>
                 <li><a class="nav-link" href="./index.html" >
                  <div class="header-container">
                      <img class="header-logo" src="./resources/images/headerLogo.png" alt="">
                  </div>  
                 </a></li>
                <li><a class="nav-link" href="./index.php" >Home</a></li>
                <li><a class="nav-link" href="./index.php#about-us">About Us</a></li>
                <li><a class="nav-link" href="./index.php#services-and-prices">Services</a></li>
                <li><a class="nav-link" href="./contact.php">Contact</a></li>
                <li><a class="nav-link" href="./store.php">Store</a></li>
                <li><a class="nav-link" href="./booking.php">Book Now</a></li>
                <li><a class="nav-link" href="./login.php">Login</a></li>
                <li><a class="nav-link" href="./user.php">Account</a></li>
               </ul>
            <ul class="nav-list">
                <li class="hideOnMobile"><a class="nav-link" href="./index.php" >Home</a></li>
                <li class="hideOnMobile"><a class="nav-link" href="./index.php#about-us">About Us</a></li>
                <li class="hideOnMobile"><a class="nav-link" href="./index.php#services-and-prices">Services</a></li>
                <li class="hideOnMobile"><a class="nav-link" href="./contact.php">Contact</a></li>
                <li class="hideOnMobile"><a class="nav-link" href="./login.php">Login</a></li>
                <li class="hideOnMobile"><a class="nav-link  shop-btn" href="./store.php">Store</a></li>
                <li class="hideOnMobile"><a class="nav-link booking-btn" href="./booking.php">Book Now</a></li>
                <li class="hideOnMobile"><a class="nav-link  user-btn" href="./user.php"><i class="fa-solid fa-user"></i></a></li>
                <li class="nav-menu-icon" onclick=showSidebar()><i class="fa-solid fa-bars"></i></li>
            </ul>
         </nav>
    </header>