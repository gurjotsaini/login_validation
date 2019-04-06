<?php
    /**
     * Created by User: gurjot
     */

    namespace App\Core\DatabaseClass;
    use App\Core\DatabaseClass\DbConnection;

    class DbHelperMethods
    {
        protected static $con;

        /**
         * DbHelperMethods constructor.
         */
        public function __construct () {
            $dbClass = new DbConnection();
            self::$con = $dbClass->connectWithDatabase();
        }

        /**
         * @param $query
         * @return bool|\mysqli_result
         */
        public static function query( $query) {
            return mysqli_query(self::$con, $query);
        }

        /**
         * @param $result
         */
        public static function confirmQuery( $result) {
            if (!$result) {
                die("QUERY FAILED" . mysqli_error(self::$con));
            }
        }

        /**
         * @param $string
         * @return string
         */
        public static function escape( $string) {
            return mysqli_real_escape_string(self::$con, $string);
        }

        /**
         * @param $result
         * @return array|null
         */
        public static function fetchArray( $result) {
            return mysqli_fetch_array($result);
        }

        /**
         * @param $result
         * @return int
         */
        public static function rowCount( $result) {
            return mysqli_num_rows($result);
        }
    }