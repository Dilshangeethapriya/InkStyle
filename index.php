<?php
  $title = "InkStyle by Dinu";
  $cssFile = "index.css";

  include "./includes/header.php";
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
    <div class="service-item">
      <h3>Men’s Haircut</h3>
      <p>Price: 1,000 LKR</p>
    </div>
    <div class="service-item">
      <h3>Women’s Haircut</h3>
      <p>Price: 1,500 LKR</p>
    </div>
    <div class="service-item">
      <h3>Kids’ Haircut</h3>
      <p>Price: 800 LKR</p>
    </div>
    <div class="service-item">
      <h3>Hair Wash and Blow Dry</h3>
      <p>Price: 800 LKR</p>
    </div>
    <div class="service-item">
      <h3>Beard Trim and Styling</h3>
      <p>Price: 700 LKR</p>
    </div>
    <div class="service-item">
      <h3>Head Massage</h3>
      <p>Price: 1,200 LKR</p>
    </div>
  </div>
  <h2>Tatoo Services</h2>
  <table class="tatoo-price-table">
    <tr>
        <th>Body Area</th>
        <th>Small (5cm x 5cm)</th>
        <th>Medium (10cm x 10cm)</th>
        <th>Large (15cm x 15cm)+ </th>
    </tr>
    <tr>
        <td>Arm/Wrist</td>
        <td>4,000 LKR</td>
        <td>8,000 LKR</td>
        <td>12,000 + LKR</td>
    </tr>
    <tr>
        <td>Shoulder/Back</td>
        <td>5,000 LKR</td>
        <td>10,000 LKR</td>
        <td>15,000 + LKR</td>
    </tr>
    <tr>
        <td>Chest</td>
        <td>6,000 LKR</td>
        <td>12,000 LKR</td>
        <td>18,000 + LKR</td>
    </tr>
    <tr>
        <td>Leg/Thigh</td>
        <td>5,000 LKR</td>
        <td>10,000 LKR</td>
        <td>16,000 + LKR</td>
    </tr>
    <tr>
        <td>Neck</td>
        <td>4,500 LKR</td>
        <td>9,000 LKR</td>
        <td>14,000 + LKR</td>
    </tr>
 
  </table>
  <div class="tatoo-item">
      <h3 >Custom Design</h3>
      <p>Starting from 7,000 LKR (final price depends on size & detail)</p>
  </div>
    </section>
    <section class="our-work" id="our-work">
      <h2>Our Work</h2> 
      <div class="photo-gallery">
        <div class="gallery-item">
          <img src="./resources/images/ourWork/img1.jpg" alt="galleryImage">
        </div>
        <div class="gallery-item">
          <img src="./resources/images/ourWork/img2.jpg" alt="galleryImage">
        </div>
        <div class="gallery-item">
          <img src="./resources/images/ourWork/img3.jpg" alt="galleryImage">
        </div>
        <div class="gallery-item">
          <img src="./resources/images/ourWork/img4.jpg" alt="galleryImage">
        </div>
        <div class="gallery-item">
          <img src="./resources/images/ourWork/img5.jpg" alt="galleryImage">
        </div>
        <div class="gallery-item">
          <img src="./resources/images/ourWork/img6.jpg" alt="galleryImage">
        </div>
        <div class="gallery-item">
          <img src="./resources/images/ourWork/img7.jpg" alt="galleryImage">
        </div>
        <div class="gallery-item">
          <img src="./resources/images/ourWork/img8.jpg" alt="galleryImage">
        </div>
        <div class="gallery-item">
          <img src="./resources/images/ourWork/img9.jpg" alt="galleryImage">
        </div>
        <div class="gallery-item">
          <img src="./resources/images/ourWork/img10.jpg" alt="galleryImage">
        </div>
      </div>
    </section>


<?php
  include "./includes/footer.php";
 ?>
    <script src="./resources/js/header.js"></script>
</body>
</html>