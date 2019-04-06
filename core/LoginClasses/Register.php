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

    class Register
    {
        public function validateRegistration() {
            $dbQueries      = new DbQueries();
            $sessionClass   = new Session();

            $errors         = [];
            $minimumValue   = 3;
            $maximumValue   = 20;

            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $firstName          = clean($_POST['first_name']);
                $lastName           = clean($_POST['last_name']);
                $username           = clean($_POST['username']);
                $email              = clean($_POST['email']);
                $password           = clean($_POST['password']);
                $confirmPassword    = clean($_POST['confirm_password']);

                // Check minimum length of the value
                if (strlen($firstName) < $minimumValue) {
                    $errors[] = "'First Name' cannot be less than {$minimumValue} characters." . "<br />";
                }
                if (strlen($lastName) < $minimumValue) {
                    $errors[] = "'Last Name' cannot be less than {$minimumValue} characters." . "<br />";
                }
                if (strlen($username) < $minimumValue) {
                    $errors[] = "'Username' cannot be less than {$minimumValue} characters." . "<br />";
                }
                if (strlen($password) < $minimumValue) {
                    $errors[] = "'Password' cannot be less than {$minimumValue} characters." . "<br />";
                }

                // Check maximum length of the value
                if (strlen($firstName) > $maximumValue) {
                    $errors[] = "'First Name' cannot be less than {$maximumValue} characters." . "<br />";
                }
                if (strlen($lastName) > $maximumValue) {
                    $errors[] = "'Last Name' cannot be less than {$maximumValue} characters." . "<br />";
                }
                if (strlen($username) > $maximumValue) {
                    $errors[] = "'Username' cannot be less than {$maximumValue} characters." . "<br />";
                }
                if (strlen($password) > $maximumValue) {
                    $errors[] = "'Password' cannot be less than {$maximumValue} characters." . "<br />";
                }

                // Check if Password field matches with Confirm Password field
                if ($password !== $confirmPassword) {
                    $errors[] = "Your password fields don't match." . "<br />";
                }

                // Check whether Email exists or not
                if ($dbQueries->emailExists("users", $email)) {
                    $errors[] = "Sorry, Email is already registered!" . "<br />";
                }

                // Check whether Username exists or not
                if ($dbQueries->usernameExists("users", $username)) {
                    $errors[] = "Sorry, Username is already taken!" . "<br />";
                }

                if (!empty($errors)) {
                    echo '<div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="alert-heading">Warning!</h4>';

                    foreach ($errors as $error) {
                        echo $error;
                    }

                    echo '</div>';
                } else {
                    if ($this->register($firstName, $lastName, $username, $email, $password)) {
                        $sessionClass->setMessage("<p class='bg-success text-center'>Please check your email or span folder for activation link</p>");
                        redirect("index.php");
                    } else {
                        $sessionClass->setMessage("<p class='bg-danger text-center'>Sorry! We couldn't register the user.</p>");
                        redirect("index.php");
                    }
                }
            }
        } // validateRegistration();

        public function register($firstName, $lastName, $username, $email, $password) {
            $dbQueries  = new DbQueries();
            $config     = Configs::getSiteUrl();

            $firstName  = escape($firstName);
            $lastName   = escape($lastName);
            $username   = escape($username);
            $email      = escape($email);
            $password   = escape($password);

            if ($dbQueries->emailExists("users", $email)) {
                return false;
            } elseif ($dbQueries->usernameExists("users", $username)) {
                return false;
            } else {
                $password = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));
                $validationCode = md5($username . microtime());

                $sql = "INSERT INTO users(first_name, last_name, username, email, password, validation_code, active)";
                $sql .= " VALUES('$firstName', '$lastName', '$username', '$email', '$password', '$validationCode', 0)";

                $result = DbHelperMethods::query($sql);
                DbHelperMethods::confirmQuery($result);

                $subject = "Activate Account";
                $message = "Please click the link below to activate your account
                <a href=\"". $config['development_url'] ."/activate.php?email=$email&code=$validationCode\">Link Here</a>";
                $headers = "From: noreply@website.com";

                Mail::sendMail($email, $subject, $message, $headers);

                return true;
            }
        } // registerUser();
    }