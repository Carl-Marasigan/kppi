<?php

require("PHPMailer/src/PHPMailer.php");
require("PHPMailer/src/SMTP.php");
require("PHPMailer/src/Exception.php");

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer(true); // Passing 'true' enables exceptions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true); // Pass true for exceptions

    // Set up SMTP
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "kpgrptest01@gmail.com"; // Your Gmail address
    $mail->Password = "hrmxstkzinnosolj"; // Your Gmail password
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    // Set up sender and recipient
    $mail->setFrom("jcringtest@gmail.com", "KanePackage Philippine");
    $mail->addAddress("capunokristine8@gmail.com"); // Recipient email
    // Set email content
    $mail->isHTML(false);
    $mail->Subject = $subject; // Using subject from form
    $mail->Body = "Name: $name\nEmail: $email\nSubject: $subject\nMessage: $message";
    try {
        // Attempt to send the email
        $mail->send();
        // If the email is sent successfully, echo the success message
        echo "OK"; // This response is expected by your JavaScript code
    } catch (Exception $e) {
        // If there's an error sending the email, echo an error message
        echo "Sorry, there was a problem sending your message. Please try again later.";
    }
    
}
?>
