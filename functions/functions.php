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