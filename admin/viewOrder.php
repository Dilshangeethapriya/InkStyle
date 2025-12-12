    <?php
      session_start();
      include "../includes/dbConn.php";
      $staffID = null;
      $role = null;
      if(isset($_SESSION['staffID']) && isset($_SESSION['roleOfUser'])){
        $staffID = mysqli_real_escape_string($conn, $_SESSION['staffID']);
        $role = mysqli_real_escape_string($conn, $_SESSION['roleOfUser']);
         //
        // ---- for admin only pages  ----
        // if($role !== 'Admin'){
        //     echo '<script>
        //            alert("You dont have access to this page!");
        //            window.location.href = "./adminPanel.php";
        //          </script>';
        //    exit();
        // }
      }
      else{
       header("Location: staffLogin.php");
       exit();
      }

    


      
      $title = "Order Details | InkStyle by Dinu";
      $pageTitle = "Order Details";
      include "../includes/admin/adminHeader.php";
      $orderData = null;
      $orderID = null;

      if(isset($_GET['orderID'])){
          $orderID = mysqli_real_escape_string($conn, $_GET['orderID']);
          $fetchOrderDataQuery = "SELECT c.fullName,c.phone,c.email,c.address, o.*
          FROM customer c 
          JOIN orders o ON c.id = o.user_id 
          WHERE o.order_id = '$orderID'";

          $fetchOrderDataResult = mysqli_query($conn, $fetchOrderDataQuery);
          if(mysqli_num_rows($fetchOrderDataResult) > 0){
          $orderData = mysqli_fetch_assoc($fetchOrderDataResult);

          
         }
        else{
        echo '<div class="status-message" style="position: absolute; width: 100%; top: 100px; color:red" ><p>Booking data not found!</p></div>';
            exit();
        }
        

      }
      else{
        echo '<div class="status-message" style="position: absolute; width: 100%; top: 100px; color:red" ><p>Booking ID not found!</p></div>';
            exit();
        }
      

        if(isset($_POST['update_details_btn'])){
            $changeAddress = mysqli_real_escape_string($conn, $_POST['change_address']);
            $orderStatus = mysqli_real_escape_string($conn, $_POST['order_status']);
            $userID = mysqli_real_escape_string($conn, $_POST['user_id']);

    
            $statusUpdateQuery = "UPDATE orders SET status = '$orderStatus' WHERE order_id ='$orderID'";
            $addressUpdateQuery = "UPDATE customer SET address = '$changeAddress' WHERE id ='$userID'";
            

            if(mysqli_query($conn, $statusUpdateQuery) && mysqli_query($conn, $addressUpdateQuery)){

            $url = "http://localhost/inkstyle/services/emailService.php";
            $customerName = $orderData['fullName'];
            $customerEmail = $orderData['email'];
            $OstatusCap = ucfirst($orderStatus);
            $orderDate = date("l, jS F Y",strtotime($orderData['created_at']));


            $postData = [
              "subject" => "Update on Your InkStyle By Dinu Order $orderID",
              "body" => " <h2>Hello, $customerName!</h2>
                          <p>Your order (ID:$orderID) has been updated.</p>
                          <p><b>Status:</b> $OstatusCap</p>
                          <p><b>Order Date:</b> $orderDate</p>
                          <p><b>Delivery Address:</b> $changeAddress</p>
                          <br>
                          <p>Regards,<br>InkStyle By Dinu Team</p>",
                          "recipientEmail" => $customerEmail,
                          "recipientName" => $customerName,
                          "redirectUrl" => "./viewOrder.php?orderID=$orderID"
          
            ];
          
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1);
            curl_exec($ch);
            curl_close($ch);
  

            echo '<script>
                   alert("Order details updated successfully!");
                   window.location.href = "./viewOrder.php?orderID='.$orderID.'";
                 </script>';
            }
            else{
                 echo '<script>
                       alert("Could not update order details!");
                       window.location.href = "./viewOrder.php?orderID='.$orderID.'";
                      </script>';
            }

        }
      
   



      
     
     
    
   
    ?>

        <main class="main-container">
            <div class="view-card">
                <a href="./adminPanel.php#admin-bookings" class="close-btn"><i class="fa-solid fa-xmark-circle"></i></a>
                <h2>Order ID : <?php echo htmlspecialchars($orderData['order_id']); ?></h2>

                 <div class="view-group">
                    <table>
                        <thead>
                          <tr>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th class="tbl-total">Total</th>
                          </tr>
                        </thead>
                        <tbody>
                           
                    <?php
                     $fetchOrderItemsQuery = "SELECT oi.*, p.productName FROM order_items oi JOIN products p ON oi.product_id = p.productID WHERE oi.order_id = '$orderID'";
                     $fetchorderItemsResult = mysqli_query($conn, $fetchOrderItemsQuery);
                       while($row = mysqli_fetch_assoc($fetchorderItemsResult)){
                                echo '<tr>
                                         <td>'.$row['productName'].'</td>
                                         <td>'.$row['price'].'</td>
                                         <td>'.$row['quantity'].'</td>
                                         <td  class="tbl-total" >'.$row['subtotal'].'</td>
                                      </tr>';
                       }
                  
                     ?>
                    </tbody>
                    <tfoot>
                          <tr>
                            <td></td>
                            <td>Grand Total</td>
                             <td>=</td>
                            <td class="tbl-total"><?php echo htmlspecialchars($orderData['amount']); ?></td>
                          </tr>
                        </tfoot>
                   </table>
                </div>
                <div class="view-group">
                    <p class="view-bold-text">Customer Name : </p>
                    <p><?php echo htmlspecialchars($orderData['fullName']); ?></p>
                </div>
                <div class="view-group">
                    <p class="view-bold-text">Phone Number : </p>
                    <p><?php echo htmlspecialchars($orderData['phone']); ?></p>
                </div>
                <div class="view-group">
                    <p class="view-bold-text">Email : </p>
                    <p><?php echo htmlspecialchars($orderData['email']); ?></p>
                </div>
                <div class="view-group">
                    <p class="view-bold-text">Address : </p>
                    <p><?php echo htmlspecialchars($orderData['address']); ?></p>
                </div>
                <div class="view-group">
                    <p class="view-bold-text">Order Date: </p>
                    <p><?php echo htmlspecialchars(date("l, jS F Y",strtotime($orderData['created_at']))); ?></p>
                </div>
                <div class="view-group">
                    <p class="view-bold-text">Order Time: </p>
                    <p><?php echo htmlspecialchars(date("g:i A",strtotime($orderData['created_at']))); ?></p>
                </div>
                 <div class="view-group">
                    <p class="view-bold-text">Payment Method: </p>
                    <p><?php echo htmlspecialchars($orderData['payment_method']); ?></p>
                </div>
              
                <div class="view-group">
                    <p class="view-bold-text">Status : </p>
                    <p class="order-<?php echo htmlspecialchars($orderData['status']); ?>"><?php echo htmlspecialchars(ucfirst($orderData['status'])); ?></p>
                </div>
                
                <h3>Update Order Details</h3>
                <form action="viewOrder.php?orderID=<?php echo htmlspecialchars($orderData['order_id']); ?>" method="POST" class="form" >
                    <input type="hidden" id="user_id" name="user_id" class="order-details-input" value="<?php echo htmlspecialchars($orderData['user_id']); ?>">
                    <div class="form-group">
                        <label for="change_address">Change Delivery Address</label>
                        <input type="text" id="change_address" name="change_address" class="order-details-input" value="<?php echo htmlspecialchars($orderData['address']); ?>">
                    </div>
                    <div class="form-group" >
                        <label for="order_status">Udate Status</label>
                        <select name="order_status" id="order_status" class="order-details-input">
                            <option value="pending" <?php if($orderData['status'] == 'pending') echo 'selected'; ?>>pending</option>
                            <option value="confirmed" <?php if($orderData['status'] == 'confirmed') echo 'selected'; ?>>confirmed</option>
                            <option value="processing" <?php if($orderData['status'] == 'processing') echo 'selected'; ?>>processing</option>
                            <option value="shipped" <?php if($orderData['status'] == 'shipped') echo 'selected'; ?>>shipped</option>
                            <option value="delivered" <?php if($orderData['status'] == 'delivered') echo 'selected'; ?>>delivered</option>
                            <option value="failedDelivery" <?php if($orderData['status'] == 'failedDelivery') echo 'selected'; ?>>failedDelivery</option>
                            <option value="cancelled" <?php if($orderData['status'] == 'cancelled') echo 'selected'; ?>>cancelled</option>
                        </select>
                        <div class="form-actions">
                        <button type="submit" class="submit-btn" id="update_details_btn" name="update_details_btn" disabled><i class="fa-solid fa-pen-to-square"></i>Update Status</button>
                      </div>
                    </div>

                </form>
            
           </div>
        </main>
    </div>
    <?php
        mysqli_close($conn); 
    ?>
    <script>
        const inputs = document.querySelectorAll('.order-details-input');
        const submitBtn = document.getElementById('update_details_btn');
        
        inputs.forEach(input => {
            input.addEventListener('change', () => {
                submitBtn.disabled = false;
            });
        });

    </script>
    <script src="../resources/js/admin/sidebar.js"></script>
</body>
</html>