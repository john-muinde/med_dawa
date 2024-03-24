<?php
$_DB_PASSWORD = "";
$_DB_USERNAME = "root";
$_DB_DATABASE = "med_dawa";
$_DB_HOST = "localhost";


try {
    $DB = new mysqli($_DB_HOST, $_DB_USERNAME, $_DB_PASSWORD, $_DB_DATABASE);

    if ($DB->connect_error) {
        throw new Exception('Connect Error (' . $DB->connect_errno . ') ' . $DB->connect_error);
    }
} catch (\Throwable $e) {
    die(json_encode(array(
        'error' => $e->getMessage()
    )));
}
