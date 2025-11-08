
  <?php
    session_start();
    $title = "Book an Appointment | InkStyle by Dinu";
    $cssFile = "booking.css";
    include "./includes/header.php";
   ?>
      <section class="booking-section">
             <div class="booking-container">
                <h1>Book Your Appointment</h1>
                <p class="booking-subtitle">Choose your service,select a date and time, and we'll take care of the rest!</p>
                <form action="./booking.html">
                    <label for="customerName">Name</label>
                    <input type="text" class="booking-inputs customer-name" id="cumstomerName" name="customerName" placeholder="Enter your name" required>
                    <label for="contact_number">Contact Number</label>
                    <input type="text" class="booking-inputs contact-number" id="contact_number" name="contact_number" placeholder="Enter your contact number" required>
                    <label for="extra-info">Email</label>
                    <input type="email" class="booking-inputs email-address" id="email_address" name="email_address" placeholder="Enter your email" required>
                    <label>Services</label>
                    <select class="booking-inputs" name="services" id="services" required>
                        <option value="">Choose a service</option>
                        <option value="haircutMen">Men's Haircut</option>
                        <option value="haircutWomen">Women's Haircut</option>
                        <option value="haircutKids">Kid's Haircut</option>
                        <option value="washDry">Hair Wash dnd Blow Dry</option>
                        <option value="beard">Beard Trim and Style</option>
                        <option value="headMessage">Head Message</option>
                        <option value="tatooS">Tatoo (small)</option>
                        <option value="tatooM">Tatoo (medium)</option>
                        <option value="tatooL">Tatoo (large)</option>
                    </select>
                    <label for="booking_time">Time and Date</label>
                    <input type="date" class="booking-inputs" name="booking_date" id="booking_date" required>
                    <input type="time" class="booking-inputs" name="booking_time" id="booking_time" required>

                    <label for="extra-info">Notes</label>
                    <textarea class="extra-info" name="extra-info" id="extra-info" rows="5">Anything else we should know?</textarea>
                    <br>
                    <button class="booking-inputs submit-btn" type="submit">Book Now</button>
                </form>
             </div>
      </section>
    
  <?php
    include "./includes/footer.php";
   ?>
    <script src="./resources/js/header.js"></script> 
</body>
</html>