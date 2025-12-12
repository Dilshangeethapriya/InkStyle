<?php
include "../includes/dbConn.php";


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit("POST request required");
}

require "../vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
$config = require '../includes/mailConfig.php';


$subject = mysqli_real_escape_string($conn, $_POST['subject'] ?? '');
$body = $_POST['body'] ?? '';
$recipientEmail = mysqli_real_escape_string($conn,$_POST['recipientEmail'] ?? '');
$redirectUrl    = mysqli_real_escape_string($conn,$_POST['redirectUrl'] ?? 'index.php');
$recipientName =  mysqli_real_escape_string($conn,$_POST['recipientName'] ?? '');

if (empty($subject) || empty($body) || empty($recipientEmail) || empty($recipientEmail || empty($recipientName))) {
    exit("Missing required fields.");
}


        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host       = "sandbox.smtp.mailtrap.io";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 2525;
        $mail->Username   = $config['smtpUser'];  
        $mail->Password   = $config['smtpAppPass'];

        $mail->setFrom("hello@inkstylebydinu.lk", "InkStyle By Dinu");
        $mail->addAddress($recipientEmail, $recipientName);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        

        $mail->send(); 

   
header("Location: " . $redirectUrl);
exit();
?>