  <?php
    session_start();
    
    $title = "User Account | InkStyle by Dinu";
    $cssFile = "user.css";
  
    include "./includes/header.php";
    include "./includes/dbConn.php";
  ?>
<section class="user-section">
    <div class="tabs-container">
        <div class="tabs">
            <div onclick="showTabs('profile')" class="tab active">Profile</div>
            <div onclick="showTabs('orders')" class="tab">Orders</div>
            <div onclick="showTabs('bookings')" class="tab">Bookings</div>
            <div onclick="showTabs('cart')" class="tab">Cart</div>
            <div onclick="showTabs('inquiries')" class="tab">Inquiries</div>
        </div>
        <div class="content-container">
  <div id="profile" class="content active">
                 <h2>Profile</h2>
                 <div class="profile-card">
                           <?php
                              if(isset($_SESSION['userID'])){
                                   $userID = $_SESSION['userID'];
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
                              }else{
                                   header("Location: login.php");
                                   exit();
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
                      <div class="booking-card">
                           <div class="booking-header">
                             <h3>Booking #B009</h3>
                             <span class="status confirmed">Confirmed</span>
                           </div>
                           <p><strong>Date :</strong> 2025-10-12</p>
                           <p><strong>Time :</strong> 2:00 PM</p>
                           <p><strong>Services :</strong> Hair Coloring, Beard Trim</p>
                         </div>
                     
                         <div class="booking-card">
                           <div class="booking-header">
                             <h3>Booking #B008</h3>
                             <span class="status completed">Completed</span>
                           </div>
                           <p><strong>Date :</strong> 2025-09-28</p>
                           <p><strong>Time :</strong> 10:00 AM</p>
                           <p><strong>Services :</strong> Medium Tatoo - Chest</p>
                         </div>
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
                            <img src="./resources/images/Store/shampoo.jpg" alt="item">
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
                      <button onclick="window.location.href='./checkout.php'" class="btn-checkout">Proceed to Checkout</button>
                 </div>
                    
            </div>
             <div id="inquiries" class="content">
                 <h2>Inquiries</h2>
                      <div class="booking-card">
                           <div class="booking-header">
                             <h3>Inquiry #B009</h3>
                             <span class="status confirmed">Confirmed</span>
                           </div>
                           <p><strong>Date :</strong> 2025-10-12</p>
                           <p><strong>Time :</strong> 2:00 PM</p>
                           <p><strong>Services :</strong> Hair Coloring, Beard Trim</p>
                         </div>
                     
                         <div class="booking-card">
                           <div class="booking-header">
                             <h3>Inquiry #B008</h3>
                             <span class="status completed">Completed</span>
                           </div>
                           <p><strong>Date :</strong> 2025-09-28</p>
                           <p><strong>Time :</strong> 10:00 AM</p>
                           <p><strong>Services :</strong> Medium Tatoo - Chest</p>
                         </div>
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
