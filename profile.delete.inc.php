<?php

/**
 * @author Sarah Bettinger | Tobias Schläpfer
 * @version 0.1
 * @internal Skript, welches die Userdaten und den Userpost löscht.
 */

if (empty($error)) {
    /**
     * Hier wird der Post des Users gelöscht
     */
    $query = "DELETE FROM posts WHERE id_user =?";
    // query vorbereiten
    $stmt = $mysqli->prepare($query);
    if ($stmt === false) {
        $error .= 'prepare() failed ' . $mysqli->error . '<br />';
    }
    // parameter an query binden
    if (!$stmt->bind_param("i", $_SESSION['userId'])) {
        $error .= 'bind_param() failed ' . $mysqli->error . '<br />';
    }
    // query ausführen
    if (!$stmt->execute()) {
        $error .= 'execute() failed ' . $mysqli->error . '<br />';
    }
    $stmt->close();

    /**
     * Hier wird der User gelöscht
     */
    $query = "DELETE FROM users WHERE id =?";
    // query vorbereiten
    $stmt = $mysqli->prepare($query);
    if ($stmt === false) {
        $error .= 'prepare() failed ' . $mysqli->error . '<br />';
    }
    // parameter an query binden
    if (!$stmt->bind_param("i", $_SESSION['userId'])) {
        $error .= 'bind_param() failed ' . $mysqli->error . '<br />';
    }
    // query ausführen
    if (!$stmt->execute()) {
        $error .= 'execute() failed ' . $mysqli->error . '<br />';
    }
    $stmt->close();

    session_unset();
    session_destroy();
    ob_end_flush();
    header("Location: registering.php");
}
