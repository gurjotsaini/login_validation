<?php
    /**
     * Created by User: gurjot
     */

    function validateRegistration() {
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

            // Check if the field is empty or not
            if (empty($firstName)) {
                $errors[] = "'First Name' cannot be left empty" . "<br />";
            }
            if (empty($lastName)) {
                $errors[] = "'Last Name' cannot be left empty" . "<br />";
            }
            if (empty($username)) {
                $errors[] = "'Username' cannot be left empty" . "<br />";
            }
            if (empty($email)) {
                $errors[] = "'Email' cannot be left empty" . "<br />";
            }
            if (empty($password)) {
                $errors[] = "'Password' cannot be left empty" . "<br />";
            }
            if (empty($confirmPassword)) {
                $errors[] = "'Confirm Password' cannot be left empty" . "<br />";
            }

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
            if (emailExists($email)) {
                $errors[] = "Sorry, Email is already registered!" . "<br />";
            }

            // Check whether Username exists or not
            if (usernameExists($username)) {
                $errors[] = "Sorry, Username is already taken!" . "<br />";
            }

            if (!empty($errors)) {
                echo '<div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="alert-heading">Warning!</h4>
                            ';

                foreach ($errors as $error) {
                    echo $error;
                }

                echo '</div>';
            } else {
                 if (registerUser($firstName, $lastName, $username, $email, $password)) {
                     setMessage("<p class='bg-success text-center'>Please check your email or span folder for activation link</p>");
                     redirect("index.php");
                 } else {
                     setMessage("<p class='bg-danger text-center'>Sorry! We couldn't register the user.</p>");
                     redirect("index.php");
                 }
            }
        }
    } // validateRegistration();

function registerUser($firstName, $lastName, $username, $email, $password) {
    $firstName  = escape($firstName);
    $lastName   = escape($lastName);
    $username   = escape($username);
    $email      = escape($email);
    $password   = escape($password);

    if (emailExists($email)) {
        return false;
    } elseif (usernameExists($username)) {
        return false;
    } else {
        $password = md5($password);
        $validationCode = md5($username . microtime());

        $sql = "INSERT INTO users(first_name, last_name, username, email, password, validation_code, active)";
        $sql .= " VALUES('$firstName', '$lastName', '$username', '$email', '$password', '$validationCode', 0)";

        $result = query($sql);
        confirmQuery($result);

        $subject = "Activate Account";
        $message = "Please click the link below to activate your account
        https://loginvalidation.work:8890/activate.php?email=$email&code=$validationCode";
        $headers = "From: noreply@website.com";

        sendMail($email, $subject, $message, $headers);

        return true;
    }
} // registerUser();

function sendMail($email, $subject, $message, $headers)
{
    return mail($email, $subject, $message, $headers);
}

function validateLogin() {
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $email          = clean($_POST['email']);
        $password       = clean($_POST['password']);
        $rememberMe     = isset($_POST['remember']);
    }

    if (empty($email)) {
        $errors[] = "Email field cannot be left empty. <br />";
    }

    if (empty($password)) {
        $errors[] = "Password field cannot be left empty. <br />";
    }

    if (!empty($errors)) {
        echo '<div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="alert-heading">Warning!</h4>
             ';

        foreach ($errors as $error) {
            echo $error;
        }

        echo '</div>';
    } else {
        if (loginUser($email, $password, $rememberMe)) {
            redirect("admin.php");
        } else {
            echo validationErrors("Your credentials are not correct");
        }
    }
}

function validateResetCode() {
    if (isset($_COOKIE['temp_access_code'])) {
        if (isset($_GET['email']) && isset($_GET['code'])) {
            redirect("index.php");
        } elseif (empty($_GET['email']) || empty($_GET['code'])) {
            redirect("index.php");
        } else {
            if (isset($_POST['code'])) {
                $email          = clean($_GET['email']);
                $validationCode = clean($_POST['code']);

                $sql = "SELECT id FROM users WHERE validation_code = '". escape($validationCode) ."' AND email = '". escape($email) ."'";
                $result = query($sql);
                confirmQuery($result);

                if (rowCount($result) == 1) {
                    redirect("reset.php");
                } else {
                    echo validationErrors("Sorry! Wrong validation code.");
                }
            }
        }
    } else {
        setMessage("<p class='bg-danger text-center'>Sorry, validation cookie expired.</p>");
        redirect("recover.php");
    }
}