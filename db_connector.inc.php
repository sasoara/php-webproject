<?php
/**
 * @author Sarah Bettinger | Tobias Schläpfer
 * @version 0.1
 * @internal Skript, welches die Verbindung zur Datenbank herstellt.
 */

include('db_properties.inc.php');

// mit Datenbank verbinden
$mysqli = new mysqli($host, $username, $password, $database);

// Fehlermeldung, falls Verbindung fehlschlägt.
if ($mysqli->connect_error) {
die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
}

?>