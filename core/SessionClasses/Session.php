<?php
    /**
     * Created by User: gurjot
     */

    namespace App\Core\SessionClasses;

    class Session
    {
        /**
         * @return bool
         */
        public function loggedIn() {
            if (isset($_SESSION['email']) || isset($_COOKIE['email'])) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * @param $message
         */
        public function setMessage( $message) {
            (!empty($message)) ? $_SESSION['message'] = $message : $message = "";
        }

        /**
         * display message
         */
        public function displayMessage() {
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }
        }

        /**
         * @return string
         */
        public function tokenGenerator() {
            $token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));

            return $token;
        }
    }