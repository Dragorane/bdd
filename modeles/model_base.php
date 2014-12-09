<?php

class Model_Base {

    protected static $_db;

    public static function set_db() {
        $conn = oci_connect(SQL_USERNAME, SQL_PASSWORD, SQL_DSN) or die("Une erreur de connexion s'est produite.\n");
        self::$_db = $conn;
    }

    public static function close_db() {
        oci_close(self::$_db);
    }

}

?>