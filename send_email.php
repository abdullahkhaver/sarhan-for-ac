<?php
// Include PHPMailer files
require 'lib/phpmailer/src/PHPMailer.php';
require 'lib/phpmailer/src/Exception.php';
require 'lib/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Check if any required field is empty
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        // Redirect to error page if form fields are not filled
        header("Location: error.html");
        exit;
    }

    // Instantiate PHPMailer and enable exceptions
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sarhanforac@gmail.com'; // Your Gmail address
        $mail->Password = 'xdya ippc agfb gutc'; // Your Gmail app password or regular password if less secure apps are enabled
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom('sarhanforac@gmail.com', 'SNSAT');
        $mail->addAddress('sarhanforac@gmail.com'); // Add a recipient

        // Content
        $mail->isHTML(false); // Set email format to plain text
        $mail->Subject = "New Contact Form Submission: $subject";
        $mail->Body = "Name: $name\nEmail: $email\nMessage:\n$message";

        // Send email to sarhanforac@gmail.com
        $mail->send();

        // Email to user (confirmation)
        $user_subject = "Confirmation of Your Message to Sarhan Refrigeration and Air Conditioning";
        $user_body = "شكرا لك على الاتصال 💐
صيانة التبريد والتكييف أجهزة المنزلية
واسمحوا لنا أن نعرف كيف يمكننا مساعدتك
Thank you for contacting 💐
Please let us know how we can help you.\n\nBest regards,\nThe SNSAT Team";
        $mail->clearAddresses(); // Clear previous recipient
        $mail->addAddress($email); // Add user's email
        $mail->Subject = $user_subject;
        $mail->Body = $user_body;
        $mail->send();

        // Redirect to confirmation page
        header("Location: confirmation.html");
        exit;
    } catch (Exception $e) {
        // Redirect to error page
        header("Location: error.html");
        exit;
    }
} else {
    // Redirect to error page if request method is not POST
    header("Location: error.html");
    exit;
}
?>
