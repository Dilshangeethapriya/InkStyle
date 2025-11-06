    <?php
      $title = "Add New Product | InkStyle by Dinu";
      $pageTitle = "Add New Product";

      include "../includes/admin/adminHeader.php";
    ?>

        <main class="main-container">
            <div class="form-card">
                <form action="#" method="POST" class="product-form">
                    
                    <div class="form-group">
                        <label for="productName">Product Name:</label>
                        <input type="text" id="productName" name="productName" required>
                    </div>

                    <div class="form-group">
                        <label for="productPrice">Price (LKR):</label>
                        <input type="number" id="productPrice" name="productPrice" required>
                    </div>

                    <div class="form-group">
                        <label for="productStock">Stock Quantity:</label>
                        <input type="number" id="productStock" name="productStock" required>
                    </div>
                    
                    <div class="form-group textarea-group">
                        <label for="productDescription">Description:</label>
                        <textarea id="productDescription" name="productDescription" rows="5" required></textarea>
                    </div>

                    <div class="form-group file-group">
                        <label for="productImage">Product Image:</label>
                        <input type="file" id="productImage" name="productImage" accept="image/*" required>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="submit-btn"><i class="fa-solid fa-plus-circle"></i> Add Product</button>
                        <a href="adminPanel.php#admin-products"><button type="button" class="cancel-btn"><i class="fa-solid fa-xmark-circle"></i> Cancel</button></a>
                    </div>
                </form>
            </div>
        </main>
    </div>

   <script src="../resources/js/admin/dashboard.js"></script>
</body>
</html>