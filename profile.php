<?php

/**
 * @author Sarah Bettinger | Tobias Schläpfer
 * @version 0.1
 * @internal Skript, welches dem Benutzer ermöglicht, seine Userdaten anzupassen.
 */

session_start();
session_regenerate_id(true);

$error = '';
$message = '';
$email = $username = '';

// Wenn der Button back gedrückt wurde -> zurückleitung zu book.php.
if (isset($_POST['back'])) {
    header("Location: book.php");
}

// Wenn der Button send gedrückt wurde -> umleitung auf book.php
if (isset($_POST['send'])) {
    // TODO: Serverseitige Validierung
    // TODO: Datenbank - ALTER TABLE
    // TODO: Session - Variablen anpassen
    // TODO: zurückleitung auf book.php
}

// Wenn der Button erase-profile gedrückt wurde -> user wird in der Datenbank gelöscht.
if (isset($_POST['erase-profile'])) {
    // TODO: Datenbank - DELETE user
    // TODO: Session löschen
    // TODO: ausloggen
}

// TODO: Error - Meldungen

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>

    <? // Bootstrap.
    ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

</head>

<body>
    <div class="container">
        <form action="" method="POST">
            <button type="submit" name="back" value="submit" class="btn btn-info">Back</button>
        </form>
        <h1>Profile</h1>
        <?php
        // Hier werden mögliche Fehlermeldungen ausgegeben.
        if (!empty($message)) {
            echo "<div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
        } else if (!empty($error)) {
            echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
        }
        ?>
        <form action="" method="post">
            <? // Clientseitige Validierung: Vorname
            ?>
            <div class="form-group">
                <label for="firstname">Firstname</label>
                <input readonly type="text" name="firstname" class="form-control" id="firstname" value="" placeholder="<?php echo $_SESSION['userFirstname'] ?>" required="true" minlength="2" maxlength="30" pattern="^[A-ZÄÖÜ]{1,1}[a-zA-ZäÄöÖüÜß]{1,30}$">
            </div>
            <? // Clientseitige Validierung: Nachname
            ?>
            <div class="form-group">
                <label for="lastname">Lastname</label>
                <input readonly type="text" name="lastname" class="form-control" id="lastname" value="" placeholder="<?php echo $_SESSION['userLastname'] ?>" required="true" minlength="2" maxlength="30" pattern="^[A-ZÄÖÜ]{1,1}[a-zäÄöÖüÜß]{0,}[A-ZÄÖÜ]{0,1}[a-zäÄöÖüÜß]{1,30}$">
            </div>
            <? // Clientseitige Validierung: Email
            ?>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" value="<?php echo $email ?>" placeholder="<?php echo $_SESSION['userEmail'] ?>" required="true" maxlength="100" pattern="^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$">
            </div>
            <? // Clientseitige Validierung: Benutzername
            ?>
            <div class="form-group">
                <label for="username">Userername</label>
                <p>Upper- and lowercase letters, min 6 characters.</p>
                <input type="text" name="username" class="form-control" id="username" value="<?php echo $username ?>" placeholder="<?php echo $_SESSION['username'] ?>" required="true" minlength="6" pattern="^[a-zA-Z]+[a-zA-Z0-9]{5,30}$" maxlength="30">

            </div>
            <? // Clientseitige Validierung: Passwort
            ?>
            <div class="form-group">
                <label for="password">Password</label>
                <p>Upper- and lowercase letters, numbers, special characters, min. 8 characters, no umlauts.</p>
                <input type="password" name="password" class="form-control" id="password" placeholder="Type new password." required="true" maxlength="255" pattern="(?=^.{8,255}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
            </div>
            <button type="submit" name="send" value="submit" class="btn btn-info">Send</button>
            <button type="reset" name="button" value="reset" class="btn btn-warning">Delete</button>
            <br>
            <br>
            <button style="background-color: #f06c4e;border-color: #f04e4e;" type="" name="erase-profile" value="reset" class="btn btn-warning">Erase profile</button>
        </form>
    </div>
    <? // jQuery (necessary for Bootstrap's JavaScript plugins).
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <? // Include all compiled plugins (below), or include individual files as needed.
    ?>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>

</html>