<?php

class DB {

    public static $connection;
    public static $selectDB;
    public static $q;
    public static $fa;
    public static $fr;
    public static $fassoc;
    public static $nr;

    public static function indexAction() {
        include_once(SYSTEM_PATH . DS . 'configure.php');
    }

    public static function connect() {

        self::indexAction();
        self::$connection = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
        self::$selectDB = mysql_select_db(DB_NAME);

        if (!self::$selectDB) {
            echo "<p>" . mysql_error() . "</p>";
            exit();
            return false;
        }
        return self::$connection;
    }

    public static function closeConnection() {
        mysql_close(self::$connection);
    }

    public static function q($query) {
        return mysql_query($query);
    }

    public static function fa($query) {
        return mysql_fetch_array($query);
    }

    public static function fassoc($query) {
        return mysql_fetch_assoc($query);
    }

    public static function fr($query) {
        return mysql_fetch_row($query);
    }

    public static function nr($query) {
        return mysql_num_rows($query);
    }

}
