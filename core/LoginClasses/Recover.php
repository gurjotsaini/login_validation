<?php
    /**
     * Created by User: gurjot
     */

    namespace App\Core\LoginClasses;

    use App\Core\DatabaseClass\DbHelperMethods;
    use App\Core\DatabaseClass\DbQueries;
    use App\Core\AppConfigs\Configs;
    use App\Core\MailClass\Mail;
    use App\Core\SessionClasses\Session;
    use App\Core\HtmlClasses\FormSanitizations;
    use App\Core\HtmlClasses\DisplayErrors;

    class Recover
    {
        /**
         * Password recover method
         */
        public function recoverPassword() {
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                if (isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
                    $formFunctions      = new FormSanitizations();
                    $sessionClass       = new Session();
                    $validationClass    = new DisplayErrors();
                    $config             = Configs::getSiteUrl();

                    $email = $formFunctions->clean($_POST['email']);

                    if (DbQueries::emailExists($email)) {
                        $validationCode = md5($email . microtime());

                        setcookie('temp_access_code', $validationCode, time() + 900);

                        $sql = "UPDATE users SET validation_code = '" . DbHelperMethods::escape($validationCode) . "' WHERE email = '" . DbHelperMethods::escape($email) . "'";
                        $result = DbHelperMethods::query($sql);
                        DbHelperMethods::confirmQuery($result);

                        $subject = "Password reset code";
                        $message = "Please click the link below to reset your password. <br />
                                Here is your reset code: {$validationCode} <br />
                                <a class='btn btn-outline-primary' href=\"". $config['development_url'] ."/code.php?email=$email&code=$validationCode\">Click Here</a>";
                        $headers = "From: noreply@website.com";

                        Mail::sendMail($email, $subject, $message, $headers);

                        $sessionClass->setMessage("<p class='bg-success text-center'>Please check your email for password reset code.</p>");
                        redirect("index.php");
                    } else {
                        echo $validationClass->validationErrors("This email does not exists.");
                    }
                } else {
                    redirect("index.php");
                }

                if (isset($_POST['cancel_submit'])) {
                    redirect("login.php");
                }
            }
        } // recoverPassword()

        /**
         * Reset code validation method
         */
        public function validateResetCode() {
            if (isset($_COOKIE['temp_access_code'])) {
                if (isset($_GET['email']) && isset($_GET['code'])) {
                    redirect("index.php");
                } elseif (empty($_GET['email']) || empty($_GET['code'])) {
                    redirect("index.php");
                } else {
                    $formFunctions      = new FormSanitizations();
                    $validationClass    = new DisplayErrors();

                    if (isset($_POST['code'])) {
                        $email          = $formFunctions->clean($_GET['email']);
                        $validationCode = $formFunctions->clean($_POST['code']);

                        $sql = "SELECT id FROM users WHERE validation_code = '". DbHelperMethods::escape($validationCode) ."' AND email = '". DbHelperMethods::escape($email) ."'";
                        $result = DbHelperMethods::query($sql);
                        DbHelperMethods::confirmQuery($result);

                        if (DbHelperMethods::rowCount($result) == 1) {
                            setcookie('temp_access_code', $validationCode, time() + 300);
                            redirect("reset.php?email=$email&code=$validationCode");
                        } else {
                            echo $validationClass->validationErrors("Sorry! Wrong validation code.");
                        }
                    }
                }
            } else {
                $sessionClass       = new Session();

                $sessionClass->setMessage("<p class='bg-danger text-center'>Sorry, validation cookie expired.</p>");
                redirect("recover.php");
            }
        } // validateResetCode()

        /**
         * Resets password
         */
        public function resetPassword() {
            $sessionClass       = new Session();
            $validationClass    = new DisplayErrors();

            if (isset($_COOKIE['temp_access_code'])) {
                if ( isset($_GET['email']) && isset($_GET['code']) ) {
                    if ( isset($_SESSION['token']) && isset($_POST['token'])) {
                        if ($_POST['token'] === $_SESSION['token']) {
                            if ($_POST['password'] === $_POST['confirm_password']) {
                                $updatedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT, array('cost'=>12));

                                $sql = "UPDATE users SET password = '". DbHelperMethods::escape($updatedPassword) ."', validation_code = 0 WHERE email = '". DbHelperMethods::escape($_GET['email']) ."'";
                                $result = DbHelperMethods::query($sql);
                                DbHelperMethods::confirmQuery($result);

                                $sessionClass->setMessage("<p class='bg-success text-center'>Your password has been updated. Please Login.</p>");
                                redirect("login.php");
                            } else {
                                echo $validationClass->validationErrors("Password fields don't match.");
                            }
                        }
                    }
                }
            } else {
                $sessionClass->setMessage("<p class='bg-danger text-center'>Sorry, session expired.</p>");
                redirect("recover.php");
            }
        } // resetPassword()
    }