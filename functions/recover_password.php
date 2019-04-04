<?php
    /**
     * Created by User: gurjot
     */

    function recoverPassword() {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
                $email = clean($_POST['email']);

                if (emailExists($email)) {
                    $validationCode = md5($email . microtime());

                    setcookie('temp_access_code', $validationCode, time() + 900);

                    $sql = "UPDATE users SET validation_code = '" . escape($validationCode) . "' WHERE email = '" . escape($email) . "'";
                    $result = query($sql);
                    confirmQuery($result);

                    $subject = "Password reset code";
                    $message = "Please click the link below to reset your password. <br />
                                Here is your reset code: {$validationCode} <br />
                                <a class='btn btn-outline-primary' href='https://loginvalidation.work:8890/code.php?email=$email&code=$validationCode'>Click Here</a>";
                    $headers = "From: noreply@website.com";

                    if (!sendMail($email, $subject, $message, $headers)) {
                        echo validationErrors("Email couldn't be sent.");
                    }

                    setMessage("<p class='bg-success text-center'>Please check your email for password reset code.</p>");
                    redirect("index.php");
                } else {
                    echo validationErrors("This email does not exists.");
                }
            } else {
                redirect("index.php");
            }
        }
    }