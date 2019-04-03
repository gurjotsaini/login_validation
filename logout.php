<?php
    require_once "functions/init.php";

    session_destroy();
    redirect("login.php");