<?php
    /**
     * Created by User: gurjot
     */

    require '../vendor/autoload.php';

    function sendMail($email = null, $subject = null, $message = null, $headers = null)
    {
        $mail = new \PHPMailer\PHPMailer\PHPMailer();

        //Server settings
        $mail->SMTPDebug = 2;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host       = 'https://loginvalidation.work:8890';  // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'user@example.com';                     // SMTP username
        $mail->Password   = 'secret';                               // SMTP password
        $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 2525;                                    // TCP port to connect to

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = $message;

        if (!$mail->send()) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }