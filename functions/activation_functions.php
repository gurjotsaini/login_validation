<?php
    /**
     * Created by User: gurjot
     */

    function activateUser() {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            if (isset($_GET['email'])) {
                $email             = clean($_GET['email']);
                $validationCode    = clean($_GET['code']);

                $sql = "SELECT id FROM users WHERE email = '". escape($_GET['email']) ."' AND validation_code = '".escape($_GET['code'])."' ";
                $result = query($sql);
                confirmQuery($result);

                if (rowCount($result) == 1){
                    $sql2 = "UPDATE users SET active = 1, validation_code = 0 WHERE email = '".escape($email)."' AND validation_code = '".escape($validationCode)."' ";
                    $result2 = query($sql2);
                    confirmQuery($result2);

                    setMessage("<p class='bg-success'>Your account has been activated. Please Login</p>");
                    redirect("login.php");
                } else {
                    setMessage("<p class='bg-danger'>Sorry! Your account couldn't be activated.</p>");
                    redirect("login.php");
                }
            }
        }
    }