<?php
  session_start();
  $title = "Contact Us | InkStyle by Dinu";
  $cssFile = "contact.css";

  include "./includes/header.php";
  include "./includes/dbConn.php";

  $userData = '';

   if(isset($_SESSION['userID'])){
       $userID = $_SESSION['userID'];
       $userProfileQuery = "SELECT * FROM customer WHERE id = '$userID'";
       $userProfileResults = mysqli_query($conn, $userProfileQuery);
       if(mysqli_num_rows($userProfileResults) === 1){
            $userData = mysqli_fetch_assoc($userProfileResults);
       }
      }


  
  if(isset($_POST['submit-contact-form'])){
      $customerID = mysqli_real_escape_string($conn, ($_POST['customerID']));
      $status = mysqli_real_escape_string($conn, $_POST['status']);
      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $phone = mysqli_real_escape_string($conn, $_POST['phone']);
      $message = mysqli_real_escape_string($conn, $_POST['message']);

      $addInquiryQuery = "";
      
      if(!empty($customerID)){
          $addInquiryQuery = "INSERT INTO inquiry( customerID, name, email, phone, message, status) VALUES ('$customerID', '$name', '$email', '$phone', '$message', '$status')";
      }
      else{
          $addInquiryQuery = "INSERT INTO inquiry( name, email, phone, message, status) VALUES ( '$name', '$email', '$phone', '$message', '$status')";
      }
      

      if(mysqli_query($conn, $addInquiryQuery)){
         echo '
             <script>
              alert("Message Sent Successfully!");
              window.location.href = "./contact.php";
             </script>
              ';
      }
      else{
         echo '
              <script>
              alert("Cannot Send the Message!");
              window.history.back();
              </script>
              ';
      }
  }

  
 ?>

 

        <section class="contact-section">
            <div class="contact-container">
              <div class="contact-info">
                <h2>Get in Touch</h2>
                <p class="intro-text">
                  Whether you’re ready for your next tattoo or have a quick question, we’d love to hear from you.
                </p>
          
                <div class="info-item">
                  <i class="fa-solid fa-phone"></i>
                  <div>
                    <h4>Phone</h4>
                    <p>+94 70 139 0925</p>
                  </div>
                </div>
          
                <div class="info-item">
                  <i class="fa-solid fa-envelope"></i>
                  <div>
                    <h4>Email</h4>
                    <p>hello@inkstylebydinu.lk</p>
                  </div>
                </div>
          
                <div class="info-item">
                  <i class="fa-solid fa-location-dot"></i>
                  <div>
                    <h4>Location</h4>
                    <p>18/A, Delgoda, Gampaha, Sri Lanka</p>
                  </div>
                </div>
          
                <div class="working-hours">
                  <h3>Working Hours</h3>
                  <ul>
                    <li><strong>Mon &minus; Fri:</strong> 9:00 AM &minus; 7:00 PM</li>
                    <li><strong>Saturday:</strong> 9:00 AM &minus; 5:00 PM</li>
                    <li><strong>Sunday:</strong> Closed</li>
                  </ul>
                </div>
          
                <div class="social-links">
                  <a href="https://facebook.com/"><i class="fa-brands fa-square-facebook"></i></a>
                  <a href="https://instagram.com/"><i class="fa-brands fa-instagram"></i></a>
                  <a href="https://www.tiktok.com/@dinu_tattoos"><i class="fa-brands fa-tiktok"></i></a>
                </div>
              </div>
          
              <div class="contact-form">
                <h2>Send Us a Message</h2>
                <form id="contactForm" action="contact.php" method="POST">
                  <input type="hidden" name="customerID" id="customerID" value="<?php echo htmlspecialchars($userData['id'] ?? ''); ?>" >
                  <input type="hidden" name="status" id="status" value="new" >
                  <div class="input-group">
                    <input type="text" id="name" name="name" autocomplete="name" placeholder="Your Name" <?php echo !empty($userData['fullName'])? ' value="'.htmlspecialchars($userData['fullName']).'"' : '' ?> required>
                  </div>
                  <div class="input-group">
                    <input type="email" id="email" name="email" autocomplete="email" placeholder="Your Email" <?php echo !empty($userData['email'])? ' value="'.htmlspecialchars($userData['email']).'"' : '' ?> required>
                  </div>
                  <div class="input-group">
                    <input type="tel" id="phone" name="phone" autocomplete="tel" placeholder="Your Phone Number" <?php echo !empty($userData['phone'])? ' value="'.htmlspecialchars($userData['phone']).'"' : '' ?> required>
                  </div>
                  <div class="input-group">
                    <textarea id="message" name="message" placeholder="Your Message" rows="5" required></textarea>
                  </div>
                  <button type="submit" class="send-btn" name="submit-contact-form" id="submit-contact-form">Send Message</button>
                </form>
              </div>
            </div>


          <div class="faq-container">
          <h2>Frequently Asked Questions</h2>
          <div class="faq-list">
            <?php
            $fetchFaqQuery = "SELECT * FROM faq";
            $fetchFaqResult = mysqli_query($conn, $fetchFaqQuery);

            if(mysqli_num_rows($fetchFaqResult) > 0){
              while($faqItem = mysqli_fetch_assoc($fetchFaqResult)){

            ?>
               <div class="faq-item">
                   <div class="faq-question">
                       <i class="fa-solid fa-question"></i>
                       <p><?php echo htmlspecialchars($faqItem['question']); ?></p>
                   </div>
                   <div class="faq-answer">
                       <i class="fa-solid fa-circle-check"></i>
                       <p><?php echo htmlspecialchars($faqItem['answer']); ?></p>
                    </div>
              </div>
              <?php
               }
            }
              ?>
          </div>
        </div>
        </section>

   
    <?php
        include "./includes/footer.php";
    ?>

    <script src="./resources/js/header.js"></script>
</body>
</html>