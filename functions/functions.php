<?php
    /**
     * Created by User: gurjot
     */

    function clean($string) {
        return htmlentities($string);
    }

    function redirect($location) {
        return header("Location: {$location}");
    }

    function setMessage($message) {
        if (!empty($message)) {
            $_SESSION['message'] = $message;
        } else {
            $message = "";
        }
    }

    function displayMessage() {
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
    }

    function tokenGenerator() {
        $token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));

        return $token;
    }

    function isMinimum($inputName, $placeholderName, $minimumValue) {
        $errors = [];

        if (strlen($inputName) < $minimumValue) {
            $errors[] = "'{$placeholderName}' cannot be less than {$minimumValue} characters." . "<br />";
        }

        if (!empty($errors)) {
            foreach ( $errors as $error ) {
                return $error;
            }
        }
    }

    function isMaximum($inputName, $placeholderName, $maximumValue) {
        $errors = [];

        if (strlen($inputName) > $maximumValue) {
            $errors[] = "'{$placeholderName}' cannot be less than {$maximumValue} characters." . "<br />";
        }

        if (!empty($errors)) {
            foreach ( $errors as $error ) {
                return $error;
            }
        }
    }

    function isEmpty($inputName, $inputPlaceholder) {
        $errors = [];

        if (empty($inputName)) {
            $errors[] = "'{$inputPlaceholder}' cannot be empty" . "<br />";
        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
                return $error;
            }
        }
    }

    function validationErrors($errorMessage) {
        $errorMessage = <<<DELIMITER
<div class="alert alert-danger alert-dismissible" role="alert">
   <strong>Warning!</strong> $errorMessage
   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">&times;</span>
   </button>
</div>
DELIMITER;
        return $errorMessage;
    }

    function emailExists($email) {
        $sql = "SELECT id FROM users WHERE  email = '$email'";
        $result = query($sql);

        if (rowCount($result) == 1) {
            return true;
        } else {
            return false;
        }
    }

    function usernameExists($username) {
        $sql = "SELECT id FROM users WHERE username = '$username'";
        $result = query($sql);

        if (rowCount($result) == 1) {
            return true;
        } else {
            return false;
        }
    }