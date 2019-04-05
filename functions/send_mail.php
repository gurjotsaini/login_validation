<?php
    /**
     * Created by User: gurjot
     */

    require '../vendor/autoload.php';

    function sendMail($email = null, $subject = null, $message = null, $headers = null)
    {
        $mail = new \PHPMailer\PHPMailer\PHPMailer();

        //Server settings
        $mail->SMTPDebug = 2;                                                   // Enable verbose debug output
        $mail->isSMTP();                                                        // Set mailer to use SMTP
        $mail->Host       = \App\Core\Config\Config::SMTP_HOST;                 // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                                               // Enable SMTP authentication
        $mail->Username   = \App\Core\Config\Config::SMTP_USERNAME;             // SMTP username
        $mail->Password   = \App\Core\Config\Config::SMTP_PASSWORD;             // SMTP password
        $mail->SMTPSecure = \App\Core\Config\Config::SMTP_ENCRYPTION;           // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = \App\Core\Config\Config::SMTP_PORT;                 // TCP port to connect to

        // Content
        $mail->isHTML(true);                                              // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = $message;

        if (!$mail->send()) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }