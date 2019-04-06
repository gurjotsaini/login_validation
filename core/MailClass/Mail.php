<?php
    /**
     * Created by User: gurjot
     */

    namespace App\Core\MailClass;

    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\PHPMailer;
    use App\Core\AppConfigs;

    class Mail
    {
        /**
         * @param null $email
         * @param null $subject
         * @param null $message
         * @param null $headers
         */
        public static function sendMail( $email = null, $subject = null, $message = null, $headers = null) {
            $mail = new PHPMailer();
            $smtpConfig = AppConfigs\Configs::getSmtpConfig();

            //Server settings
            $mail->SMTPDebug = 2;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host       = $smtpConfig['smtp_host'];               // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = $smtpConfig['smtp_username'];           // SMTP username
            $mail->Password   = $smtpConfig['smtp_password'];           // SMTP password
            $mail->SMTPSecure = $smtpConfig['smtp_encryption'];         // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = $smtpConfig['smtp_port'];               // TCP port to connect to

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = $message;

            try {
                if ( !$mail->send() ) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } catch ( Exception $e ) {
            }
        }
    }