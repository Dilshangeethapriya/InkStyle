    <?php
      session_start();
      include "../includes/dbConn.php";
      date_default_timezone_set('Asia/Colombo');
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

    

      $title = "Inquiry Details | InkStyle by Dinu";
      $pageTitle = "Inquiry Details";

      include "../includes/admin/adminHeader.php";


      $inquiryID = "";
      $inquiryData = "";
      if(isset($_GET['inquiryID'])){
          $inquiryID = mysqli_real_escape_string($conn, $_GET['inquiryID']);

          $fetchInquiryDataQuery = "SELECT * FROM inquiry WHERE inquiryID = '$inquiryID'";
          $fetchInquiryDataResult = mysqli_query($conn, $fetchInquiryDataQuery);

          if(mysqli_num_rows($fetchInquiryDataResult) === 1){
            $inquiryData = mysqli_fetch_assoc($fetchInquiryDataResult);
         }
        else{
        echo '<div class="status-message" style="position: absolute; width: 100%; top: 100px; color:red" ><p>Inquiry data is not found!</p></div>';
            exit();
        }
        }
      else{
          echo '<div class="status-message" style="position: absolute; width: 100%; top: 100px; color:red"><p>Inquiry ID is not provided!</p></div>';
          exit();
      }




      if(isset($_POST['update_status_btn'])){
        $inquiryID = mysqli_real_escape_string($conn, $_GET['inquiryID']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);


        $updateStatusQuery = "UPDATE inquiry SET status = '$status' WHERE inquiryID = '$inquiryID'";

        if(mysqli_query($conn, $updateStatusQuery)){
            echo '<script>
                   alert("Status updated!");
                   window.location.href = "./viewInquiry.php?inquiryID='.$inquiryID.'";
                 </script>';
        }
        else{
             echo '<script>
                   alert("Could not update the status!");
                   window.history.back();
                  </script>';
        }
        }

        if(isset($_POST['send_reply_btn'])){
        $inquiryID = mysqli_real_escape_string($conn, $_GET['inquiryID']);
        $reply = mysqli_real_escape_string($conn, $_POST['reply']);
        $currentDateTime = date("l, jS F Y \a\\t g:i A");


        $sendReplyQuery = "INSERT INTO inquiry_replies(inquiryID, reply) VALUES('$inquiryID', '$reply')";

        if(mysqli_query($conn, $sendReplyQuery)){

            $url = "http://localhost/inkstyle/services/emailService.php";

            $customerName = $inquiryData['name'];
            $customerEmail = $inquiryData['email'];
            $InqStatusCap = ucfirst($inquiryData['status']);
            $inquiryDate = date("l, jS F Y \a\\t g:i A",strtotime($inquiryData['created_at']));
            $inquiryMessage = $inquiryData['message'];

            $postData = [
              "subject" => "Response to Your Inquiry (ID:$inquiryID) | InkStyle By Dinu",
              "body" => " <h2>Hello, $customerName!</h2>
    
                          <p>We have reviewed your inquiry and our team has provided a response.</p>

                              
                          <p><b>Your Inquiry:</b></p>
                          <div style='background:#f5f5f5; padding:10px; border-radius:8px;'>$inquiryMessage</div>
                          <br>
               
                          <p><b>Inquiry Details:</b></p>
                          <ul>
                              <li><b>Inquiry ID:</b> $inquiryID</li>
                              <li><b>Submitted On:</b> $inquiryDate</li>
                              <li><b>Status:</b> $InqStatusCap</li>
                              <li><b>Replied On:</b> $currentDateTime</li>
                          </ul>
               
                          <p><b>Our Response:</b></p>
                          <p>$reply</p>
               
                          <br>
                          <p>If you have more questions, feel free to reply to this email.</p>
               
                          <p>Best regards,<br>
                          <b>InkStyle By Dinu</b> Team</p>",
                          "recipientEmail" => $customerEmail,
                          "recipientName" => $customerName,
                          "redirectUrl" => "./viewInquiry.php?inquiryID=$inquiryID"
            ];
          
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1);
            curl_exec($ch);
            curl_close($ch);   


            echo '<script>
                   alert("Reply sent successfully!");
                   window.location.href = "./viewInquiry.php?inquiryID='.$inquiryID.'";
                 </script>';
        }
        else{
             echo '<script>
                   alert("Could not send the reply!");
                   window.history.back();
                  </script>';
        }
        }
   
    ?>

        <main class="main-container">
            <div class="view-card">
                <a href="./adminPanel.php#admin-inquiries" class="close-btn"><i class="fa-solid fa-xmark-circle"></i></a>
                 
                <div class="view-group">
                    <p class="view-bold-text">Inquiry ID: </p>
                    <p><?php echo htmlspecialchars($inquiryData['inquiryID']); ?></p>
                </div>
                <div class="view-group">
                    <p class="view-bold-text">Name: </p>
                    <p><?php echo htmlspecialchars($inquiryData['name']); ?></p>
                </div>
                <div class="view-group">
                    <p class="view-bold-text">Email: </p>
                    <p><?php echo htmlspecialchars($inquiryData['email']); ?></p>
                </div>
                <div class="view-group">
                    <p class="view-bold-text">Phone: </p>
                    <p><?php echo htmlspecialchars($inquiryData['phone']); ?></p>
                </div>
                <div class="view-group">
                    <p class="view-bold-text">Status: </p>
                    <p class="inquiry-<?php echo htmlspecialchars($inquiryData['status']); ?>"><?php echo htmlspecialchars($inquiryData['status']); ?></p>
                </div>
                <div class="view-group">
                    <p class="view-bold-text">Date & Time Recieved: </p>
                    <p><?php echo htmlspecialchars(date("Y/m/d, g:i A",strtotime($inquiryData['created_at']))); ?></p>
                </div><div class="view-group">
                    <p class="view-bold-text">Date & Time Updated: </p>
                    <p><?php echo htmlspecialchars(date("Y/m/d, g:i A",strtotime($inquiryData['updated_at']))); ?></p>
                </div>
                <div class="view-group text-field-group">
                    <p class="view-bold-text">Message: </p>
                    <p class="text-field-view" ><?php echo htmlspecialchars($inquiryData['message']); ?></p>
                </div>

                <h3 class="group-heading">Old Replies</h3>
                <div class="view-group-cluster">
                    <?php 
                      $inquiryReplyQuery = "SELECT * FROM inquiry_replies WHERE inquiryID = '$inquiryID'";
                      $inquiryReplyQueryResult = mysqli_query($conn, $inquiryReplyQuery);
                      $inquiryReplies = "";

                      if(mysqli_num_rows($inquiryReplyQueryResult) > 0){
                        while($inquiryReplies = mysqli_fetch_assoc($inquiryReplyQueryResult)){
  
                    ?>
                    <div class="view-group text-field-group reply-box">
                       <p><span class="view-bold-text">Replied on: </span><?php echo htmlspecialchars(date("Y/m/d, g:i A",strtotime($inquiryReplies['created_at']))); ?></p>
                       <p class="text-field-view" ><?php echo htmlspecialchars($inquiryReplies['reply']); ?></p>
                    </div>
                    <?php
                       }
                      }
                      else{
                        echo ' <div class="view-group text-field-group">
                               <p>No repies sent for this inquiry.</p>
                            </div>';
                      }
                    ?>
                </div>

                
                
                
                <form action="viewInquiry.php?inquiryID=<?php echo htmlspecialchars($inquiryData['inquiryID']); ?>" method="POST" class="form" >
                    <div class="form-group textarea-group">
                        <label for="reply">Send a Reply</label>
                        <textarea id="reply" name="reply" rows="5" required></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="submit-btn" id="send_reply_btn" name="send_reply_btn"><i class="fa-solid fa-envelope"></i> Send</button>
                    </div>
                </form>
                <form action="viewInquiry.php?inquiryID=<?php echo htmlspecialchars($inquiryData['inquiryID']); ?>" method="POST" class="form" >
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status">
                            <option value="New" <?php if($inquiryData['status'] == 'New') echo 'selected'; ?>>New</option>
                            <option value="Open" <?php if($inquiryData['status'] == 'Open') echo 'selected'; ?>>Open</option>
                            <option value="Failed" <?php if($inquiryData['status'] == 'Failed') echo 'selected'; ?>>Failed</option>
                            <option value="Closed" <?php if($inquiryData['status'] == 'Closed') echo 'selected'; ?>>Closed</option>
                        </select>
                        <div class="form-actions">
                        <button type="submit" class="submit-btn" id="update_status_btn" name="update_status_btn" disabled><i class="fa-solid fa-pen-to-square"></i> Update Status</button>
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
        window.addEventListener("DOMContentLoaded", function(){
            const updateStatusBtn = document.getElementById("update_status_btn");
            const statusInput = document.getElementById("status");

            statusInput.addEventListener('change', function(){
                if(statusInput.value != "<?php echo htmlspecialchars($inquiryData['status']); ?>" ){
                    updateStatusBtn.disabled = false; 
                }
                else{
                    updateStatusBtn.disabled = true; 
                } 
            });
        } );
    </script>
    <script src="../resources/js/admin/sidebar.js"></script>
</body>
</html>

