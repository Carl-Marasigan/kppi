<?php
session_start();

// Generate a random captcha code
$captchaCode = substr(md5(rand()), 0, 6);

// Store the captcha code in session
$_SESSION['captcha'] = $captchaCode;

// Create an image with the captcha text
$captchaImage = imagecreate(120, 40);
$backgroundColor = imagecolorallocate($captchaImage, 255, 255, 255);
$textColor = imagecolorallocate($captchaImage, 0, 0, 0);
imagestring($captchaImage, 5, 25, 10, $captchaCode, $textColor);

// Output the captcha image
header('Content-type: image/png');
imagepng($captchaImage);
imagedestroy($captchaImage);
?>

