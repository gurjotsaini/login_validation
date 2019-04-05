<?php
    /**
     * Created by User: gurjotsaini
     */

    //Enable this only in production state
    //Enabling error_reporting
    if (!error_reporting(E_ALL)) {
        die("Unable to set error reporting");
    }

    //Enable this only in production state
    //Checking and enabling errors display
    if (!ini_get('display_errors')) {
        ini_set('display_errors', '1');
    }

    //Enable this only in production state
    //Checking and enabling startup errors display
    if (ini_get('display_startup_errors') == 0) {
        ini_set('display_startup_errors', 1);
    }

    //Checking and setting Timezone to "Asia/Kolkata"
    if (!ini_get('date.timezone')) {
        date_default_timezone_set('Asia/Kolkata');
    }