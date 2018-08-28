<?php
    class Database
    {
        private static $name = "mydb";
        private static $host = "localhost";
        private static $user = "root";
        private static $pass = "";
        private static $conn = null;

        //constructor
        public function __construct()
        {
            die("can't connect to database");
        }
        //connect to db
        public static function connect()
        {
            //singleton connection
            if(self::$conn==null)
            {
                self::$conn = new mysqli(self::$host, self::$user, self::$pass, self::$name);
                self::$conn->set_charset("utf8");
            }
            return self::$conn;
        }
    }
?>
