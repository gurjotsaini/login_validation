<?php
    /**
     * Created by User: gurjot
     */

    function loggedIn() {
        if (isset($_SESSION['email']) || isset($_COOKIE['email'])) {
            return true;
        } else {
            return false;
        }
    }