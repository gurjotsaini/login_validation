<?php
    /**
     * Created by User: gurjot
     */

    namespace App\Core\DatabaseClass;
    use App\Core\DatabaseClass\DbHelperMethods;

    class DbQueries
    {
        public function emailExists($tableName, $email) {
            $sql = "SELECT id FROM '". $tableName ."' WHERE  email = '$email'";
            $result = DbHelperMethods::query($sql);
            DbHelperMethods::confirmQuery($result);

            (DbHelperMethods::rowCount($result) == 1) ? true : false;
        }

        public function usernameExists($tableName, $username) {
            $sql = "SELECT id FROM '". $tableName ."' users WHERE username = '$username'";
            $result = DbHelperMethods::query($sql);
            DbHelperMethods::confirmQuery($result);

            (DbHelperMethods::rowCount($result) == 1) ? true : false;
        }
    }