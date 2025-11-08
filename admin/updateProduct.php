<?php
      session_start();
      $title = "Update Product | InkStyle by Dinu";
      $pageTitle = "Update Product";

      include "../includes/admin/adminHeader.php";
      include "../includes/dbConn.php";
      
      $productID = null;
      $productData = null;
      if(isset($_GET['productID'])){
          $productID = mysqli_real_escape_string($conn, $_GET['productID']);

          $fetchProductDataQuery = "SELECT * FROM products WHERE productID = '$productID'";
          $fetchProductDataResult = mysqli_query($conn, $fetchProductDataQuery);

          if(mysqli_num_rows($fetchProductDataResult) === 1){
            $productData = mysqli_fetch_assoc($fetchProductDataResult);
         }
        else{
        echo '<div class="status-message" style="position: absolute; width: 100%; top: 100px; color:red" ><p>Product data is not found!</p></div>';
            exit();
        }
        }
      else{
          echo '<div class="status-message" style="position: absolute; width: 100%; top: 100px; color:red"><p>Product ID is not provided!</p></div>';
          exit();
      }
      
      if(isset($_POST['update_product_btn'])){
        $productName = mysqli_real_escape_string($conn, $_POST['productName']);
        $productPrice = mysqli_real_escape_string($conn, $_POST['productPrice']);
        $productStock = mysqli_real_escape_string($conn, $_POST['productStock']);
        $productDescription = mysqli_real_escape_string($conn, $_POST['productDescription']);

        // setting image name and paths
        $fileDir = "../resources/images/Store/";
        $image = $_FILES['productImage'];
        $hasNewImage = !empty($image['name']);
        
        $oldImagePath = $productData['image'];
        $imageFileName = time(). "_" . basename($image['name']);
        $imageMovingPath = $fileDir . $imageFileName;
        
        $dbImagePath = "./resources/images/Store/" . $imageFileName;

        // duplicate productName check
       
        if($productData['productName'] !== $productName){

          $nameCheckSql = "SELECT * FROM products WHERE productName = '$productName'";
          $nameCheckResults = mysqli_query($conn, $nameCheckSql);

          if(mysqli_num_rows($nameCheckResults) > 0){
            echo '<script>
            alert("Entered product Name already exists!. Enter a different name.");
            window.history.back();
            </script>';
          exit(); 
           }
        }
       
        
        if($hasNewImage){
        $imageFileName = time(). "_" . basename($image['name']);
        $imageMovingPath = $fileDir . $imageFileName;
        $dbImagePath = "./resources/images/Store/" . $imageFileName;

        if(move_uploaded_file($image['tmp_name'], $imageMovingPath)){

            $updateProductSql = "UPDATE products SET productName = '$productName', price = '$productPrice', stock = '$productStock', description = '$productDescription', image = '$dbImagePath' WHERE productID = '$productID'";

            $oldFilePath = "." . $oldImagePath;
            if (file_exists($oldFilePath) && strpos($oldImagePath, 'Store/') !== false) {
                unlink($oldFilePath);
            }
            if(mysqli_query($conn, $updateProductSql)){
               echo '<script>
                   alert("Product updated successfully!");
                   window.location.href = "./adminPanel.php#admin-products";
               </script>';
            }
            else{
            unlink($imageMovingPath);
            echo '<script>
                   alert("Could not update the product!");
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
        else{
             $updateProductSql = "UPDATE products SET productName = '$productName', price = '$productPrice', stock = '$productStock', description = '$productDescription' WHERE productID = '$productID'";

             if(mysqli_query($conn, $updateProductSql)){
               echo '<script>
                   alert("Product updated successfully!");
                   window.location.href = "./adminPanel.php#admin-products";
               </script>';
            }
            else{
            unlink($imageMovingPath);
            echo '<script>
                   alert("Could not update the product!");
                   window.history.back();
               </script>';
            }
        } 
    } 
    ?>

        <main class="main-container">
            <div class="form-card">
                <form action="updateProduct.php?productID=<?php echo $productID; ?>" method="POST" class="product-form" enctype="multipart/form-data">
                    
                    <div class="form-group">
                        <label for="productName">Product Name:</label>
                        <input type="text" id="productName" name="productName" value="<?php echo htmlspecialchars($productData['productName']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="productPrice">Price (LKR):</label>
                        <input type="number" id="productPrice" name="productPrice" value="<?php echo $productData['price']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="productStock">Stock Quantity:</label>
                        <input type="number" id="productStock" name="productStock" value="<?php echo $productData['stock']; ?>" required>
                    </div>
                    
                    <div class="form-group textarea-group">
                        <label for="productDescription">Description:</label>
                        <textarea id="productDescription" name="productDescription" rows="5" required><?php echo htmlspecialchars($productData['description']); ?></textarea>
                    </div>

                    <div class="form-group file-group">
                        <label for="productImage">Product Image:</label>
                        <input type="file" id="productImage" name="productImage" accept="image/*">
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="submit-btn" id="update_product_btn" name="update_product_btn"><i class="fa-solid fa-pen-to-square"></i> Update Product</button>
                        <a href="adminPanel.php#admin-products"><button type="button" class="cancel-btn"><i class="fa-solid fa-xmark-circle"></i> Cancel</button></a>
                    </div>
                </form>
            
            </div>
        </main>
    </div>
   <?php
      mysqli_close($conn);
   ?>
    <script src="../resources/js/admin/sidebar.js"></script>
</body>
</html>