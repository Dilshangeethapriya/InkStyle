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
        <p class="product-price">LKR <?php echo number_format($product['price'],2); ?></p>
        <p class="product-description"><?php echo htmlspecialchars($product['description']); ?></p>
        <form action="./product.html" method="get">
         <div class="product-controls">
           <label for="quantity">Quantity:</label>
           <input type="number" id="quantity" name="quantity" min="1" value="1">
         </div>
           <button type="submit" class="add-to-cart-btn"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
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