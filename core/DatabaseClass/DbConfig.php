<?php
    /**
     * Created by User: gurjot
     */

    namespace App\Core\DatabaseClass;

    class DbConfig
    {
        protected const DB_CONFIG = [
            'host'          =>  'localhost',
            'username'      =>  'root',
            'password'      =>  'root',
            'database_name' =>  'login_validation',
            'port'          =>  '8888'
        ];

        public static function getDbConfig() {
            return self::DB_CONFIG;
        }
    }