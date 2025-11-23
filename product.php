<?php
     session_start();
     $title = "View Product | InkStyle by Dinu";
     $cssFile = "product.css";
   
     include "./includes/header.php";
     include "./includes/dbConn.php";
 ?>
   
   <section class="product-details-section">

    <div class="product-details-container">
      <?php
        
        if(isset($_GET['productID'])){
          $productID = mysqli_real_escape_string($conn, $_GET['productID']);

          $fetchProductQuery = "SELECT * FROM products WHERE productID = '$productID'";
          $fetchProductResults = mysqli_query($conn, $fetchProductQuery);

          if(mysqli_num_rows($fetchProductResults) === 1){
            while($product = mysqli_fetch_assoc($fetchProductResults)){

      ?>
      <div class="product-image">
        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['productName']); ?>">
      </div>
      <div class="product-info">
        <h1><?php echo htmlspecialchars($product['productName']); ?></h1>
        <?php if(intval($product['stock']) <= 10){echo '<p class="stock-badge out-of-stock">Availability : Out Of Stock</p>';}else{echo '<p class="stock-badge in-stock">Availability : In Stock</p>';} ?>
        <p class="product-price">LKR <?php echo number_format($product['price'],2); ?></p>
        <p class="product-description"><?php echo htmlspecialchars($product['description']); ?></p>
        <form action="./product.html" method="get">
           <a class="add-to-cart-btn" href="<?php if(intval($product['stock']) > 10)
                  {
                    echo './addToCart.php?productID='.htmlspecialchars($product['productID']);
                  }
                  else{
                    echo './addToCart.php?productID=outOfStock';
                  } ?>">
                  <i class="fa-solid fa-cart-shopping"></i>Add to Cart</a>
         </form>
       </div>
       <?php
          }

          }
          else{
               echo '<script>
                     alert("Cannot fetch product data from the database");
                     </script>';
               exit();  
          }
        }
       ?>
    </div>   
   </section>
     
       </a>

<?php
  mysqli_close($conn);
  include "./includes/footer.php";
?>
  <script src="./resources/js/header.js"></script>
</body>
</html>