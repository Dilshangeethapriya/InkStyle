    <?php
      session_start();
      $title = "Update Service | InkStyle by Dinu";
      $pageTitle = "Update Service";

      include "../includes/admin/adminHeader.php";
      include "../includes/dbConn.php";

      $serviceID = null;
      $serviceData = null;
      if(isset($_GET['serviceID'])){
          $serviceID = mysqli_real_escape_string($conn, $_GET['serviceID']);

          $fetchServiceDataQuery = "SELECT * FROM services WHERE serviceID = '$serviceID'";
          $fetchServiceDataResult = mysqli_query($conn, $fetchServiceDataQuery);

          if(mysqli_num_rows($fetchServiceDataResult) === 1){
            $serviceData = mysqli_fetch_assoc($fetchServiceDataResult);
         }
        else{
        echo '<div class="status-message" style="position: absolute; width: 100%; top: 100px; color:red" ><p>Service data is not found!</p></div>';
            exit();
        }
        }
      else{
          echo '<div class="status-message" style="position: absolute; width: 100%; top: 100px; color:red"><p>Service ID is not provided!</p></div>';
          exit();
      }

      if(isset($_POST['update_service_btn'])){
        $serviceName = mysqli_real_escape_string($conn, $_POST['serviceName']);
        $serviceCategory = mysqli_real_escape_string($conn, $_POST['serviceCategory']);
        $estimatedServicePrice = mysqli_real_escape_string($conn, $_POST['estimatedServicePrice']);
        $estimatedServiceTime = mysqli_real_escape_string($conn, $_POST['estimatedServiceTime']);
        $tattooSize = isset($_POST['tattooSize']) ? mysqli_real_escape_string($conn, $_POST['tattooSize']) : '';


         $updateServiceSql = "";
        if(!empty($tattooSize)){
                
         $updateServiceSql = "UPDATE services SET serviceName = '$serviceName', serviceCategory = '$serviceCategory', tattooSize = '$tattooSize', estimatedPrice = '$estimatedServicePrice', estimatedServiceTime = '$estimatedServiceTime' WHERE serviceID = '$serviceID'";
  
          if(mysqli_query($conn, $updateServiceSql)){
             echo '<script>
                 alert("Service updated successfully!");
                 window.location.href = "./adminPanel.php#admin-services";
             </script>';
          }
          else{
          echo '<script>
                 alert("Could not update the service!");
                 window.history.back();
             </script>';
          }
        }
        else{
     
        $updateServiceSql = "UPDATE services SET serviceName = '$serviceName', serviceCategory = '$serviceCategory', estimatedPrice = '$estimatedServicePrice', estimatedServiceTime = '$estimatedServiceTime' WHERE serviceID = '$serviceID'";

        if(mysqli_query($conn, $updateServiceSql)){
           echo '<script>
               alert("Service updated successfully!");
               window.location.href = "./adminPanel.php#admin-services";
           </script>';
        }
        else{
        echo '<script>
               alert("Could not update the service!");
               window.history.back();
           </script>';
        }

        }

     
       
     
    }
    mysqli_close($conn); 
    ?>

        <main class="main-container">
            <div class="form-card">
                <form action="updateService.php?serviceID=<?php echo $serviceID; ?>" method="POST" class="form" >
                    
                    <div class="form-group">
                        <label for="serviceName">Service Name</label>
                        <input type="text" id="serviceName" name="serviceName" value="<?php echo htmlspecialchars($serviceData['serviceName']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="serviceCategory">Service Category</label>
                        <select name="serviceCategory" id="serviceCategory">
                            <option value="Hair" <?php if($serviceData['serviceCategory'] == 'Hair') echo 'selected'; ?>>Hair</option>
                            <option value="Tattoo" <?php if($serviceData['serviceCategory'] == 'Tattoo') echo 'selected'; ?>>Tattoo</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="estimatedServicePrice">Estimated Service Price</label>
                        <input type="number" id="estimatedServicePrice" name="estimatedServicePrice" value="<?php echo $serviceData['estimatedPrice']; ?>" required>
                    </div>

                     <div class="form-group">
                        <label for="estimatedServiceTime">Estimated Service Time (Minutes)</label>
                        <input type="number" id="estimatedServiceTime" name="estimatedServiceTime" value="<?php echo $serviceData['estimatedServiceTime']; ?>" required>
                    </div>
                    
                     <div class="form-group">
                        <label for="tattooSize">Size(Tatto)</label>
                        <select name="tattooSize" id="tattooSize" <?php if($serviceData['serviceCategory'] == 'Hair') echo 'disabled'; ?>>
                            <option value="" <?php if($serviceData['tattooSize'] == '') echo 'selected'; ?> >Select a size</option>
                            <option value="Small" <?php if($serviceData['tattooSize'] == 'Small') echo 'selected'; ?>>Small</option>
                            <option value="Medium" <?php if($serviceData['tattooSize'] == 'Medium') echo 'selected'; ?>>Medium</option>
                            <option value="Large" <?php if($serviceData['tattooSize'] == 'Large') echo 'selected'; ?>>Large</option>
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="submit-btn" id="update_service_btn" name="update_service_btn"><i class="fa-solid fa-pen-to-square"></i> Update Service</button>
                        <a href="adminPanel.php#admin-services"><button type="button" class="cancel-btn"><i class="fa-solid fa-xmark-circle"></i> Cancel</button></a>
                    </div>
                </form>
            </div>
        </main>
    </div>
    <script>
        const categorySelect = document.getElementById('serviceCategory');
        const tattooSizeSelect = document.getElementById('tattooSize');

        categorySelect.addEventListener('change', function(){
            if(this.value == 'Tattoo'){
                tattooSizeSelect.disabled = false;
            }
            else{
                tattooSizeSelect.disabled = true;
                tattooSizeSelect.value = "";
            }
        });
    </script>
    <script src="../resources/js/admin/sidebar.js"></script>
</body>
</html>