<?php

    /**
     * Database connection/helper class using PDO
     * 
     */
    class Database {

        private $host = DB_HOST;
        private $user = DB_USER;
        private $pass = DB_PASS;
        private $dbname = DB_NAME;

        private $dbh; //Database handler
        private $stmt; //Statement
        private $error;

        public function __construct() {
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            $options = array (
                PDO::ATTR_PERSISTENT => true, //Uses already established connection rather than create a new one
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );

            //Create PDO instance
            try {
                $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }

        /**
         * Method to prepare a statement using a provided SQL statement
         */
        public function query($sql) {
            $this->stmt = $this->dbh->prepare($sql);
        }

        /**
         * Method to bind given value to PDO type parameter
         * 
         * @param param Name of the parameter to bind
         * @param value Value to bind to the given parameter
         * @param type  Declared type of the value, if not given a type will be worked out
         * 
         */
        public function bind($param, $value, $type = null) {
            if (is_null($type)) {
                switch(true) { //set to true to always run
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                }
            }

            $this->stmt->bindValue($param, $value, $type);
        }

        /**
         * Method to execute a prepare statement
         * 
         * @return result The returned database result
         */
        public function execute() {
            return $this->stmt->execute();
        }

        /**
         * Method to return all results of a database query
         * 
         * @return resultSet    The query results as PDO objects
         */
        public function resultSet() {
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }

        /**
         * Method to return the first result of a database query
         * 
         * @return resultSet    The query result as a PDO object
         */
        public function single() {
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

        /**
         * Method to return the row count of a statement
         * 
         * @return rowCount    Number of rows affected by statement
         */
        public function rowCount() {
            return $this->stmt->rowCount();
        }

    }

?>