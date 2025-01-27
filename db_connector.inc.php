<?php
/**
 * @author Sarah Bettinger | Tobias Schläpfer
 * @version 0.1
 * @internal Skript, welches die Verbindung zur Datenbank herstellt.
 */

 // sollte nicht als Plaintext dastehen.
$host = ''; // host
$db_username = ''; // username
$db_password = ''; // password
$database = ''; // database

include('db_properties.php');

// mit Datenbank verbinden
$mysqli = new mysqli($host, $db_username, $db_password, $database);

// Fehlermeldung, falls Verbindung fehlschlägt.
if ($mysqli->connect_error) {
die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
}
