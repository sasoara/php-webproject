<?php

/**
 * @author Sarah Bettinger | Tobias Schläpfer
 * @version 0.1
 * @internal Skript, welches die Userdaten in der Datenbank anpasst.
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
if (isset($_POST['username']) && !empty($_POST['username'])) {
    setField($username, 'username', "Benutzername", "/^([a-zA-Z]{1})([a-zA-Z0-9]{1,29})$/", $error);
} else {
    $username = $_SESSION['username'];
}
if (isset($_POST['email']) && !empty($_POST['email'])) {
    setField($email, 'email', "Email", "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $error);
} else {
    $email = $_SESSION['userEmail'];
}
// Datenbank anpassen
if (empty($error)) {
    $query = "UPDATE users SET username = ?, email = ? WHERE (id = ?)";
    $stmt = $mysqli->prepare($query);
    // parameter an query binden
    if (!$stmt->bind_param("ssi", $username, $email, $_SESSION['userId'])) {
        $error .= 'bind_param() failed ' . $mysqli->error . '<br />';
    }
    if (!$stmt->execute()) {
        $error .= 'execute() failed ' . $mysqli->error . '<br />';
    }
    $stmt->close();
    $_SESSION['username'] = $username;
    $_SESSION['userEmail'] = $email;

    if (isset($_POST['password']) && !empty($_POST['password'])) {
        setField($password, 'password', "Passwort", "/(?=^.{8,255}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $error);

        $query = "UPDATE users SET password = ? WHERE (id = ?)";
        $stmt = $mysqli->prepare($query);
        // parameter an query binden
        if (!$stmt->bind_param("si", $password, $_SESSION['userId'])) {
            $error .= 'bind_param() failed ' . $mysqli->error . '<br />';
        }
        if (!$stmt->execute()) {
            $error .= 'execute() failed ' . $mysqli->error . '<br />';
        }
        $stmt->close();
    }
    header("Location: book.php");
}