<?php
/**
 * @author Sarah Bettinger | Tobias Schläpfer
 * @version 0.1
 * @internal Skript, welches die Logindaten prüft und den User einloggt.
 */

// Formular wurde gesendet und Besucher ist noch nicht angemeldet.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";

	if ($_POST['home']) {
	  header("Location: index.php");
	}

	// username
	if (isset($_POST['username'])) {
		//trim
		$username = trim($_POST['username']);

		// prüfung benutzername
		if (empty($username) || !preg_match("/(?=.*[a-z])(?=.*[A-Z])[a-zA-Z]{6,30}/", $username)) {
			$error .= "Der Benutzername entspricht nicht dem geforderten Format.<br />";
		}
	} else {
		$error .= "Geben Sie bitte den Benutzername an.<br />";
	}
	// password
	if (isset($_POST['password'])) {
		//trim
		$password = trim($_POST['password']);
		// passwort gültig?
		if (empty($password) || !preg_match("/(?=^.{8,255}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $password)) {
			$error .= "Das Passwort entspricht nicht dem geforderten Format.<br />";
		}
	} else {
		$error .= "Geben Sie bitte das Passwort an.<br />";
	}

	// user herauslesen und einloggen
	if (empty($error)) {

		$query = "SELECT id, username, password FROM users WHERE username=?";
		// query vorbereiten
		$stmt = $mysqli->prepare($query);
		if ($stmt === false) {
			$error .= 'prepare() failed ' . $mysqli->error . '<br />';
		}
		// parameter an query binden
		if (!$stmt->bind_param("s", $username)) {
			$error .= 'bind_param() failed ' . $mysqli->error . '<br />';
		}
		// query ausführen
		if (!$stmt->execute()) {
			$error .= 'bind_param() failed ' . $mysqli->error . '<br />';
		}
		// daten auslesen
		$result = $stmt->get_result();
		// benutzer vorhanden
		if ($result->num_rows >=1) {
			// userdaten lesen
			while ($row = $result->fetch_assoc()) {
				// passwort prüfen
				if (password_verify($password, $row['password'])) {
					// session starten
					session_start();
					session_regenerate_id(true);
					// ID und Name des Users in der Session speichern
					$_SESSION['loggedin'] = true;
					$_SESSION['userId'] = $row['id'];
					$_SESSION['username'] = $row['username'];
					header("Location: book.php");
				} else {
					$error .= "Benutzername oder Passwort sind falsch";
				}
			}
		} else {
			$error .= "Benutzername oder Passwort sind falsch";
		}
		$stmt->close();
	}
}
