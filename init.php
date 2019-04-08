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

    // Including Database Classes
    require_once "core/DatabaseClass/DbConnection.php";
    require_once "core/DatabaseClass/DbHelperMethods.php";
    require_once "core/DatabaseClass/DbQueries.php";

        // Checking Database Connection
        $dbClass = new App\Core\DatabaseClass\DbConnection();
        $dbClass->checkConnection();

    // Including Important Files
    require_once "core/functions.php";

    // Including App Config Class
    require_once "core/AppConfigs/Configs.php";

    // Including Mail Class
    require_once "core/MailClass/Mail.php";

    // Including Session Class
    require_once "core/SessionClasses/Session.php";

    // Including Login Classes
    require_once "core/LoginClasses/Login.php";
    require_once "core/LoginClasses/Register.php";

    // Including HTML Classes
    require_once "core/HtmlClasses/FormSanitizations.php";
    require_once "core/HtmlClasses/DisplayErrors.php";