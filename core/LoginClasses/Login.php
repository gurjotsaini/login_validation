<?php
    /**
     * Created by User: gurjot
     */

    namespace App\Core\LoginClasses;
    use App\Core\DatabaseClass\DbHelperMethods;

    class Login
    {
        public function validateLogin() {
            $errors = [];

            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $email          = clean($_POST['email']);
                $password       = clean($_POST['password']);
                $rememberMe     = isset($_POST['remember']);
            }

            if (empty($email)) {
                $errors[] = "Email field cannot be left empty. <br />";
            }

            if (empty($password)) {
                $errors[] = "Password field cannot be left empty. <br />";
            }

            if (!empty($errors)) {
                echo '<div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="alert-heading">Warning!</h4>
             ';

                foreach ($errors as $error) {
                    echo $error;
                }

                echo '</div>';
            } else {
                if ($this->login($email, $password, $rememberMe)) {
                    redirect("admin.php");
                } else {
                    echo validationErrors("Your credentials are not correct");
                }
            }
        }

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

            if ( DbHelperMethods::rowCount($result) == 1 ) {
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