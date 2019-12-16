<?php

/**
 * @author Sarah Bettinger | Tobias Schläpfer
 * @version 0.1
 * @internal Skript, welches die Registration prüft und korrekt in die Datenbank speichert.
 */

// Wurden Daten mit "POST" gesendet?
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  // Ausgabe des gesamten $_POST Arrays
  echo "<pre>";
  print_r($_POST);
  echo "</pre>";

  if ($_POST['home']) {
    header("Location: index.php");
  }

  function debug_to_console($data)
  {
    $output = $data;
    if (is_array($output))
      $output = implode(',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
  }

  /**
   * --Serverseitige Validierung--
   * Funktion, die prüft, ob die Eingaben den Vorgaben entsprechen.
   * Sie trimmt Leerzeichen, encodet Html-Charakter, schreibt Email's lowercase und
   * hashed das Passwort.
   * Bei Fehlern wird eine entsprechende Rückmeldung gegeben.
   */
  function cleanUpInput($input)
  {
    return trim(htmlspecialchars($input));
  }

  function setField(&$field, $fieldSelector, $fieldAsText, $regex, &$error)
  {
    if (isset($_POST[$fieldSelector])) {
      $inputField = cleanUpInput($_POST[$fieldSelector]);
      if (preg_match($regex, $inputField)) {
        if ($fieldSelector == 'email') {
          $field = strtolower($inputField);
        } elseif ($fieldSelector == 'password') {
          $field = password_hash($inputField, PASSWORD_DEFAULT);
        } else {
          $field = $inputField;
        }
      } else {
        $error .= $fieldAsText . " entspricht nicht den Vorgaben. ";
      }
    } else {
      $error .= "Bitte " . $fieldAsText . " eingeben. ";
    }
  }

  // Hier wird die Funktion für die serverseitige Validierung aufgerufen.
  // https://regex101.com/
  setField($firstname, 'firstname', "Vorname", "/^[A-ZÄÖÜ]{1,1}[a-zA-ZäÄöÖüÜß]{1,30}$/", $error);
  setField($lastname, 'lastname', "Nachname", "/^[A-ZÄÖÜ]{1,1}[a-zäÄöÖüÜß]{0,}[A-ZÄÖÜ]{0,1}[a-zäÄöÖüÜß]{1,30}$/", $error);
  setField($username, 'username', "Benutzername", "/^[a-zA-Z]+[a-zA-Z0-9]{5,30}$/", $error);
  setField($email, 'email', "Email", "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $error);
  setField($password, 'password', "Passwort", "/(?=^.{8,255}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $error);

  debug_to_console($firstname);
  debug_to_console($lastname);
  debug_to_console($username);
  debug_to_console($email);
  debug_to_console($password);

  // in Datenbank schreiben
  if (empty($error)) {
    $query = "INSERT INTO users (firstname, lastname, username, password, email) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sssss", $firstname, $lastname, $username, $password, $email);
    $stmt->execute();
    $stmt->close();
    header("Location: login.php");
  }
}
