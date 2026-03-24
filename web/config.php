<?php

define('DB_HOST', 'sql111.infinityfree.com');
define('DB_USER', 'if0_41026448');
define('DB_PASS', 'Thd9NUhROZUuwUO');
define('DB_NAME', 'if0_41026448_ecommerce');

define('DATA_DIR', __DIR__ . '/donnes_traiter/');

function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Erreur de connexion BDD : " . $conn->connect_error);
    }
    $conn->set_charset("utf8");
    return $conn;
}

function lire_csv($filename) {
    $filepath = DATA_DIR . $filename;
    if (!file_exists($filepath)) {
        return [];
    }
    $data = [];
    if (($handle = fopen($filepath, "r")) !== false) {
        $headers = fgetcsv($handle, 1000, ",");
        while (($row = fgetcsv($handle, 1000, ",")) !== false) {
            if (count($row) === count($headers)) {
                $data[] = array_combine($headers, $row);
            }
        }
        fclose($handle);
    }
    return $data;
}
?>