
<?php
  session_start();
  $title = "Complete Your Payment | InkStyle by Dinu";
  $cssFile = "checkout.css";

   if(!isset($_SESSION['userID'])){
      header("Location: login.php");
      exit();
    }



  include "./includes/header.php";
  include "./includes/dbConn.php";

  $userID = $_SESSION['userID'];

  $query = "
    SELECT SUM(ci.quantity * ci.price) AS total
    FROM cart_item ci
    INNER JOIN cart c ON ci.cart_id = c.id
    WHERE c.user_id = '$userID'
";

   $grandTotal = 0;
   $result = mysqli_query($conn, $query);
   if(mysqli_num_rows($result) === 1){
    $data = mysqli_fetch_assoc( $result );
    $grandTotal = floatval($data['total']);
   }


   $USDTotal = round($grandTotal/300, 2);
 ?>
 <script>
  const paymentTotal = "<?php echo $USDTotal ?>";
 </script>

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
          value: paymentTotal
        }
      }]
    });
  },
  onApprove: function(data, actions) {
    return actions.order.capture().then(function(details) {
        fetch("createOrder.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: `paymentID=${details.id}&payerEmail=${details.payer.email_address}`
        }).then(() => {
          window.location.href = "orderSuccess.php";
        });
    });
  }
}).render('#paypal-button-container');
</script>
 <script src="./resources/js/header.js"></script>
  </body>
</html>