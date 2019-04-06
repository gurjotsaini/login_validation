<?php
    /**
     * Created by User: gurjot
     */

    // Starting Output Buffering
    ob_start();

    // Starting Session
    session_start();

    //Requiring the php settings file
    require_once 'core/runtime_config.php';

    // Including Database Config File
    require_once "core/conf.php";

        // Checking Database Connection
        if (!$con) {
            echo "Connection Failed";
        }

    // Including Important Files
    require_once "functions/db_functions.php";
    require_once "functions/send_mail.php";
    require_once "functions/functions.php";
    require_once "functions/validation_functions.php";
    require_once "functions/activation_functions.php";
    require_once "functions/login_functions.php";
    require_once "functions/session_functions.php";
    require_once "functions/recover_password.php";
    require_once "functions/reset_password.php";

    // Including App Config Class
    require_once "core/AppConfigs/Configs.php";

    // Including Database Classes
    require_once "core/DatabaseClass/DbConnection.php";
    require_once "core/DatabaseClass/DbHelperMethods.php";

        // Checking Database Connection
        $dbClass = new \App\Core\DatabaseClass\DbConnection();
        $dbClass->checkConnection();

    // Including Mail Class
    require_once "core/MailClass/Mail.php";
