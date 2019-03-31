<?php
    /**
     * Created by User: gurjot
     */

    function validateRegistration() {
        $errors = [];
        $min    = 3;
        $max    = 20;

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $firstName          = clean($_POST['first_name']);
            $lastName           = clean($_POST['last_name']);
            $username           = clean($_POST['username']);
            $email              = clean($_POST['email']);
            $password           = clean($_POST['password']);
            $confirmPassword    = clean($_POST['confirm_password']);

            // Check if the field is empty or not
            $errors[] = isEmpty($firstName,"First Name");
            $errors[] = isEmpty($lastName,"Last Name");
            $errors[] = isEmpty($username,"Username");
            $errors[] = isEmpty($email,"Email");
            $errors[] = isEmpty($password,"Password");
            $errors[] = isEmpty($confirmPassword,"Confirm Password");

            // Check minimum length of the value
            $errors[] = isMinimum($firstName, "First Name", $min);
            $errors[] = isMinimum($lastName, "Last Name", $min);
            $errors[] = isMinimum($username, "Username", $min);
            $errors[] = isMinimum($password, "Password", $min);

            // Check maximum length of the value
            $errors[] = isMaximum($firstName, "First Name", $max);
            $errors[] = isMaximum($lastName, "Last Name", $max);
            $errors[] = isMaximum($username, "Username", $max);
            $errors[] = isMaximum($password, "Password", $max);

            if ($password !== $confirmPassword) {
                $errors[] = "Your password fields don't match." . "<br />";
            }

            if (emailExists($email)) {
                $errors[] = "Sorry, Email is already registered!" . "<br />";
            }

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
                    echo "USER REGISTERED!";
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

        return true;
    }
}