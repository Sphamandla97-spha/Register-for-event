<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if (isset($_GET['name']) && isset($_GET['email']) && isset($_GET['event_id']) && isset($_GET['unique_code'])) {
    $name = $_GET['name'];
    $email = $_GET['email'];
    $event_id = $_GET['event_id'];
    $unique_code = $_GET['unique_code'];

    sendConfirmationEmail($name, $email, $event_id, $unique_code);
} else {
    echo "Invalid request.";
}

function sendConfirmationEmail($name, $email, $event_id, $unique_code) {
    $baseUrl = "http://localhost/";
    $yesUrl = $baseUrl . "/response.php?code=" . urlencode($unique_code) . "&response=yes";
    $noUrl = $baseUrl . "/response.php?code=" . urlencode($unique_code) . "&response=no";

    $subject = "Event Registration Confirmation";
    $message = "
    <p>Dear $name,</p>
    <p>Thank you for registering for the event. Here are your registration details:</p>
    <p>Name: $name<br>
    Email: $email<br>
    Event ID: $event_id<br>
    Unique Code: $unique_code</p>
    <p>Please let us know if you will attend the event by clicking one of the buttons below:</p>
    <p><a href='$yesUrl' style='display:inline-block;padding:10px 20px;color:#fff;background-color:#28a745;text-decoration:none;border-radius:5px;'>I will attend</a></p>
    <p><a href='$noUrl' style='display:inline-block;padding:10px 20px;color:#fff;background-color:#dc3545;text-decoration:none;border-radius:5px;'>I will not attend</a></p>
    <p>We look forward to your participation.</p>
    <p>Best regards,<br>
    NECT Communication Team</p>
    ";

    $mail = new PHPMailer(true);

    try {
        // Set mailer to use SMTP
        $mail->isSMTP();
        // Enable verbose debug output (SMTP::DEBUG_SERVER for full output)
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = function($str, $level) {
            file_put_contents('smtp.log', gmdate("Y-m-d H:i:s")." ".$level.": ".$str.PHP_EOL, FILE_APPEND);
        };
        // Specify main and backup SMTP servers
        $mail->Host = 'smtp.gmail.com';
        // Enable SMTP authentication
        $mail->SMTPAuth = true;
        // SMTP username
        $mail->Username = getenv('GMAIL_USERNAME'); // Use environment variable
        // SMTP password
        $mail->Password = getenv('GMAIL_PASSWORD'); // Use environment variable
        // Enable TLS encryption, `ssl` also accepted
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        // TCP port to connect to
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('your_email@example.com', 'NECT Communication Team');
        $mail->addAddress($email, $name); // Add a recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        echo 'Confirmation email has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
