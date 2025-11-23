    <?php
      session_start();
      include "../includes/dbConn.php";
     
      $staffID = null;
      $role = null;
      if(isset($_SESSION['staffID']) && isset($_SESSION['roleOfUser'])){
        $staffID = mysqli_real_escape_string($conn, $_SESSION['staffID']);
        $role = mysqli_real_escape_string($conn, $_SESSION['roleOfUser']);

        // ---- for admin only pages  ----
        // if($role === 'Admin'){
        //     echo '<script>
        //            alert("You dont have access to this page!");
        //            window.location.href = "./adminPanel.php";
        //          </script>';
        //    exit();
        // }
      }
    //   else{
    //    header("Location: staffLogin.php");
    //    exit();
    //   }


      
      $title = "Order Details | InkStyle by Dinu";
      $pageTitle = "Order Details";
      include "../includes/admin/adminHeader.php";
      $bookingData = null;
      $bookingID = null;

      if(isset($_GET['bookingID'])){
          $bookingID = mysqli_real_escape_string($conn, $_GET['bookingID']);
          $bookedServices = [];
          $fetchBookingDataQuery = "SELECT 
          c.fullName,c.phone,c.email,c.address, b.*, s.serviceName, bs.bookingServiceID 
          FROM customer c 
          INNER JOIN bookings b ON c.id = b.userID 
          INNER JOIN booking_services bs ON bs.bookingID = b.bookingID 
          INNER JOIN services s ON s.serviceID = bs.serviceID 
          WHERE b.bookingID = '$bookingID'";

          $fetchBookingDataResult = mysqli_query($conn, $fetchBookingDataQuery);
          if(mysqli_num_rows($fetchBookingDataResult) > 0){
          $bookingData = mysqli_fetch_assoc($fetchBookingDataResult);

          // minute to hour/minutes
          $totalMinutes = intval($bookingData['totalDuration']);
          $hours = intdiv($totalMinutes, 60);
          $minuts = $totalMinutes%60;
          $totalDuration = 0;
          if($hours !== 0 &&  $minuts !== 0){
             $totalDuration =  "{$hours}h {$minuts}m";
          }
          elseif($hours === 0 &&  $minuts !== 0){
            $totalDuration =  "{$minuts}m";
          }
          elseif($hours !== 0 &&  $minuts === 0){
            $totalDuration =  "{$hours}h";
          }
         
       

          $fetchBookedServicesResult = mysqli_query($conn, $fetchBookingDataQuery);
          while($fetchServiceData = mysqli_fetch_assoc($fetchBookedServicesResult)){
               $bookedServices[] = $fetchServiceData['serviceName'];
          }
          
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
            $bookingDate = mysqli_real_escape_string($conn, $_POST['book_date']);
            $bookingStartTime = mysqli_real_escape_string($conn, $_POST['book_time']);
            $bookingDuration = mysqli_real_escape_string($conn, $_POST['book_duration']);
            $bookingNotes = isset($_POST['book_notes'])? mysqli_real_escape_string($conn, $_POST['book_notes']) : $bookingData['notes'];
            $bookingStatus = mysqli_real_escape_string($conn, $_POST['book_status']);

            $startDateTime = new DateTime("$bookingDate $bookingStartTime");
            $endDateTime = clone $startDateTime;
            date_modify($endDateTime, '+' . $bookingDuration . ' minutes');
            $bookingEndTime = date_format($endDateTime, 'H:i:s');

            $bookingUpdateQuery = "UPDATE bookings SET booking_date = '$bookingDate', booking_start_time = '$bookingStartTime', booking_end_time = '$bookingEndTime', totalDuration = '$bookingDuration', notes = '$bookingNotes', status = '$bookingStatus' WHERE bookingID ='$bookingID'";

            if(mysqli_query($conn, $bookingUpdateQuery)){

            echo '<script>
                   alert("Booking details updated successfully!");
                   window.location.href = "./viewBooking.php?bookingID='.$bookingID.'";
                 </script>';
            }
            else{
                 echo '<script>
                       alert("Could not update the booking details!");
                       window.location.href = "./viewBooking.php?bookingID='.$bookingID.'";
                      </script>';
            }

        }
      
   



      
     
     
    
   
    ?>

        <main class="main-container">
            <div class="view-card">
                <a href="./adminPanel.php#admin-bookings" class="close-btn"><i class="fa-solid fa-xmark-circle"></i></a>
                <h2>Booking Details - ID : <?php echo htmlspecialchars($bookingData['bookingID']); ?></h2>
                <div class="view-group">
                    <p class="view-bold-text">Client Name : </p>
                    <p><?php echo htmlspecialchars($bookingData['fullName']); ?></p>
                </div>
                <div class="view-group">
                    <p class="view-bold-text">Phone Number : </p>
                    <p><?php echo htmlspecialchars($bookingData['phone']); ?></p>
                </div>
                <div class="view-group">
                    <p class="view-bold-text">Email : </p>
                    <p><?php echo htmlspecialchars($bookingData['email']); ?></p>
                </div>
                <div class="view-group">
                    <p class="view-bold-text">Address : </p>
                    <p><?php echo htmlspecialchars($bookingData['address']); ?></p>
                </div>
                <div class="view-group">
                    <p class="view-bold-text">Booking ID : </p>
                    <p><?php echo htmlspecialchars($bookingData['bookingID']); ?></p>
                </div>
                <div class="view-group">
                    <p class="view-bold-text">Booking Date : </p>
                    <p><?php echo htmlspecialchars(date("l, jS F Y",strtotime($bookingData['booking_date']))); ?></p>
                </div>
                <div class="view-group">
                    <p class="view-bold-text">Time Slot : </p>
                    <p><?php echo htmlspecialchars(date("g:i A",strtotime($bookingData['booking_start_time']))); ?> - <?php echo htmlspecialchars(date("g:i A",strtotime($bookingData['booking_end_time']))); ?></p>
                </div>
                <div class="view-group">
                    <p class="view-bold-text">Total Duration : </p>
                    <p><?php echo htmlspecialchars($totalDuration); ?></p>
                </div>
                 <div class="view-group">
                    <p class="view-bold-text">Notes: </p>
                    <p><?php echo $bookingData['notes'] ? htmlspecialchars($bookingData['notes']) : "No notes added"; ?></p>
                </div>
                <div class="view-group">
                    <p class="view-bold-text">Booked services : </p>
                    <ul><?php
                    foreach($bookedServices as $service){
                           echo '<li>'.htmlspecialchars($service).'</li>';
                    }
                     
                     ?>
                    </ul>
                </div>
                <div class="view-group">
                    <p class="view-bold-text">Submited On : </p>
                    <p><?php echo htmlspecialchars(date("l, jS F Y",strtotime($bookingData['created_at']))); ?></p>
                </div>
                <div class="view-group">
                    <p class="view-bold-text">Status : </p>
                    <p class="booking-<?php echo htmlspecialchars($bookingData['status']); ?>"><?php echo htmlspecialchars(ucfirst($bookingData['status'])); ?></p>
                </div>

                <h3>Change Booking Details</h3>
                <form action="viewBooking.php?bookingID=<?php echo htmlspecialchars($bookingData['bookingID']); ?>" method="POST" class="form" >
                    <div class="form-group">
                        <label for="book_date">Booking Date</label>
                        <input type="date" id="book_date" name="book_date" class="booking-details-input" value="<?php echo htmlspecialchars($bookingData['booking_date']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="book_time">Starting Time</label>
                        <input type="time" id="book_time" name="book_time" class="booking-details-input" value="<?php echo htmlspecialchars($bookingData['booking_start_time']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="book_duration">Total Duration(Minutes)</label>
                        <input type="number" id="book_duration" name="book_duration" class="booking-details-input" value="<?php echo htmlspecialchars($bookingData['totalDuration']); ?>" required>
                    </div>
                    <div class="form-group textarea-group">
                        <label for="book_notes">notes</label>
                        <textarea id="book_notes" name="book_notes" class="booking-details-input" rows="5" placeholder="Do you have anything extra?"><?php echo htmlspecialchars($bookingData['notes']); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="book_status">Status</label>
                        <select name="book_status" id="book_status" class="booking-details-input">
                            <option value="pending" <?php if($bookingData['status'] == 'pending') echo 'selected'; ?>>pending</option>
                            <option value="confirmed" <?php if($bookingData['status'] == 'confirmed') echo 'selected'; ?>>confirmed</option>
                            <option value="completed" <?php if($bookingData['status'] == 'completed') echo 'selected'; ?>>completed</option>
                            <option value="delayed" <?php if($bookingData['status'] == 'delayed') echo 'selected'; ?>>delayed</option>
                            <option value="cancelled" <?php if($bookingData['status'] == 'cancelled') echo 'selected'; ?>>cancelled</option>
                        </select>
                        <div class="form-actions">
                        <button type="submit" class="submit-btn" id="update_details_btn" name="update_details_btn" disabled><i class="fa-solid fa-pen-to-square"></i>Update</button>
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
        const inputs = document.querySelectorAll('.booking-details-input');
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