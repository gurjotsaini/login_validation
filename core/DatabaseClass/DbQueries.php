<?php
    /**
     * Created by User: gurjot
     */

    namespace App\Core\DatabaseClass;
    use App\Core\DatabaseClass\DbHelperMethods;

    class DbQueries
    {
        /**
         * @param $tableName
         * @param $email
         * @return bool
         */
        public static function emailExists( $tableName, $email) {
            $sql = "SELECT id FROM '". $tableName ."' WHERE  email = '$email'";
            $result = DbHelperMethods::query($sql);
            DbHelperMethods::confirmQuery($result);

            if (DbHelperMethods::rowCount($result) == 1)
            {
                return true;
            } else {
                return false;
            }
        }

        /**
         * @param $tableName
         * @param $username
         * @return bool
         */
        public static function usernameExists( $tableName, $username) {
            $sql = "SELECT id FROM '". $tableName ."' users WHERE username = '$username'";
            $result = DbHelperMethods::query($sql);
            DbHelperMethods::confirmQuery($result);

            if (DbHelperMethods::rowCount($result) == 1)
            {
                return true;
            } else {
                return false;
            }
        }
    }