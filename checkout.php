
<?php
  session_start();
  $title = "Complete Your Payment | InkStyle by Dinu";
  $cssFile = "checkout.css";

  include "./includes/header.php";
 ?>

    <section class="payment-section">
          <div class="payment-box">
            <h2>Complete Your Payment</h2>
            <div id="paypal-button-container"></div>
          </div>
   </section>


<?php
  include "./includes/footer.php";
?>
<script src="https://www.paypal.com/sdk/js?client-id=AfDAljXzM4itdDj4R0lQgNi6nXALkJGW8rpcd8UstqApmyvv4SSG-wv_cGiCKwTOANf8EaSsKVRflDox&currency=USD"></script>
<script>
paypal.Buttons({
  createOrder: function(data, actions) {
    return actions.order.create({
      purchase_units: [{
        amount: {
          value: '25.00' // Example price
        }
      }]
    });
  },
  onApprove: function(data, actions) {
    return actions.order.capture().then(function(details) {
      alert('Transaction completed by ' + details.payer.name.given_name);
    });
  }
}).render('#paypal-button-container');
</script>
 <script src="./resources/js/header.js"></script>
  </body>
</html>