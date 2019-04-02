<?php
    /**
     * Created by User: gurjot
     */

    // Starting Output Buffering
    ob_start();

    // Starting Session
    session_start();

    //Requiring the php settings file
    require_once 'runtime_config.php';

    // Including Database Config File
    require_once "config.php";

        // Checking Database Connection
        if (!$con) {
            echo "Connection Failed";
        }

    // Including Important Files
    require_once "db_functions.php";
    require_once "functions.php";
    require_once "validation_functions.php";
    require_once "activation_functions.php";
    require_once "login_functions.php";
