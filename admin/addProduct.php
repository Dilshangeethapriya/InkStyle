    <?php
      session_start();
      $title = "Add New Product | InkStyle by Dinu";
      $pageTitle = "Add New Product";

      include "../includes/admin/adminHeader.php";
      include "../includes/dbConn.php";

      if(isset($_POST['add_product_btn'])){
        $productName = mysqli_real_escape_string($conn, $_POST['productName']);
        $productPrice = mysqli_real_escape_string($conn, $_POST['productPrice']);
        $productStock = mysqli_real_escape_string($conn, $_POST['productStock']);
        $productDescription = mysqli_real_escape_string($conn, $_POST['productDescription']);

        // setting image name and paths
        $fileDir = "../resources/images/Store/";
        $image = $_FILES['productImage'];

        $imageFileName = time(). "_" . basename($image['name']);
        $imageMovingPath = $fileDir . $imageFileName;
        
        $dbImagePath = "./resources/images/Store/" . $imageFileName;

        // duplicate productName check
        $nameCheckSql = "SELECT * FROM products WHERE productName = '$productName'";
        $nameCheckResults = mysqli_query($conn, $nameCheckSql);
        
        if(mysqli_num_rows($nameCheckResults) > 0){
           echo '<script>
            alert("Entered product Name already exists!. Enter a different name.");
            window.history.back();
            </script>';

          exit(); 
        }

        if(move_uploaded_file($image['tmp_name'], $imageMovingPath)){

            $addProductSql = "INSERT INTO products(productName, price, stock, description, image) VALUES ('$productName', '$productPrice', '$productStock', '$productDescription', '$dbImagePath')";

            if(mysqli_query($conn, $addProductSql)){
               echo '<script>
                   alert("Product added successfully!");
                   window.location.href = "./adminPanel.php#admin-products";
               </script>';
            }
            else{
            unlink($imageMovingPath);
            echo '<script>
                   alert("Could not add the product!");
                   window.history.back();
               </script>';
            }
        }
        else{
           echo '<script>
                   alert("Could not upload the file!");
                   window.history.back();
                 </script>';
        }
        
     
    }
    mysqli_close($conn); 
    ?>

        <main class="main-container">
            <div class="form-card">
                <form action="#" method="POST" class="product-form" enctype="multipart/form-data">
                    
                    <div class="form-group">
                        <label for="productName">Product Name</label>
                        <input type="text" id="productName" name="productName" required>
                    </div>

                    <div class="form-group">
                        <label for="productPrice">Price (LKR)</label>
                        <input type="number" id="productPrice" name="productPrice" required>
                    </div>

                    <div class="form-group">
                        <label for="productStock">Stock Quantity</label>
                        <input type="number" id="productStock" name="productStock" required>
                    </div>
                    
                    <div class="form-group textarea-group">
                        <label for="productDescription">Description</label>
                        <textarea id="productDescription" name="productDescription" rows="5" required></textarea>
                    </div>

                    <div class="form-group file-group">
                        <label for="productImage">Product Image</label>
                        <input type="file" id="productImage" name="productImage" accept="image/*" required>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="submit-btn" id="add_product_btn" name="add_product_btn"><i class="fa-solid fa-plus-circle"></i> Add Product</button>
                        <a href="adminPanel.php#admin-products"><button type="button" class="cancel-btn"><i class="fa-solid fa-xmark-circle"></i> Cancel</button></a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="../resources/js/admin/sidebar.js"></script>
</body>
</html>