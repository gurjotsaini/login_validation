<?php
    /**
     * Created by User: gurjot
     */

    function loginUser($email, $password) {
        $sql = "SELECT password, id FROM users WHERE email = '".escape($email)."' ";
        $result = query($sql);
        confirmQuery($result);

        if (rowCount($result) == 1) {
            $row = fetchArray($sql);

            $dbPassword = $row['password'];
            return true;
        } else {
            return false;
        }
    }