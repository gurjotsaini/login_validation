<?php
    /**
     * Created by User: gurjot
     */

    function query($query) {
        global $con;
        return mysqli_query($con, $query);
    }

    function confirmQuery($result) {
        global $con;
        if (!$result) {
            die("QUERY FAILED" . mysqli_error($con));
        }
    }

    function escape($string) {
        global $con;
        return mysqli_real_escape_string($con, $string);
    }

    function fetchArray($result) {
        return mysqli_fetch_array($result);
    }

    function rowCount($result) {
        return mysqli_num_rows($result);
    }