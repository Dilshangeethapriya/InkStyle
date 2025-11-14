    <?php
      session_start();

      $title = "Admin Panel | InkStyle by Dinu";
      $pageTitle = "Admin Panel";
      include "../includes/admin/adminHeader.php";
      include "../includes/dbConn.php";
    ?>

<main class="main-container">
    <section id="admin-dashboard">
        <div class="main-title">
            <h1 class="font-weight-bold">Dashboard</h1>
        </div>
        <div class="main-cards">
            <div class="card">
                <div class="card-inner">
                    <p class="text-primary">Products</p>
                    <i class="fa-solid fa-box"></i>
                </div>
                <?php
                  $productsCountQuery = "SELECT COUNT(*) AS total FROM products";
                  $productsCountResult = mysqli_query($conn, $productsCountQuery);
                   
                  $productCount = 0;
                  if($productsCountResult){
                     $row = mysqli_fetch_assoc($productsCountResult);
                     $productCount = $row['total'];
                  }
                  else{
                    $productCount = '0';
                  }
                ?>
               <span class="text-primary font-weight-bold"><?php echo htmlspecialchars($productCount); ?></span> 
            </div>
            <div class="card">
                <div class="card-inner">
                    <p class="text-primary">Orders</p>
                    <i class="fa-solid fa-bag-shopping"></i> 
                </div>
               <span class="text-primary font-weight-bold">40</span> 
            </div>
            <div class="card">
                <div class="card-inner">
                    <p class="text-primary">Bookings</p>
                    <i class="fa-solid fa-book-bookmark"></i>
                </div>
               <span class="text-primary font-weight-bold">35</span> 
            </div>
            <div class="card">
                <div class="card-inner">
                    <p class="text-primary">Customers</p>
                    <i class="fa-solid fa-users-line"></i>
                </div>
                <?php
                  $customersCountQuery = "SELECT COUNT(*) AS total FROM customer";
                  $customersCountResult = mysqli_query($conn, $customersCountQuery);
                   
                  $customerCount = 0;
                  if($customersCountResult){
                     $row = mysqli_fetch_assoc($customersCountResult);
                     $customerCount = $row['total'];
                  }
                  else{
                    $customerCount = '0';
                  }
                ?>
               <span class="text-primary font-weight-bold"><?php echo htmlspecialchars($customerCount); ?></span> 
            </div>
        </div>
        <div class="charts">
            <div class="charts-card">
                <h2 class="chart-title">Top Selling Products (Monthly Sales)</h2>
                <div class="bar-chart" id="bar-chart">
                </div>
            </div>
            <div class="charts-card">
                <h2 class="chart-title">Orders and Bookings</h2>
                <div class="area-chart" id="area-chart">
                    
                </div>
            </div>
            
        </div>
        
    </section>
                
    <section id="admin-products">
        <div class="main-title">
            <h1 class="font-weight-bold">Products</h1>
        </div>

        <div class="products-list">            
            <div class="products-list-header">
                <p>ID</p>
                <p>NAME</p>
                <p>PRICE</p>
                <p>STOCK</p>
                <p>DESCRIPTION</p>
                <p>IMAGE</p>
                <p>ACTIONS</p>
            </div>
            <?php
                $fetchProductsQuery = "SELECT * FROM products";
                $fetchProductsResult = mysqli_query($conn, $fetchProductsQuery);

                if(mysqli_num_rows($fetchProductsResult) > 0){
                   while($products = mysqli_fetch_assoc($fetchProductsResult)){
            ?>
                <div class="products-list-item">
                    <p><?php echo $products['productID'] ; ?></p>
                    <p><?php echo htmlspecialchars($products['productName']); ?></p>
                    <p>LKR <?php echo number_format($products['price'],2); ?></p>
                    <p><?php echo $products['stock']; ?></p>
                    <p class="item-description"><?php echo htmlspecialchars($products['description']); ?></p>
                    <div class="product-image">
                        <img src="<?php echo "." . htmlspecialchars($products['image']); ?>" alt="shampoo">
                    </div>
                    <div class="action-btns">
                        <a href="./updateProduct.php?productID=<?php echo $products['productID'] ; ?>"><button class="product-update btn-update" id="product-update"><i class="fa-solid fa-pen-to-square"></i> Update</button></a>
                        <button class="product-delete btn-delete" id="product-delete" onclick="deleteProduct(<?php echo $products['productID'] ; ?>)"><i class="fa-solid fa-trash"></i> Delete</button>
                   </div>
                </div>
                 <?php


                        }
                   }
                   else{
                       echo '<div class="status-message"><p>No products found in the database.</p></div>';
                   }
                 ?>
        </div>
         <div class="input-group">
            <a href="./addProduct.php">
                 <button class="add-product-btn">
                + Add New Product
            </button>
            </a>
        </div>
    </section>

    <section id="admin-services">
        <div class="main-title">
            <h1 class="font-weight-bold">Services</h1>
        </div>

        <div class="services-list">            
            <div class="services-list-header">
                <p>ID</p>
                <p>NAME</p>
                <p>SERVICE CATEGORY</p>
                <p>SIZE(TATTOO)</p>
                <p>PRICE</p>
                <p>SERVICE TIME</p>
                <p>ACTIONS</p>
            </div>
             <?php
                $fetchServicesQuery = "SELECT * FROM services";
                $fetchServicesResult = mysqli_query($conn, $fetchServicesQuery);

                if(mysqli_num_rows($fetchServicesResult) > 0){
                   while($services = mysqli_fetch_assoc($fetchServicesResult)){
            ?>
            <div class="services-list-item">
                    <p><?php echo $services['serviceID'] ; ?></p>
                    <p><?php echo htmlspecialchars($services['serviceName']); ?></p>
                    <p><?php echo htmlspecialchars($services['serviceCategory']); ?></p>
                    <p><?php echo htmlspecialchars($services['tattooSize']?? 'N/A'); ?></p>
                    <p>LKR <?php echo number_format($services['estimatedPrice'],2); ?></p>
                    <p><?php echo $services['estimatedServiceTime'] ; ?> minutes</p>
                    <div class="action-btns">
                        <a href="./updateService.php?serviceID=<?php echo $services['serviceID'] ; ?>"><button class="service-update btn-update" id="service-update"><i class="fa-solid fa-pen-to-square"></i> Update</button></a>
                        <button class="service-delete btn-delete" id="service-delete" onclick="deleteService(<?php echo $services['serviceID'] ; ?>)" ><i class="fa-solid fa-trash"></i> Delete</button>
                    </div>
             </div>
             <?php


                        }
                   }
                   else{
                       echo '<div class="status-message"><p>No services found in the database.</p></div>';
                   }
                 ?>
        </div>
            
         <div class="input-group">
            <a href="./addService.php">
            <button class="add-service-btn">
                + Add New Service
            </button>
            </a>
        </div>
    </section>


 <section id="admin-orders">
    <div class="main-title">
        <h1 class="font-weight-bold">Orders</h1>
    </div>
     <div class="search-group">
        <label for="filter_order_status" class="filter-order-status">Filter By Status: </label>
        <select name="filter_order_status" id="filter_order_status">
             <option value="">All</option>
             <option value="pending">Pending</option>
             <option value="confirmed">Confirmed</option>
             <option value="processing">Processing</option>
             <option value="shipped">Shipped</option>
             <option value="delivered">Delivered</option>
             <option value="failedDelivery">Delivery Failed</option>
             <option value="cancelled">Cancelled</option>
        </select>
        <label for="sort_order" class="sort-order">Sort By : </label>
        <select name="sort_order" id="sort_order">
             <option value="date_asc">Date (Oldest to Newest)</option>
             <option value="date_desc">Date (Newest to Oldest)</option>
        </select>
    </div>
    <div class="orders-list">            
        <div class="orders-list-header">
            <p>ORDER ID</p>
            <p>ORDER DATE</p>
            <p>CUSTOMER NAME</p>
            <p>TOTAL AMOUNT</p>
            <p>ORDER STATUS</p>
        </div>
            <div class="orders-list-body">
                
                <a href="view_order.php?id=1">
                    <div class="orders-list-item">
                        <p>1</p>
                        <p>5/11/2025</p>
                        <p>Dilshan Geethappriya</p>
                        <p>3000.00 LKR</p>
                        <p class="order-pending">Pending</p>
                    </div>
                </a> 
                
                <a href="view_order.php?id=2">
                    <div class="orders-list-item">
                        <p>2</p>
                        <p>1/11/2025</p>
                        <p>Dinusha Samudri</p>
                        <p>4500.00 LKR</p>
                        <p class="order-delivered">Delivered</p>
                    </div>
                </a> 
    
                <a href="view_order.php?id=3">
                    <div class="orders-list-item">
                        <p>3</p>
                        <p>6/11/2025</p>
                        <p>Kasun Perera</p>
                        <p>2200.00 LKR</p>
                        <p class="order-confirmed">Confirmed</p>
                    </div>
                </a> 
                
               
                
            </div>
    </div>
</section>

 <section id="admin-bookings">
    <div class="main-title">
        <h1 class="font-weight-bold">Bookings</h1>
    </div>
     <div class="search-group">
        <input type="text"  name="search_booking" id="search_booking" placeholder="Search Customer's Name">
        <label for="sort_booking" class="sort-booking">Sort By : </label>
        <select name="sort_booking" id="sort_booking">
             <option value="date_asc">Date (Oldest to Newest)</option>
             <option value="date_desc">Date (Newest to Oldest)</option>
        </select>
    </div>
    <div class="booking-list">            
        <div class="booking-list-header">
            <p>BOOKING ID</p>
            <p>BOOKING DATE</p>
            <p>TIME SLOT</p>
            <p>CLIENT NAME</p>
            <p>SERVICE</p>
            <p>STATUS</p>
        </div>
            <div class="booking-list-body">
                
                <a href="view_booking.php?id=1">
                    <div class="booking-list-item">
                        <p>1</p>
                        <p>6/11/2025</p>
                        <p>10.00 AM - 10.30 AM</p>
                        <p>Thamash wijesuriya</p>
                        <p>Men's Haircut</p>
                        <p class="booking-pending">Pending</p>
                    </div>
                </a> 

                 <a href="view_booking.php?id=2">
                    <div class="booking-list-item">
                        <p>2</p>
                        <p>8/11/2025</p>
                        <p>12.30 AM - 1.30 PM</p>
                        <p>Pasindu Jayanath</p>
                        <p>Medium Tatoo - Chest</p>
                        <p class="booking-completed">Completed</p>
                    </div>
                </a> 
                   
                <a href="view_booking.php?id=3">
                    <div class="booking-list-item">
                        <p>3</p>
                        <p>8/11/2025</p>
                        <p>2.30 AM - 3.30 PM</p>
                        <p>Janath Madusanka</p>
                        <p>Large Tatoo - Back</p>
                        <p class="booking-delayed">Delayed</p>
                    </div>
                </a> 
            </div>
    </div>
</section>


 <section id="admin-users">
    <div class="main-title">
        <h1 class="font-weight-bold">Users</h1>
    </div>
       <h2 class="font-weight-bold">Staff Management</h2>
     <div class="search-group">
        <input type="text"  name="search_staff" id="search_staff" placeholder="Search Member's Name">
        <label for="filter_staff" class="filter-staff">Filter By Role: </label>
        <select name="filter_staff" id="filter_staff">
             <option value="">All</option>
             <option value="admin">Admin</option>
             <option value="staff">Staff</option>
        </select>
    </div>
    <div class="user-list">            
        <div class="user-list-header staff-list">
            <p>FULL NAME</p>
            <p>PHONE</p>
            <p>EMAIL</p>
            <p>ADDRESS</p>
            <p>ROLE</p>
            <p>ACTIONS</p>
        </div>
        <div class="user-list-body" id="user-list-body-staff">
                               
        </div>
  </div>
  <div class="input-group">
            <a href="./addStaff.php">
                 <button class="add-staff-btn">
                + Add New Staff Member
            </button>
            </a>
        </div>


     <h2 class="font-weight-bold">Customer Accounts</h2>
     <div class="search-group">
        <input type="text"  name="search_customer" id="search_customer" placeholder="Search Customer's Name">
    </div>
    <div class="user-list">            
        <div class="user-list-header customer-list">
            <p>FULL NAME</p>
            <p>PHONE</p>
            <p>EMAIL</p>
            <p>ADDRESS</p>
        </div>
            <div class="user-list-body" id="user-list-body">
                      
            </div>
    </div>
</section>


<section id="admin-reviews">
    <div class="main-title">
        <h1 class="font-weight-bold">Reviews</h1>
    </div>
     <div class="search-group">
        <label for="filter_review_rating" class="filter-review-rating">Filter By Status: </label>
        <select name="filter_review_rating" id="filter_review_rating">
                <option value="">All</option>
                <option value="5">5 Stars</option>
                <option value="4">4 Stars</option>
                <option value="3">3 Stars</option>
                <option value="2">2 Stars</option>
                <option value="1">1 Star</option>
        </select>
        <label for="sort_review" class="sort-review">Sort By : </label>
        <select name="sort_review" id="sort_review">
             <option value="date_asc">Date (Oldest to Newest)</option>
             <option value="date_desc">Date (Newest to Oldest)</option>
        </select>
    </div>
    <div class="review-list">            
        <div class="review-list-header">
            <p>REVIEW ID</p>
            <p>PRODUCT/SERVICE NAME</p>
            <p>REVIEW DESCRIPTION</p>
            <p>RATING</p>
            <p>DATE</p>
        </div>
        <div class="review-list-body">     
                <div class="review-list-item">
                    <p>1</p>
                    <p>Hair Shampoo</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe, minima!</p>
                    <p>5 &#9733;</p>
                    <p>7/11/2025</p>
                </div>  
        </div>
        <div class="review-list-body">     
                <div class="review-list-item">
                    <p>2</p>
                    <p>Hair Conditioner</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe, minima!</p>
                    <p>4 &#9733;</p>
                    <p>7/11/2025</p>
                </div>  
        </div>
        <div class="review-list-body">     
                <div class="review-list-item">
                    <p>3</p>
                    <p>Tatoo Balm</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe, minima!</p>
                    <p>3 &#9733;</p>
                    <p>8/11/2025</p>
                </div>  
        </div>
    </div>
</section>

<section id="admin-inquiries">
    <div class="main-title">
        <h1 class="font-weight-bold">Inquiries</h1>
    </div>
       <h2 class="font-weight-bold">Customer Inquiries</h2>
     <div class="search-group">
        <input type="text"  name="search_inquiry" id="search_inquiry" placeholder="Search Customer's Name">
        <label for="filter_inquiry_status" class="filter-inquiry-status">Filter By Status: </label>
        <select name="filter_inquiry_status" id="filter_inquiry_status">
             <option value="">All</option>
             <option value="new">New</option>
             <option value="inProgress">In Progress</option>
             <option value="closed">Closed</option>
        </select>
    </div>
    <div class="inquiry-list">            
        <div class="inquiry-list-header customer-question-list">
            <p>ID</p>
            <p>FULL NAME</p>
            <p>PHONE</p>
            <p>EMAIL</p>
            <p>MESSAGE</p>
            <p>STATUS</p>
        </div>
            <div class="inquiry-list-body">
                
                    <a href="view_inquiry.php?id=1">
                        <div class="inquiry-list-item customer-question-list">
                            <p>1</p>
                            <p>Kasun Perera</p>
                            <p>0772314234</p>
                            <p>kasunperera@gmail.com</p>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit, quisquam?</p>
                            <p class="inquiry-new">New</p>
                        </div>
                    </a>

                    <a href="view_inquiry.php?id=1">
                        <div class="inquiry-list-item customer-question-list">
                            <p>2</p>
                            <p>Ishani Silva</p>
                            <p>0742314484</p>
                            <p>ishanis@gmail.com</p>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit, quisquam?</p>
                            <p class="inquiry-inProgress">In Progress</p>
                        </div>
                    </a>
                       
            </div>

     </div>
     <h2 class="font-weight-bold">Frequently Asked Questions</h2>
     <br>
     <div class="inquiry-list">            
        <div class="inquiry-list-header faq-list">
            <p>ID</p>
            <p>QUESTION</p>
            <p>ANSWER</p>
            <p>ACTION</p>
        </div>
            <div class="inquiry-list-body">
                    <?php
                         $fetchFaqQuery = "SELECT * FROM faq";
                         $fetchFaqResult = mysqli_query($conn, $fetchFaqQuery);
             
                         if(mysqli_num_rows($fetchFaqResult) > 0){
                           while($faqItem = mysqli_fetch_assoc($fetchFaqResult)){
        
                    ?>
                    <div class="inquiry-list-item faq-list">
                        <p><?php echo htmlspecialchars($faqItem['faqID']); ?></p>
                        <p><?php echo htmlspecialchars($faqItem['question']); ?></p>
                        <p><?php echo htmlspecialchars($faqItem['answer']); ?></p>
                        <div class="action-btns">
                           <a href="./updateFAQ.php?faqID=<?php echo htmlspecialchars($faqItem['faqID']); ?>"><button class="faq-update btn-update" id="faq-update-1"><i class="fa-solid fa-pen-to-square"></i> Update</button></a>
                           <button class="faq-delete btn-delete" id="faq-delete" onclick="deleteFAQ(<?php echo htmlspecialchars($faqItem['faqID']); ?>)" ><i class="fa-solid fa-trash"></i> Delete</button>
                        </div>
                    </div>
                    <?php
                           }
                        }
                    ?>
            </div>
    </div>
    <div class="input-group">
        <a href="./addFAQ.php">
        <button class="add-faq-btn">
            + Add New FAQ
        </button>
        </a>
    </div>
</section>


</main>
<?php
   mysqli_close($conn);
 ?>
</div>
 <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
 <script src="../resources/js/admin/dashboard.js"></script>
 <script src="../resources/js/admin/sidebar.js"></script>
 <script src="../resources/js/admin/productsSection.js"></script>
 <script src="../resources/js/admin/servicesSection.js"></script>
 <script src="../resources/js/admin/usersSection.js"></script>
  <script src="../resources/js/admin/inquirySection.js"></script>
</body>
</html>