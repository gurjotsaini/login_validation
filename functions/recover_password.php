<?php
    /**
     * Created by User: gurjot
     */

    function recoverPassword() {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
                $email = clean($_POST['email']);
                if (emailExists($email)) {
                    $resetCode = md5($email . microtime());

                    setcookie('temp_access_code', $resetCode, time() + 300);

                    $sql = "UPDATE users SET validation_code = '".escape($resetCode)."' WHERE email = '".escape($email)."' ";
                    $result = query($sql);
                    confirmQuery($result);

                    $subject = "Password reset code";
                    $message = "Please click the link below to reset your password. <br />
                                Here is your reset code: {$resetCode} <br />
                                <a class='btn btn-outline-primary' href='https://loginvalidation.work:8890/code.php?email=$email&code=$resetCode'>Click Here</a>";
                    $headers = "From: noreply@website.com";

                    if (sendMail($email, $subject, $message, $headers)) {
                        redirect("code.php");
                    } else {
                        echo validationErrors("Email couldn't be sent.");
                    }
                } else {
                    echo validationErrors("This email does not exists.");
                }
            } else {
                redirect("index.php");
            }
        }
    }