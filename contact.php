<?php
  session_start();
  $title = "Contact Us | InkStyle by Dinu";
  $cssFile = "contact.css";

  include "./includes/header.php";
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
                <form id="contactForm">
                  <div class="input-group">
                    <input type="text" id="name" name="name" placeholder="Your Name" required>
                  </div>
                  <div class="input-group">
                    <input type="email" id="email" name="email" placeholder="Your Email" required>
                  </div>
                  <div class="input-group">
                    <input type="tel" id="phone" name="phone" placeholder="Your Phone Number" required>
                  </div>
                  <div class="input-group">
                    <textarea id="message" name="message" placeholder="Your Message" rows="5" required></textarea>
                  </div>
                  <button type="submit" class="send-btn">Send Message</button>
                </form>
              </div>
            </div>


          <div class="faq-container">
          <h2>Frequently Asked Questions</h2>
          <div class="faq-list">
               <div class="faq-item">
                   <div class="faq-question">
                       <i class="fa-solid fa-question"></i>
                       <p>Can we make Appointments in Weekend?</p>
                   </div>
                   <div class="faq-answer">
                       <i class="fa-solid fa-circle-check"></i>
                       <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem, expedita?</p>
                    </div>
              </div>

              <div class="faq-item">
                   <div class="faq-question">
                       <i class="fa-solid fa-question"></i>
                       <p>Is cash on delivery available?</p>
                   </div>
                   <div class="faq-answer">
                       <i class="fa-solid fa-circle-check"></i>
                       <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem, expedita?</p>
                    </div>
              </div>

               <div class="faq-item">
                   <div class="faq-question">
                       <i class="fa-solid fa-question"></i>
                       <p>Do wee need to bring our own images for tatoos?</p>
                   </div>
                   <div class="faq-answer">
                       <i class="fa-solid fa-circle-check"></i>
                       <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem, expedita?</p>
                    </div>
              </div>
          </div>
        </div>
        </section>

   
    <?php
        include "./includes/footer.php";
    ?>

    <script src="./resources/js/header.js"></script>
</body>
</html>