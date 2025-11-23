<?php
session_start();
include "./includes/dbConn.php";

if (!isset($_SESSION['userID'])) {
    exit("Unauthorized");
}

$userID = $_SESSION['userID'];


$cartQuery = "
    SELECT c.id AS cart_id, ci.product_id, ci.quantity, ci.price
    FROM cart_item ci
    INNER JOIN cart c ON ci.cart_id = c.id
    WHERE c.user_id = '$userID'
";

$result = mysqli_query($conn, $cartQuery);

$orderTotal = 0;
$items = [];

if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $subtotal = intval($row['quantity']) * floatval($row['price']);
        $orderTotal += $subtotal;
        $items[] = $row;
    }
}


$addOrderQuery = "INSERT INTO orders (user_id, amount, status, payment_method)
                  VALUES ('$userID', '$orderTotal', 'pending', 'PayPal')";
mysqli_query($conn, $addOrderQuery);


$orderID = mysqli_insert_id($conn);


foreach($items as $item){
    $productID = $item['product_id'];
    $qty = $item['quantity'];
    $price = $item['price'];
    
    $subtotal = intval($qty) * floatval($price);

    $addItemsQuery = "
        INSERT INTO order_items (order_id, product_id, quantity, price, subtotal)
        VALUES ('$orderID', '$productID', '$qty', '$price', '$subtotal')
    ";

    mysqli_query($conn, $addItemsQuery);

    $updateStocksQuery ="UPDATE products SET stock = stock - $qty WHERE productID = '$productID'";
    mysqli_query($conn, $updateStocksQuery);
}

mysqli_query($conn, "DELETE FROM cart_item WHERE cart_id = (SELECT id FROM cart WHERE user_id='$userID')");
mysqli_query($conn, "DELETE FROM cart WHERE user_id='$userID'");

?>
