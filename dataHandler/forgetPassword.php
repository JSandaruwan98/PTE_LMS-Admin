<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Include PHPMailer library

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];

    // Generate a random token for the password reset link
    $resetToken = bin2hex(random_bytes(32));

    // Send a password reset email
    $mail = new PHPMailer(true);
    
    // SMTP Configuration
    $mail->IsSMTP();
    $mail->Host = 'smtp.gmail.com'; // Your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'niwanthukamala@gmail.com';
    $mail->Password = 'ypunlhxevtmjgskk';
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPAutoTLS = false;
    $mail->Port = 465; // Adjust the port as needed

    $mail->setFrom('niwanthukamala@gmail.com', 'Your Name');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Password Reset Request';
    $mail->Body = '
                    Dear Kamal,<br><br>

                    We received a request to reset your password for your account. To 
                    create a new password, please follow the steps bellow:<br><br>
                    
                    If the button above doesn\'t work, you can also copy and paste the following link into your browser\'s address bar:
                    <br><br>
                    <a href="http://localhost:3000/resetPassword.html?Token='.$resetToken.'">Reset Password Link</a><br><br>

                    Once you\'ve clicked the link or pasted it into your browser, you will be directed to a secure page where you can create a new password for your account. Please make sure your new password meets our security requirements:
                    
                    <ul>
                    <li>At least 8 characters long</li>
                    <li>Contains at least one uppercase letter</li>
                    <li>Contains at least one lowercase letter</li>
                    <li>Contains at least one number</li>
                    <li>May contain special characters</li>
                    </ul><br><br>
                    
                    After you\'ve successfully reset your password, you can log in to your account using your new credentials on our website or app.<br><br>
                    
                    If you didn\'t request a password reset, please contact our support team immediately at  support@email.com or 092XXXXXXXXXXX.<br><br>
                    
                    <b>Note:</b> This link will expire in [Expiration Time], so make sure to reset your password as soon as possible.<br><br>
                    
                    Thank you for using PTE LMS Dashboard!';

    try {
        $mail->send();
        echo 'Password reset email sent! Check your inbox.';
    } catch (Exception $e) {
        echo 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
}
?>
