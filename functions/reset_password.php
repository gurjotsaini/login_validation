<?php
    /**
     * Created by User: gurjot
     */

    function resetPassword() {
        if (isset($_COOKIE['temp_access_code'])) {
            if ( isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token'] ) {
                if ( isset($_GET['email']) && isset($_GET['code']) ) {
                    
                }
            }
        } else {
            setMessage("<p class='bg-danger text-center'>Sorry, session expired.</p>");
            redirect("recover.php");
        }
    }