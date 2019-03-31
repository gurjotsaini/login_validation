<?php
    /**
     * Created by User: gurjot
     */

    function validateUserRegistration() {
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

            if (empty($firstName)) {
                $errors[] = "First Name cannot be empty";
            }

            if (empty($lastName)) {
                $errors[] = "Last Name cannot be empty";
            }

            if (empty($email)) {
                $errors[] = "Email cannot be empty";
            }

            if (strlen($firstName) < $min) {
                $errors[] = "First Name cannot be less than {$min} characters.";
            }

            if (strlen($lastName) < $min) {
                $errors[] = "Last Name cannot be less than {$min} characters.";
            }

            if (strlen($firstName) > $max) {
                $errors[] = "First Name cannot be more than {$max} characters.";
            }

            if (strlen($lastName) > $max) {
                $errors[] = "Last Name cannot be more than {$max} characters.";
            }

            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo '<div class="alert alert-dark alert-dismissible" role="alert">
                            <strong>Warning!</strong> ' . $error .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                         </div>';
//$message = <<<DELIMITER
//<div class="alert alert-danger alert-dismissible" role="alert">
//    <strong>Warning!</strong> $error
//    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
//        <span aria-hidden="true">&times;</span>
//    </button>
//</div>
//DELIMITER;
//echo $message;
                }
            }
        }
    }