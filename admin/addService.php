    <?php
      session_start();
      $title = "Add New Service | InkStyle by Dinu";
      $pageTitle = "Add New Service";

      include "../includes/admin/adminHeader.php";
      include "../includes/dbConn.php";

      if(isset($_POST['add_service_btn'])){
        $serviceName = mysqli_real_escape_string($conn, $_POST['serviceName']);
        $serviceCategory = mysqli_real_escape_string($conn, $_POST['serviceCategory']);
        $estimatedServicePrice = mysqli_real_escape_string($conn, $_POST['estimatedServicePrice']);
        $estimatedServiceTime = mysqli_real_escape_string($conn, $_POST['estimatedServiceTime']);
        $tattooSize = isset($_POST['tattooSize']) ? mysqli_real_escape_string($conn, $_POST['tattooSize']) : '';

        
        $addServiceSql = "";
        if(!empty($tattooSize)){
                
        $addServiceSql = "INSERT INTO services(serviceName, serviceCategory, tattooSize, estimatedPrice, estimatedServiceTime) VALUES ('$serviceName', '$serviceCategory', '$tattooSize','$estimatedServicePrice','$estimatedServiceTime')";

        if(mysqli_query($conn, $addServiceSql)){
           echo '<script>
               alert("Service added successfully!");
               window.location.href = "./adminPanel.php#admin-services";
           </script>';
        }
        else{
        echo '<script>
               alert("Could not add the service!");
               window.history.back();
           </script>';
        }
        }
        else{
     
        $addServiceSql = "INSERT INTO services(serviceName, serviceCategory, estimatedPrice, estimatedServiceTime) VALUES ('$serviceName', '$serviceCategory', '$estimatedServicePrice','$estimatedServiceTime')";

        if(mysqli_query($conn, $addServiceSql)){
           echo '<script>
               alert("Service added successfully!");
               window.location.href = "./adminPanel.php#admin-services";
           </script>';
        }
        else{
        echo '<script>
               alert("Could not add the service!");
               window.history.back();
           </script>';
        }

        }

     
       
     
    }
    mysqli_close($conn); 
    ?>

        <main class="main-container">
            <div class="form-card">
                <form action="addService.php" method="POST" class="form" >
                    
                    <div class="form-group">
                        <label for="serviceName">Service Name</label>
                        <input type="text" id="serviceName" name="serviceName" required>
                    </div>
                    <div class="form-group">
                        <label for="serviceCategory">Service Category</label>
                        <select name="serviceCategory" id="serviceCategory">
                            <option value="Hair">Hair</option>
                            <option value="Tattoo">Tatoo</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="estimatedServicePrice">Estimated Service Price</label>
                        <input type="number" id="estimatedServicePrice" name="estimatedServicePrice" required>
                    </div>

                     <div class="form-group">
                        <label for="estimatedServiceTime">Estimated Service Time (Minutes)</label>
                        <input type="number" id="estimatedServiceTime" name="estimatedServiceTime" required>
                    </div>
                    
                     <div class="form-group">
                        <label for="tattooSize">Size(Tatto)</label>
                        <select name="tattooSize" id="tattooSize" disabled>
                            <option value="">Select a size</option>
                            <option value="Small">Small</option>
                            <option value="Medium">Medium</option>
                            <option value="Large">Large</option>
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="submit-btn" id="add_service_btn" name="add_service_btn"><i class="fa-solid fa-plus-circle"></i> Add Service</button>
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