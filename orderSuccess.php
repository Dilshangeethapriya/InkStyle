<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./resources/images/inkstyle_favicon.ico">
    <title>Order Successful</title>
    <style>
        /* Base Colors */
        :root {
          
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: rgb(0, 20, 17);
        }

        #success-section {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .success-container {
            width: 100%;
            max-width: 400px;
        }

        .success-card {
            background-color: #113333;
            color: #FFFFFF;
            padding: 45px 30px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid #00a8a8;
        }

        .success-card h2 {
            color: #FFD700;
            font-size: 1.75rem;
            margin-bottom: 30px;
            font-weight: 700;
        }

        .success-card a {
            display: inline-block;
            background-color: #00a8a8;
            color: #FFFFFF;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .success-card a:hover {
            background-color: #008f8f;
            transform: translateY(-2px);

        }

   
    </style>
</head>
<body>
<section id="success-section">
    <div class="success-container">
        <div class="success-card">
            <h2>Your order was placed successfully!</h2>
            <a href="./user.php#orders">View My Orders</a>
        </div> 
    </div>
</section>
</body>
</html>