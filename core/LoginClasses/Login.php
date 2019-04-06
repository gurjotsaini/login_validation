<?php
    /**
     * Created by User: gurjot
     */

    namespace App\Core\LoginClasses;
    use App\Core\DatabaseClass\DbHelperMethods;

    class Login
    {
        /**
         * @param $email
         * @param $password
         * @param $rememberMe
         * @return bool
         */
        public function login ( $email, $password, $rememberMe) {
            $sql = "SELECT password, id FROM users WHERE email = '" . escape($email) . "' AND active = 1";
            $result = DbHelperMethods::query($sql);
            DbHelperMethods::confirmQuery($result);

            if ( rowCount($result) == 1 ) {
                $row = DbHelperMethods::fetchArray($result);
                $dbPassword = $row['password'];

                if ( password_verify($password, $dbPassword) ) {
                    if ( $rememberMe == "on" ) {
                        setcookie('email', $email, time() + 86400);
                    }

                    $_SESSION['email'] = $email;

                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        /**
         * logout method
         */
        public function logout() {
            session_destroy();

            if (isset($_COOKIE['email'])) {
                unset($_COOKIE['email']);
                setcookie('email', '', time() - 86400);
            }
        }
    }