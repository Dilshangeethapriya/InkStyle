
  <?php
    session_start();
    
      if(!isset($_SESSION['userID'])){
      header("Location: login.php");
      exit();
    }


    
    $title = "Book an Appointment | InkStyle by Dinu";
    $cssFile = "booking.css";
    include "./includes/header.php";
    include "./includes/dbConn.php";

  
    $userID = mysqli_real_escape_string($conn, $_SESSION['userID']);
    
    $services = [];

    $fetchServiceQuery = "SELECT serviceID,serviceName,tattooSize,estimatedServiceTime FROM services";
    $fetchServiceResult = mysqli_query($conn, $fetchServiceQuery);
    
    if(mysqli_num_rows($fetchServiceResult) > 0){
      while($row = mysqli_fetch_assoc($fetchServiceResult)){
        // $tattooSize =  htmlspecialchars($services['tattooSize'])? "(".htmlspecialchars($services['tattooSize']).")" :  " ";
               $services[] = $row;  
          }
    }

    $servicesListJSON = json_encode($services); 


    if(isset($_POST['add_booking_btn'])){
       $userID = mysqli_real_escape_string($conn, $_SESSION['userID']);
       $bookingDate = mysqli_real_escape_string($conn, $_POST['booking_date']);
       $bookingStartTime = mysqli_real_escape_string($conn, $_POST['booking_time']);
       $totalDuration = mysqli_real_escape_string($conn, $_POST['total_duration_input']);
       $notes = mysqli_real_escape_string($conn, $_POST['extra-info']);
       $status = "pending";
       $services = $_POST['services'];

       if(empty($services)){
          echo '<script>
                   alert("No services selected!");
              </script>';

          exit();
       }

      
      
       $startDateTime = new DateTime("$bookingDate $bookingStartTime");
       $endDateTime = clone $startDateTime;
       date_modify($endDateTime, '+' . $totalDuration . ' minutes');
       $bookingEndTime = date_format($endDateTime, 'H:i:s');


       $insertBookingQuery = "INSERT INTO bookings(userID, booking_date, booking_start_time, booking_end_time, totalDuration, notes, status) VALUES ('$userID','$bookingDate','$bookingStartTime','$bookingEndTime','$totalDuration','$notes','$status')";

       if(mysqli_query($conn, $insertBookingQuery)){
        $bookingID = mysqli_insert_id($conn); // last inserted id
        
        foreach($services as $serviceID){
          $serviceID = intval($serviceID);
          $insertServiceQuery = "INSERT INTO booking_services (bookingID, serviceID) VALUES ('$bookingID', '$serviceID')";
          mysqli_query($conn, $insertServiceQuery);
        }

         echo '<script>
                   alert("Booking submitted successfully!");
                   window.location.href = "./booking.php"; 
               </script>';
         exit();
       }
       else{
        echo '<script>
                   alert("Cannot submit the booking!"); 
                   window.location.href = "./booking.php";
               </script>';
         exit();
       }
    }



   ?>
      <section class="booking-section">
             <div class="booking-container">
                <h1>Book Your Appointment</h1>
                <p class="booking-subtitle">Choose your service,select a date and time, and we'll take care of the rest!</p>
                <form action="" method="POST" id="booking_form">
          
                    
                    <label for="serviceSelect">Select a Service</label>
                    <div class="add-service">
                      <select id="serviceSelect" class="booking-inputs">
                        <option value="">Choose a service</option>
                     </select>
                     <button type="button" class="booking-inputs add-btn" id="add_service_btn"><i class="fa-regular fa-square-plus"></i> Add</button>
                    </div>
                     
                     
                     <ul id="serviceList" style="margin-top:10px;"></ul>
                     
                     
                     <div id="hiddenInputs"></div>
                     
                     <p><b>Total Duration:</b> <span id="totalDuration">0</span> minutes</p>
                     <input type="hidden"  name="total_duration_input" id="total_duration_input" >

                    <label for="booking_time">Time and Date</label>
                    <input type="date" class="booking-inputs" name="booking_date" id="booking_date" disabled required>
                    <input type="time" class="booking-inputs" name="booking_time" id="booking_time" min="07:00" max="21:00" disabled required>

                    <label for="extra-info">Notes</label>
                    <textarea class="extra-info" name="extra-info" id="extra-info" rows="5" placeholder="Anything else we should know?"></textarea>
                    <br>
                    <button class="booking-inputs submit-btn" type="submit" id="add_booking_btn" name="add_booking_btn">Book Now</button>
                </form>
             </div>
      </section>
    
  <?php
    include "./includes/footer.php";
   ?>

   <script>
    const servicesListData = <?php echo $servicesListJSON; ?>;
    
    
    
   </script>

    <script src="./resources/js/header.js"></script>
    <script src="./resources/js/booking.js"></script>  
</body>
</html> 