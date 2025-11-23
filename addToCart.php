<?php
  session_start();
  include "./includes/dbConn.php";

   if(!isset($_SESSION['userID'])){
      header("Location: login.php");
      exit();
    }

  $url = null;
  $successUrl = null;
  $LastPage = explode("/",$_SERVER['HTTP_REFERER']);
  $LastPageName = $LastPage[count($LastPage)-1];
  if($LastPageName !== ""){
     $url = "./".$LastPageName;
  }
  else{
     $url = "./store.php";
  }

  if($LastPageName !== ""){
    if($LastPageName === "store.php"){
      $successUrl = "./store.php";
    }
    else{
      $successUrl = "./user.php#cart";
    }  
  }
  else{
     $successUrl = "./user.php#cart";
  }

  
 


  if(isset($_GET['productID'])){
    $userID = mysqli_real_escape_string($conn, $_SESSION['userID']);
    $productID = mysqli_real_escape_string($conn, $_GET['productID']);

    if($productID === "outOfStock"){
        echo'<script>
            alert("This product is out of stock");
            window.location.href = "'.$url.'";
            </script>';
        exit();
    }

    $getProductQuery = "SELECT productID,productName,price FROM products WHERE productID ='$productID'";
    $getProductResult = mysqli_query($conn, $getProductQuery);

    if(mysqli_num_rows($getProductResult) === 1){

        $product = mysqli_fetch_assoc($getProductResult);
        $productName = $product['productName'];
        $price = $product['price'];

        $getCartQuery = "SELECT id,user_id FROM cart WHERE user_id ='$userID'";
        $getCartResult = mysqli_query($conn, $getCartQuery);

      if(mysqli_num_rows($getCartResult) === 1){
          $cartData =  mysqli_fetch_assoc($getCartResult);
          $cartID = $cartData['id'];
        
          
          $getCartItemQuery = "SELECT cart_id,product_id,quantity FROM cart_item WHERE cart_id ='$cartID' AND product_id ='$productID'";
          $getCartItemResult = mysqli_query($conn, $getCartItemQuery);
  
          if(mysqli_num_rows($getCartItemResult) === 1){
              $cartItemData =  mysqli_fetch_assoc($getCartItemResult);
              $quantity = $cartItemData['quantity'];
              $newQty = $quantity + 1;

              $cartItemUpdateQuery = "UPDATE cart_item SET quantity = '$newQty' WHERE cart_id ='$cartID' AND product_id ='$productID'";

              if(mysqli_query($conn, $cartItemUpdateQuery)){
                     $_SESSION['toast_message'] = "Product added to cart.";
                     header("Location: ".$successUrl);
                     exit();
              }
              else{
                     $_SESSION['toast_message'] = "Could not add the product to cart";
                     header("Location: ".$url);
                     exit();
              }
          }
          else{
            $addProductQuery = "INSERT INTO cart_item(cart_id, product_id, quantity, price) VALUES('$cartID', '$productID', 1, '$price')";

             if(mysqli_query($conn, $addProductQuery)){
                    $_SESSION['toast_message'] = "Product added to cart.";
                     header("Location: ".$successUrl);
                     exit();
              }
              else{
                 $_SESSION['toast_message'] = "Could not add the product to cart";
                 header("Location: ".$url);
                 exit();
              }
          }
         
    }
    else{
         $creatCartQuery = "INSERT INTO cart(user_id) VALUES('$userID')";

         if(mysqli_query($conn, $creatCartQuery)){
             
             $lastCartId = mysqli_insert_id($conn);
             $addCartProductQuery = "INSERT INTO cart_item(cart_id, product_id, quantity, price) VALUES('$lastCartId', '$productID', 1, '$price')";

             if(mysqli_query($conn,  $addCartProductQuery)){
                     $_SESSION['toast_message'] = "Product added to cart.";
                     header("Location: ".$successUrl);
                     exit();
              }
              else{
                 $_SESSION['toast_message'] = "Could not add the product to cart";
                 header("Location: ".$url);
                 exit();
              }

         }
        
    }

 
    }
    else{
         $_SESSION['toast_message'] = "Could not add the product to cart";
         header("Location: ".$url);
         exit();
    }

    
  }

  
  
   
   
   

 ?>



 