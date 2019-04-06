<?php
    /**
     * Created by User: gurjot
     */

    namespace App\Core\DatabaseClass;
    use App\Core\DatabaseClass\DbConfig;
    use mysql_xdevapi\Exception;

    class DbConnection
    {
        private $connect;
        private $dbConfig;

        public function connectWithDatabase() {
            try {
                $this->dbConfig = DbConfig::getDbConfig();
                $this->connect  = mysqli_connect(
                    $this->dbConfig['host'],
                    $this->dbConfig['username'],
                    $this->dbConfig['password'],
                    $this->dbConfig['database_name'],
                    $this->dbConfig['port']
                );

                if ( !$this->connect ) {
                    die( "Something went wrong! Try Again!" );
                }
            } catch ( Exception $e ) {
                die( "Connection Error: " . $e->getMessage() . "<br />" );
            }
        }
    }