   <?php
     $title = "Store | InkStyle by Dinu";
     $cssFile = "store.css";
   
     include "./includes/header.php";
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
            <div class="product-card">
                <a href="./product.php">
                   <img src="./resources/images/Store/shampoo.jpg" alt="product image">
                </a>
                <div class="product-detail-container">
                 <a href="./product.html">
                  <div class="product-name-container">
                  <h3 class="product-name">Hair Shampoo</h3>
                  <p class="product-price">800.00 LKR</p>
                 </div>
                  </a>
                <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                </div>
            </div>
            <div class="product-card">
                <a href="./product.html">
                <img src="./resources/images/Store/conditioner.jpg" alt="product image">
                </a>
                <div class="product-detail-container">
                    <a href="./product.html">
                    <div class="product-name-container">
                <h3 class="product-name">Hair Conditioner</h3>
                <p class="product-price">1,000.00 LKR</p>
                </div>
                </a>
                <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                </div>
            </div>
            <div class="product-card">
                <a href="./product.html">
                <img src="./resources/images/Store/hairOil.jpg" alt="product image">
                </a>
                <div class="product-detail-container">
                    <a href="./product.html">
                    <div class="product-name-container">
                <h3 class="product-name">Hair Oil</h3>
                <p class="product-price">600.00 LKR</p>
                </div>
                </a>
                <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                </div>
            </div>
            <div class="product-card">
                <a href="./product.html">
                <img src="./resources/images/Store/cream.jpg" alt="product image">
                </a>
                <div class="product-detail-container">
                    <a href="./product.html">
                    <div class="product-name-container">
                <h3 class="product-name">Moisturizing Cream</h3>
                <p class="product-price">750.00 LKR</p>
                </div>
                </a>
                <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                </div>
            </div>
            <div class="product-card">
                <a href="./product.html">
                <img src="./resources/images/Store/tatooBalm.jpg" alt="product image">
                </a>
                <div class="product-detail-container">
                    <a href="./product.html">
                    <div class="product-name-container">
                <h3 class="product-name">Tatoo Healing Balm</h3>
                <p class="product-price">600.00 LKR</p>
                </div>
                </a>
                <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                </div>
            </div>
            <div class="product-card">
                <a href="./product.html">
                <img src="./resources/images/Store/bandages.jpg" alt="product image">
                </a>
                <div class="product-detail-container">
                 <a href="./product.html">
                <div class="product-name-container">
                <h3 class="product-name">Tatoo Aftercare Bandages</h3>
                <p class="product-price">350.00 LKR</p>
                </div>
                </a>
                <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                </div>
            </div>
         </div>
        
   </section>
       <a href="./user.html#cart">
            <div class="cart-icon" id="cart-icon">
            <i class="fa-solid fa-cart-shopping"></i>
        </div>
       </a>
 <?php
  include "./includes/footer.php";
 ?>
 <script src="./resources/js/fab_btn.js"> </script>
 <script src="./resources/js/header.js"></script>
</body>
</html>