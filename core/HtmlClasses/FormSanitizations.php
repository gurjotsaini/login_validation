<?php
    /**
     * Created by User: gurjot
     */

    namespace App\Core\HtmlClasses;

    class FormSanitizations
    {
        /**
         * @param $string
         * @return string
         */
        public function clean( $string) {
            return htmlentities($string);
        }

        /**
         * @param $inputName
         * @param $inputPlaceholder
         * @return string
         */
        public function isEmpty( $inputName, $inputPlaceholder) {
            if (empty($inputName)) {
                $error = "'{$inputPlaceholder}' cannot be empty" . "<br />";

                return $error;
            }
        }

        /**
         * @param $inputName
         * @param $placeholderName
         * @param $minimumValue
         * @return string
         */
        public function isMinimum( $inputName, $placeholderName, $minimumValue) {
            if (strlen($inputName) < $minimumValue) {
                $error = "'{$placeholderName}' cannot be less than {$minimumValue} characters." . "<br />";

                return $error;
            }
        }

        /**
         * @param $inputName
         * @param $placeholderName
         * @param $maximumValue
         * @return string
         */
        public function isMaximum( $inputName, $placeholderName, $maximumValue) {
            if (strlen($inputName) > $maximumValue) {
                $error = "'{$placeholderName}' cannot be less than {$maximumValue} characters." . "<br />";

                return $error;
            }
        }
    }