<?php
    /**
     * Created by User: gurjot
     */

    function loggedIn() {
        if (isset($_SESSION['email'])) {
            return true;
        } else {
            return false;
        }
    }