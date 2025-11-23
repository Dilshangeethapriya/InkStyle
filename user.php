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
    $userID = mysqli_real_escape_string($conn, $_SESSION['userID']);
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
                 <?php
                   $getOrdersListQuery = "SELECT order_id, amount, status, payment_method, created_at FROM orders WHERE user_id = '$userID' ORDER BY created_at DESC";
                   $getOrdersListResult =  mysqli_query($conn, $getOrdersListQuery);

                   if(mysqli_num_rows($getOrdersListResult) > 0){
                     while($orders = mysqli_fetch_assoc($getOrdersListResult)){
                        $orderID = $orders['order_id'];
                    ?>
                    <div class="order-card">
                       <div class="order-header">
                         <h3>Order ID : <?php echo intVal($orderID) ?></h3>
                         <span class="status order-<?php echo htmlspecialchars($orders['status']) ?>"><?php echo htmlspecialchars(ucfirst($orders['status'])) ?></span>
                       </div>
                       <p><strong>Order Date :</strong> <?php echo htmlspecialchars(date("l, jS F Y ",strtotime($orders['created_at']))) ?></p>
                       <p><strong>Order Time :</strong> <?php echo htmlspecialchars(date("g:i A",strtotime($orders['created_at']))) ?></p>
                       <p><strong>Payment Method : </strong><?php echo htmlspecialchars($orders['payment_method']) ?></p>
                       <table>
                            <tr>
                                 <th>Item</th> 
                                 <th>Price (LKR)</th>
                                 <th>Quantity</th>
                                 <th class="price">Total (LKR)</th> 
                            </tr>

                    <?php
                       
                        $getOrderDataQuery = "SELECT oi.product_id, oi.quantity, oi.price, oi.subtotal, p.productName 
                        FROM order_items oi
                        JOIN orders o ON  o.order_id = oi.order_id
                        JOIN products p ON  oi.product_id = p.productID
                        WHERE o.order_id = '$orderID'";

                        $getOrderDataResult = mysqli_query($conn, $getOrderDataQuery);
                        
                           if(mysqli_num_rows( $getOrderDataResult) > 0){
                             while($orderData = mysqli_fetch_assoc( $getOrderDataResult)){
                         ?>
                           <tr>
                                 <td><?php echo htmlspecialchars($orderData['productName']) ?></td> 
                                 <td><?php echo htmlspecialchars(number_format($orderData['price'],2)) ?></td>
                                 <td><?php echo intval($orderData['quantity']) ?></td>
                                 <td class="price"><?php echo htmlspecialchars(number_format($orderData['subtotal'],2)) ?></td> 
                            </tr>
                         
                            <?php

                              }
                            }
                            ?>
                          
                            <tr>
                                <td></td>
                                 <td class="txtM">Grand total</td>
                                 <td class="txtM">=</td>
                                 <td class="txtM total"><?php echo htmlspecialchars(number_format($orders['amount'],2)) ?></td> 
                            </tr>
                           </table>
                        <button class="btn-cancel order-cancel"  name="order-cancel" onclick="cancelOrder(<?php echo htmlspecialchars($orderID) ; ?>)" <?php if($orders['status'] !== 'pending' && $orders['status'] !== 'failedDelivery' ){echo "disabled";} ?>><i class="fa-solid fa-xmark"></i> Cancel Order</button>
                     </div>   
                 <?php
                     }
                    
                   }  
                 ?>
                                        
     
              
            </div>
            <div id="bookings" class="content">
                 <h2>Bookings</h2>
                    <?php
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
                           <button class="btn-cancel"  name="booking-cancel" onclick="cancelBooking(<?php echo htmlspecialchars($bookings['bookingID']) ; ?>)" <?php if($bookings['status'] === 'completed' || $bookings['status'] === 'cancelled' || $bookings['status'] === 'confirmed'){echo "disabled";} ?>><i class="fa-solid fa-xmark"></i> Cancel Booking</button>
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
                    <?php
                       $cartQuery = "SELECT id FROM cart WHERE user_id = '$userID'";
                       $cartResult = mysqli_query($conn, $cartQuery);

                       $grandTotal = 0;

                       if (mysqli_num_rows($cartResult) === 1) {
                         $cart = mysqli_fetch_assoc($cartResult);
                         $cartID = $cart['id'];

                         $itemsQuery = "   SELECT ci.*, p.productName, p.image
                                           FROM cart_item ci
                                           JOIN products p ON ci.product_id = p.productID
                                           WHERE ci.cart_id = '$cartID'
                                       ";

                         $itemsResult = mysqli_query($conn, $itemsQuery);


                         if(mysqli_num_rows($itemsResult) > 0){
                             while ($item = mysqli_fetch_assoc($itemsResult)){
                               $itemTotal = floatval($item['price'])*intval($item['quantity']);
                               $grandTotal += $itemTotal;



                       

                    ?>
                    <div class="item-card" data-item-id="<?php echo intval( $item['id']);?>">
                        
                        <div class="item-header" >
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['productName']); ?>">
                            <p class="item-name"><?php echo htmlspecialchars($item['productName']); ?></p>
                        </div>
                        <p class="price" data-price="<?= $item['price'] ?>">LKR <?php echo number_format(floatval($item['price']),2); ?></p>
                        <div class="quantity-control">
                          <button class="btn-qty minus" id="qty-minus">−</button>
                          <input type="number" class="quantity-input" id="qty-value" value="<?php echo intval( $item['quantity']);?>" min="1" max="10">
                          <button class="btn-qty plus" id="qty-plus">+</button>
                        </div>
                        <p class="total">LKR <?php echo number_format(floatval($itemTotal),2); ?></p>
                        <div class="action-btns">
                           <button class="product-remove" onclick="removeCartItem(<?php echo intval( $item['id']);?>)"><i class="fa-solid fa-trash"></i> Remove</button>
                       </div> 
                    </div>
                     <?php
                     }
                         }
                          else{
                             echo '<p class="cart-empty-msg"> Your cart is empty!</p>';
                          }
               

                       }
                       else{
                             echo '<p class="cart-empty-msg"> Your cart is empty!</p>';
                       }
             ?>    
                      <p class="grand-total"><strong>Grand total :</strong> LKR <?php echo number_format(floatval($grandTotal),2); ?></p>
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
 <script src="./resources/js/cart.js"></script>
 <script src="./resources/js/userPage.js"></script>
 <script src="./resources/js/header.js"></script>
</body>
</html>
