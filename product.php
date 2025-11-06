<?php
     $title = "View Product | InkStyle by Dinu";
     $cssFile = "product.css";
   
     include "./includes/header.php";
 ?>
   
   <section class="product-details-section">

    <div class="product-details-container">
      <div class="product-image">
        <img src="./resources/images/Store/shampoo.jpg" alt="Hair Shampoo">
      </div>
      <div class="product-info">
        <h1>Hair Shampoo</h1>
        <p class="product-price">800.00 LKR</p>
        <p class="product-description">
          Experience soft, shiny, and healthy hair with our premium Hair Shampoo.
          Formulated with natural extracts and gentle cleansing agents, it nourishes
          your scalp and protects your hair from damage while maintaining natural moisture.
        </p>

        <div class="product-controls">
         <form action="./product.html" method="get">
                          <label for="quantity">Quantity:</label>
          <input type="number" id="quantity" name="quantity" min="1" value="1">
        </div>

        <button type="submit" class="add-to-cart-btn"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
         </form>

      </div>
    </div>
 
        
   </section>
     
       </a>

<?php
  include "./includes/footer.php";
?>
  <script src="./resources/js/header.js"></script>
</body>
</html>