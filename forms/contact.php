<?php

require("PHPMailer/src/PHPMailer.php");
require("PHPMailer/src/SMTP.php");
require("PHPMailer/src/Exception.php");

use PHPMailer\PHPMailer\PHPMailer;

// Function to verify the reCAPTCHA response
function verifyRecaptcha($response) {
    $secretKey = '6LebvdMpAAAAADipY3AePOrP6KtZpuGKmqaNXUMe'; // Replace with your actual secret key
    $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $secretKey,
        'response' => $response
    ];
    
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'content' => http_build_query($data)
        ]
    ];
    
    $context = stream_context_create($options);
    $verify = file_get_contents($verifyUrl, false, $context);
    $captchaSuccess = json_decode($verify);
    
    return $captchaSuccess->success;
}

$mail = new PHPMailer(true); // Passing 'true' enables exceptions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verify the reCAPTCHA response
    $recaptchaResponse = $_POST['g-recaptcha-response'];
    $recaptchaVerified = verifyRecaptcha($recaptchaResponse);

    if (!$recaptchaVerified) {
        // If reCAPTCHA verification fails, return an error message
        echo "CAPTCHA verification failed.";
        exit();
    }

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
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = $subject; // Using subject from form
    $mail->Body = $message;

    try {
        // Attempt to send the email
        $mail->send();
        // If the email is sent successfully, echo the success message
        echo "OK";
    } catch (Exception $e) {
        // If there's an error sending the email, echo an error message
        echo "Sorry, there was a problem sending your message. Please try again later.";
    }
}
?>
