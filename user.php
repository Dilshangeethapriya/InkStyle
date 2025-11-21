  <?php
    session_start();

    if(!isset($_SESSION['userID'])){
      header("Location: login.php");
      exit();
    }
 
    $title = "User Account | InkStyle by Dinu";
    $cssFile = "user.css";
  
    include "./includes/header.php";
    include "./includes/dbConn.php";
  ?>
<section class="user-section">
    <div class="tabs-container">
        <div class="tabs">
            <div onclick="showTabs('profile')" class="tab active"> <i class="fa-solid fa-circle-user"></i> <span class="tab-text">Profile</span> </div>
            <div onclick="showTabs('orders')" class="tab"> <i class="fa-solid fa-boxes-packing"></i> <span class="tab-text">Orders</span> </div>
            <div onclick="showTabs('bookings')" class="tab"> <i class="fa-solid fa-calendar-check"></i> <span class="tab-text">Bookings</span> </div>
            <div onclick="showTabs('cart')" class="tab"> <i class="fa-solid fa-cart-shopping"></i> <span class="tab-text">Cart</span> </div>
            <div onclick="showTabs('inquiries')" class="tab"> <i class="fa-solid fa-clipboard-question"></i> <span class="tab-text">Inquiries</span></div>
        </div>
        <div class="content-container">
  <div id="profile" class="content active">
                 <h2>Profile</h2>
                 <div class="profile-card">
                           <?php
                               $userID = mysqli_real_escape_string($conn, $_SESSION['userID']);
                               $userProfileQuery = "SELECT * FROM customer WHERE id = '$userID'";

                               $userProfileResults = mysqli_query($conn, $userProfileQuery);

                               if(mysqli_num_rows($userProfileResults) === 1){
                                    $row = mysqli_fetch_assoc($userProfileResults);
                           ?>

                               <p><strong>Name:</strong> <?php echo htmlspecialchars($row['fullName']); ?></p>
                               <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                               <p><strong>Phone:</strong> <?php echo htmlspecialchars($row['phone']); ?></p>
                               <p><strong>Address:</strong> <?php echo htmlspecialchars($row['address']); ?></p>
                               <button onclick="window.location.href='./editProfile.php'" class="btn-edit">Edit Profile</button>
                               <button onclick="window.location.href='./logout.php'" class="btn-logout">Logout</button>
            
                           <?php 
                              }      
                           ?>
                 </div>
 </div>
            <div id="orders" class="content">
                 <h2>Orders</h2>
                  <div class="order-card">
                       <div class="order-header">
                         <h3>Order #1024</h3>
                         <span class="status delivered">Delivered</span>
                       </div>
                       <p><strong>Date :</strong> 2025-10-02</p>
                       <table>
                            <tr>
                                 <th>Item</th> 
                                 <th>Price (LKR)</th>
                                 <th>Quantity</th>
                                 <th>Total (LKR)</th> 
                            </tr>
                            <tr>
                                 <td>Hair Shampoo</td> 
                                 <td>800.00</td>
                                 <td>2</td>
                                 <td class="price">1,600.00</td> 
                            </tr>
                            <tr>
                                 <td>Hair Conditioner </td> 
                                 <td>1,000.00</td>
                                 <td>1</td>
                                 <td class="price">1,000.00</td> 
                            </tr>
                            <tr>
                                 <td>Tattoo Healing Balm</td> 
                                 <td>600.00</td>
                                 <td>1</td>
                                 <td class="price">600.00</td> 
                            </tr>
                            <tr>
                                <td></td>
                                 <td>Grand total</td>
                                 <td>=</td>
                                 <td class="total">3,200.00 LKR</td> 
                            </tr>
                           </table>
                       
                     </div>                         
                     <div class="order-card">
                       <div class="order-header">
                         <h3>Order #1023</h3>
                         <span class="status pending">Pending</span>
                       </div>
                       <p><strong>Date :</strong> 2025-09-26</p>
                       <table>
                            <tr>
                                 <th>Item</th> 
                                 <th>Price (LKR)</th>
                                 <th>Quantity</th>
                                 <th>Total (LKR)</th> 
                            </tr>
                            <tr>
                                 <td>Moisturizing Cream</td> 
                                 <td>750.00</td>
                                 <td>1</td>
                                 <td class="price">750.00</td> 
                            </tr>
                            <tr>
                                 <td>Tattoo Aftercare Bandages</td> 
                                 <td>350.00</td>
                                 <td>2</td>
                                 <td class="price">700.00</td> 
                            </tr>
                            <tr>
                                 <td></td>
                                 <td>Grand total</td>
                                 <td>=</td>
                                 <td class="total">1,450.00 LKR</td> 
                            </tr>
                           </table>
                      
                     </div>
    
              
            </div>
            <div id="bookings" class="content">
                 <h2>Bookings</h2>
                    <?php
                        $userID = mysqli_real_escape_string($conn, $_SESSION['userID']);
                        $fetchBookingsQuery = "SELECT * FROM bookings WHERE userID = '$userID' ORDER BY created_at DESC";
                        $fetchBookingsResult = mysqli_query($conn, $fetchBookingsQuery);

                        if(mysqli_num_rows($fetchBookingsResult) > 0){
                         while($bookings = mysqli_fetch_assoc($fetchBookingsResult)){
                         $totalMinutes = intval($bookings['totalDuration']);
                         $hours = intdiv($totalMinutes, 60);
                         $minuts = $totalMinutes%60;
                         $totalDuration =  "{$hours}h {$minuts}m";
                         $bookingID = $bookings['bookingID'];
                         $serviceList = [];

                         $bookedServicesQuery = "SELECT serviceID FROM booking_services WHERE bookingID = '$bookingID'";
                         $bookedServicesResult =  mysqli_query($conn, $bookedServicesQuery);

                         if(mysqli_num_rows($bookedServicesResult) > 0){
                         while($bookedService = mysqli_fetch_assoc($bookedServicesResult)){
                              $serviceID = $bookedService['serviceID'];

                              $serviceDataQuery = "SELECT serviceName FROM services WHERE serviceID = '$serviceID'";
                              $serviceDataResult =  mysqli_query($conn,$serviceDataQuery);

                              if(mysqli_num_rows($serviceDataResult) > 0){
                              while($serviceData = mysqli_fetch_assoc($serviceDataResult)){
                                   $serviceList[] = $serviceData['serviceName']; 
                              }
                             }


                         }
                         }

                    ?>
                      <div class="booking-card">
                           <div class="booking-header">
                             <h3>Booking ID : <?php echo htmlspecialchars($bookings['bookingID']); ?></h3>
                             <span class="status booking-<?php echo htmlspecialchars($bookings['status']); ?>"><?php echo htmlspecialchars(ucfirst($bookings['status'])); ?></span>
                           </div>
                           <p><strong>Booking Date: </strong> <?php echo htmlspecialchars(date("l, jS F Y", strtotime($bookings['booking_date']))); ?></p>
                           <p><strong>Time Slot:</strong>  <?php echo htmlspecialchars(date("g:i A", strtotime($bookings['booking_start_time']))); ?> - <?php echo htmlspecialchars(date("g:i A", strtotime($bookings['booking_end_time']))); ?></p>
                           <p><strong>Total Duration :</strong> <?php echo htmlspecialchars($totalDuration); ?></p>
                           <div class="services-list">
                              <p class="services-list-child" ><strong>Services :</strong></p>
                              <p class="services-list-child"> <?php foreach($serviceList as $service){echo '<span> &bull; '.htmlspecialchars($service).'</span><br>' ;}  ?> </p>
                           </div>
                           <p><strong>Notes : </strong> <?php echo htmlspecialchars($bookings['notes']); ?></p>
                           <button class="btn-cancel" id="booking-cancel" name="booking-cancel" onclick="cancelBooking(<?php echo htmlspecialchars($bookings['bookingID']) ; ?>)" <?php if($bookings['status'] === 'completed' || $bookings['status'] === 'cancelled' || $bookings['status'] === 'confirmed'){echo "disabled";} ?>><i class="fa-solid fa-xmark"></i> Cancel Booking</button>
                           <span class="created-date">Submited on <?php echo htmlspecialchars(date("l, jS F Y \a\\t g:i A", strtotime($bookings['created_at']))); ?></span>
                      </div>
                     <?php
                         }
                        }
                     ?>          
            </div>
            <div id="cart" class="content">
                 <h2>Cart</h2>
                 <div class="cart-card">
                    <div class="cart-items-heading">
                        <p>ITEM</p>
                        <p>PRICE</p>
                        <p>QUANTITY</p>
                        <p>TOTAL</p>
                        <p>ACTION</p>
                    </div>
                    <div class="item-card">
                        
                        <div class="item-header">
                            <img src="./resources/images/Store/1762509329_shampoo.jpg" alt="item">
                            <p class="item-name">Hair Shampoo</p>
                        </div>
                        <p class="price">800.00 LKR</p>
                        <div class="quantity-control">
                          <button class="btn-qty minus" id="qty-minus">−</button>
                          <input type="number" class="quantity-input" id="qty-value" value="1" min="1" max="50">
                          <button class="btn-qty plus" id="qty-plus">+</button>
                        </div>
                        <p class="total">800.00 LKR</p>
                        <div class="action-btns">
                           <button class="product-remove" id="product_remove"><i class="fa-solid fa-trash"></i> Remove</button>
                       </div> 
                    </div>
                    <div class="item-card">
                        <div class="item-header">
                             <img src="./resources/images/Store/hairOil.jpg" alt="item">
                            <p class="item-name">Hair Oil</p>
                        </div>
                        <p class="price">600.00 LKR</p>
                        <div class="quantity-control">
                          <button class="btn-qty minus" id="qty-minus">−</button>
                          <input type="number" class="quantity-input" id="qty-value" value="1" min="1" max="50">
                          <button class="btn-qty plus" id="qty-plus">+</button>
                        </div>
                        <p class="total">1,200.00 LKR</p>
                        <div class="action-btns">
                           <a href="#"><button class="product-remove" id="product_remove"><i class="fa-solid fa-trash"></i> Remove</button></a>
                       </div> 
                    </div>
                      <p><strong>Grand total :</strong> 2,000.00 LKR</p>
                      <div class="action-btn">
                       <button onclick="window.location.href='./store.php'" class="btn-add"> <i class="fa-solid fa-cart-plus"></i> Add More Items</button>
                       <button onclick="window.location.href='./checkout.php'" class="btn-checkout"> <i class="fa-solid fa-circle-check"></i> Proceed to Checkout</button>
                      </div>
                      
                 </div>
                    
            </div>
             <div id="inquiries" class="content">
                 <h2>Inquiries</h2>
                 <?php
                      $fetchInquiryQuery = "SELECT * FROM inquiry WHERE customerID = '$userID'";
                      $fetchInquiryResult = mysqli_query($conn, $fetchInquiryQuery);
                      if(mysqli_num_rows($fetchInquiryResult) > 0){
                         while ($inquiryData = mysqli_fetch_assoc($fetchInquiryResult)){
                         $inquiryID = htmlspecialchars($inquiryData['inquiryID']);
                  ?>
                      <div class="inquiry-card">
                           <div class="inquiry-header">
                             <h3>Inquiry ID: <?php echo $inquiryID ?></h3>
                             <span class="status inquiry-<?php echo htmlspecialchars($inquiryData['status']) ?>"><?php echo htmlspecialchars($inquiryData['status']) ?></span>
                           </div>
                           <p><strong>Date & Time : </strong><?php echo htmlspecialchars(date("d M Y, g:i A",strtotime($inquiryData['created_at']))) ?></p>
                           <p><strong>Name : </strong> <?php echo htmlspecialchars($inquiryData['name']) ?></p>
                           <p><strong>Email : </strong><?php echo htmlspecialchars($inquiryData['email']) ?></p>
                           <p><strong>Phone : </strong><?php echo htmlspecialchars($inquiryData['phone']) ?></p>
                           <div class="message-container">
                              <p><strong>Message</strong></p>
                              <p><?php echo htmlspecialchars($inquiryData['message']) ?></p>
                           </div>
                           <hr>
                           <h4 class="inquiry-subheader">Replies</h4>
                           <div class="reply-list">
                            <?php 
                                 $inquiryReplyQuery = "SELECT * FROM inquiry_replies WHERE inquiryID = '$inquiryID'";
                                 $inquiryReplyQueryResult = mysqli_query($conn, $inquiryReplyQuery);
           
                                 if(mysqli_num_rows($inquiryReplyQueryResult) > 0){
                                   while($inquiryReplies = mysqli_fetch_assoc($inquiryReplyQueryResult)){
                             ?>
                               <div class="reply-container">
                                  <p><strong>Recieved on: </strong><?php echo htmlspecialchars(date("d M Y, g:i A",strtotime($inquiryReplies['created_at']))) ?> </p>
                                  <p><?php echo htmlspecialchars($inquiryReplies['reply']) ?></p>
                              </div>
                              <?php
                                   }
                              }
                              else{
                                   echo ' <p>No replies yet.</p>';
                              }
                              ?>
                           </div>

                     </div>
                   <?php
                           }
                      }
                   ?>
            </div>
         </div>
        </div>
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
