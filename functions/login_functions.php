<?php
    /**
     * Created by User: gurjot
     */

    function loginUser($email, $password) {
        $sql = "SELECT password, id FROM users WHERE email = '".escape($email)."' AND active = 1";
        $result = query($sql);
        confirmQuery($result);

        if (rowCount($result) == 1) {
            $row = fetchArray($result);
            $dbPassword = $row['password'];

            if (md5($password) === $dbPassword) {
                $_SESSION['email'] = $email;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }