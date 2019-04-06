<?php
    /**
     * Created by User: gurjot
     */

    namespace App\Core\DatabaseClass;

    class DbConnection
    {
        public function connectWithDatabase() {
            // Define connection as a static variable, to avoid connecting more than once
            static $connection;

            // Try and connect to the database, if a connection has not been established yet
            if(!isset($connection)) {
                // Load configuration as an array. Use the actual location of your configuration file
                $config = parse_ini_file('config.ini');

                $connection = mysqli_connect(
                    $config['host'],
                    $config['username'],
                    $config['password'],
                    $config['database_name'],
                    $config['port']
                );
            }

            // If connection was not successful, handle the error
            if($connection === false) {
                // Handle error - notify administrator, log to a file, show an error screen, etc.
                return mysqli_connect_error();
            }

            return $connection;
        }

        public function checkConnection() {
            $connection = $this->connectWithDatabase();

            // Check connection
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }
        }

        public function closeConnection() {
            $connection = $this->connectWithDatabase();

            if ($connection) {
                $connection->close();
            }
        }
    }