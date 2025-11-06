<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : "InkStyle by Dinu" ?></title>
    <link rel="icon" type="image/x-icon" href="../resources/images/inkstyle_favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    <link rel="stylesheet" href="../resources/css/admin/formStyiling.css">
    <link rel="stylesheet" href="../resources/css/admin/adminPanel.css">
    <?php if(isset($cssFile)){ ?>
        <link rel="stylesheet" href="../resources/css/<?php echo $cssFile; ?>">
    <?php  } ?>
</head>
<body> 
    <div class="grid-container">
          <header class="admin-header">
               <div class="menu-icon" onclick="openSidebar()">
                 <i class="fa-solid fa-bars"></i>
               </div>
                <div class="header-left">
                <h2 class="font-weight-bold"><?php echo isset($pageTitle) ? $pageTitle : "" ?></h2> 
                </div>
               <div class="header-right">
                    <i class="fa-regular fa-circle-user"></i>
               </div>
          </header>

           <aside class="sidebar" id="sidebar">
            <div class="sidebar-title">
                <div class="sidebar-logo">
                    <img src="../resources/images/headerLogo.png" alt="logo">
                </div>
                <div onclick="closeSidebar()" class="close-sidebar">
                  <i class="fa-solid fa-xmark"></i>
            </div>
            </div>
            <ul class="sidebar-list">
                 <a href="./adminPanel.php#admin-dashboard"><li class="sidebar-list-item"><i class="fa-solid fa-gauge"></i> Dashboard</li></a>
                 <a href="./adminPanel.php#admin-products"><li class="sidebar-list-item"><i class="fa-solid fa-box"></i> Products</li></a>
                 <a href="./adminPanel.php#admin-services"><li class="sidebar-list-item"><i class="fa-solid fa-scissors"></i> Services</li></a>
                 <a href="./adminPanel.php#admin-orders"><li class="sidebar-list-item"><i class="fa-solid fa-bag-shopping"></i> Orders</li></a>
                 <a href="./adminPanel.php#admin-bookings"><li class="sidebar-list-item"><i class="fa-solid fa-book-bookmark"></i> Bookings</li></a>
                 <a href="./adminPanel.php#admin-users"><li class="sidebar-list-item"><i class="fa-solid fa-users"></i> Users</li></a>
                 <a href="./adminPanel.php#admin-reviews"><li class="sidebar-list-item"><i class="fa-solid fa-star-half-stroke"></i> Reviews</li></a>
                 <a href="./adminPanel.php#admin-inquiries"><li class="sidebar-list-item"><i class="fa-solid fa-clipboard-question"></i> Inquiries</li></a>
            </ul>
           </aside>