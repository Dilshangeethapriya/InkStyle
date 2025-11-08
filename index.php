<?php
  session_start();
  $title = "InkStyle by Dinu";
  $cssFile = "index.css";

  include "./includes/header.php";
  include "./includes/dbConn.php";
 ?>
    <div class="image-slider">
        <div class="slider-text">
            <h1>Where Ink meets Style</h1>
            <p>Discover the perfect blend of tattoos and salon services in one place.</p>
        </div>
         <div class="slider-container">
            <img class="slider-image" src="./resources/images/imageSlider/image1.jpg" alt="slider image">
            <img class="slider-image" src="./resources/images/imageSlider/image2.jpg" alt="slider image">
            <img class="slider-image" src="./resources/images/imageSlider/image4.jpg" alt="slider image">
            <img class="slider-image" src="./resources/images/imageSlider/image5.jpg" alt="slider image">
            <img class="slider-image"  src="./resources/images/imageSlider/image6.jpg" alt="slider image">
         </div>
    </div>
    <section class="about-us" id="about-us">
        <div class="about-us-container">
             <img src="./resources/images/aboutUs.jpg" alt="tatto artist">
         <div class="about-us-text">
              <h1>About Us</h1>
         <p>At InkStyle by Dinu, we believe beauty is an art form whether it’s on your skin or in your style.
             Located in the heart of Gampaha, we are more than just a salon or a tattoo parlor; we’re a creative space where ink meets style. 
             From flawless haircuts, coloring, and treatments to bold and meaningful tattoos, 
             our talented team is here to help you express yourself with confidence.</p>
            <br><p>What makes us truly unique is the harmony we create between salon services and body art, giving you the chance to transform your look all in one place. And if you love taking a piece of beauty home, our carefully selected range of beauty products is always available.</p>

<br><p>Step in, relax, and let us bring your vision to life with style, with ink, and with a smile.</p>
         </div>
        </div>
    </section>
 <section class="services-and-prices" id="services-and-prices">   
    <h2>Hair Services</h2>
   <div class="hair-cut-list">
      <?php 
      $fetchHairServicesQuery = "SELECT * FROM services";
      $fetchHairServicesResult = mysqli_query($conn, $fetchHairServicesQuery);

      if(mysqli_num_rows($fetchHairServicesResult) > 0){
        while($services = mysqli_fetch_assoc($fetchHairServicesResult)){
          if($services['serviceCategory'] == 'Hair'){
      ?>
         <div class="service-item">
           <h3><?php echo htmlspecialchars($services['serviceName']); ?></h3>
           <p>LKR <?php echo number_format($services['estimatedPrice'], 2); ?></p>
         </div>
     <?php
           }
       }
      }
     ?>
  </div>
  <h2>Tatoo Services</h2>
  <table class="tatoo-price-table">
    <tr>
        <th>Tattoo Type</th>
        <th>Size</th>
        <th>Estimated Price</th>
        <th>Estimated Duration</th>
    </tr>
    <?php
      $fetchTattooServicesQuery = "SELECT * FROM services";
      $fetchTattooServicesResult = mysqli_query($conn, $fetchTattooServicesQuery);

    if(mysqli_num_rows($fetchTattooServicesResult) > 0){
        while($services = mysqli_fetch_assoc($fetchTattooServicesResult)){
          if($services['serviceCategory'] == 'Tattoo'){
      ?>
       <tr>
        <td><?php echo htmlspecialchars($services['serviceName']); ?></td>
        <td><?php echo isset($services['tattooSize'])? htmlspecialchars($services['tattooSize']): 'N/A'; ?></td>
        <td>LKR <?php echo number_format($services['estimatedPrice'], 2); ?></td>
        <td><?php echo $services['estimatedServiceTime']; ?> minutes</td>
    </tr>
     <?php
             }
           }
       }
     ?>
  </table>
  <div class="tatoo-item">
      <h3 >Custom Design</h3>
      <p>Starting from 7,000 LKR (final price depends on size & detail)</p>
  </div>
    </section>
    <section class="our-work" id="our-work">
      <h2>Our Work</h2> 
      <div class="photo-gallery">
        <?php
          $fetchGalleryImagesQuery = "SELECT * FROM gallery";
          $fetchGalleryImagesResult = mysqli_query($conn, $fetchGalleryImagesQuery);
    
          if(mysqli_num_rows($fetchGalleryImagesResult) > 0){
            while($galleryImages = mysqli_fetch_assoc($fetchGalleryImagesResult)){
              if(!empty($galleryImages['url'])){
        ?>
        <div class="gallery-item">
          <img src="<?php echo htmlspecialchars($galleryImages['url']); ?>" alt="galleryImage">
        </div>
        <?php
              }
            }
          }
        ?>
      </div>
    </section>


<?php
  include "./includes/footer.php";
 ?>
    <script src="./resources/js/header.js"></script>
</body>
</html>