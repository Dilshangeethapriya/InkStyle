   <?php
     session_start();
     $title = "Store | InkStyle by Dinu";
     $cssFile = "store.css";
   
     include "./includes/header.php";
     include "./includes/dbConn.php";
 ?>

   <section class="store-banner">
    <div class="banner-content">
       <h1>Best Quality Beauty Products, Just for You</h1>
       <p>Discover a handpicked collection of beauty products designed to bring out the best in you.
         From daily essentials to premium salon favorites, we offer trusted brands and carefully selected items all at your fingertips.
          Shop with ease, enjoy great value, and let us deliver beauty straight to your doorstep.</p>
    </div>
   </section>

   <section class="products-section" style="height: 100vh;">
    <h1>Products</h1>
       <div class="products-container">
        <?php 
        $fetchProductSql = "SELECT * FROM products";
        $fetchProductResult = mysqli_query($conn, $fetchProductSql);
        
        if(mysqli_num_rows($fetchProductResult) > 0){
            while($product = mysqli_fetch_assoc($fetchProductResult)){
        ?>
            <div class="product-card">
                <a href="./product.php?productID=<?php echo $product['productID']; ?>">
                   <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['productName']); ?>">
                </a>
                <div class="product-detail-container">
                 <a href="./product.php?productID=<?php echo $product['productID']; ?>">
                  <div class="product-name-container">
                  <h3 class="product-name"><?php echo htmlspecialchars($product['productName']); ?></h3>
                  <p class="product-price"> LKR <?php echo number_format($product['price'],2); ?></p>
                 </div>
                  </a>
                <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                </div>
            </div>
            <?php
                  }
                }else{
                     echo '<script>
                          alert("Cannot fetch product data from the database");
                          </script>';
                    exit();  
                }
            ?>
         </div>
        
   </section>
       <a href="./user.html#cart">
            <div class="cart-icon" id="cart-icon">
            <i class="fa-solid fa-cart-shopping"></i>
        </div>
       </a>
 <?php
  mysqli_close($conn);
  include "./includes/footer.php";
 ?>
 <script src="./resources/js/fab_btn.js"> </script>
 <script src="./resources/js/header.js"></script>
</body>
</html>