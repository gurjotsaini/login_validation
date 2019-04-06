<?php
    /**
     * Created by User: gurjot
     */

    namespace App\Core\MailClass;

    use PHPMailer\PHPMailer\PHPMailer;
    use App\Core\Config;

    class Mail
    {
        private static function sendMail($email = null, $subject = null, $message = null, $headers = null) {
            $mail = new PHPMailer();

            //Server settings
            $mail->SMTPDebug = 2;                                  // Enable verbose debug output
            $mail->isSMTP();                                       // Set mailer to use SMTP
            $mail->Host       = Config::SMTP_HOST;                 // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                              // Enable SMTP authentication
            $mail->Username   = Config::SMTP_USERNAME;             // SMTP username
            $mail->Password   = Config::SMTP_PASSWORD;             // SMTP password
            $mail->SMTPSecure = Config::SMTP_ENCRYPTION;           // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = Config::SMTP_PORT;                 // TCP port to connect to

            // Content
            $mail->isHTML(true);                             // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = $message;

            if (!$mail->send()) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }