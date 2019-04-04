<?php
    /**
     * Created by User: gurjot
     */

    function resetPassword() {
        if (isset($_COOKIE['temp_access_code'])) {
            if ( isset($_GET['email']) && isset($_GET['code']) ) {
                if ( isset($_SESSION['token']) && isset($_POST['token'])) {
                    if ($_POST['token'] === $_SESSION['token']) {
                        if ($_POST['password'] === $_POST['confirm_password']) {
                            $updatedPassword = md5($_POST['password']);

                            $sql = "UPDATE users SET password = '".escape($updatedPassword)."', validation_code = 0 WHERE email = '".escape($_GET['email'])."'";
                            $result = query($sql);
                            confirmQuery($result);

                            setMessage("<p class='bg-success text-center'>Your password has been updated. Please Login.</p>");
                            redirect("login.php");
                        }
                    }
                }
            }
        } else {
            setMessage("<p class='bg-danger text-center'>Sorry, session expired.</p>");
            redirect("recover.php");
        }
    }