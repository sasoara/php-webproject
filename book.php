<?php

/**
 * @author Sarah Bettinger | Tobias Schläpfer
 * @version 0.1
 * @internal Skript, welches die Benutzerinteraktion mit dem Gipfelbuch darstellt.
 */

// Datenbankverbindung
include('db_connector.inc.php');

session_start();
session_regenerate_id(true);

$error = '';
$message = '';
$users_post = ''; // TODO: muss validiert und in $_SESSION['users-post-text'] geschrieben werden.
$bool_post = false;
$bool_update_button = false;
// (Condition)?(thing's to do if condition true):(thing's to do if condition false);
$bool_post === false ? $readonly = '' : $readonly = 'readonly';
$bool_update_button === false ? $de_activate = '' : $de_activate = 'disabled';

// Wenn kein Benutzer in der Session gespeichert wurde.
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
} else {
    $message .= "Willkommen " . $_SESSION['username'] . " Sie sind nun eingeloggt!";
}

// Wenn logout Button getätigt wurde.
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    ob_end_flush();
    header("Location: logout.php");
}

// Wenn profile Button getätigt wurde.
if (isset($_POST['profile'])) {
    header("Location: profile.php");
}

// Wenn reload Button getätigt wurde.
if (isset($_POST['reload'])) {
    header("Location: book.php");
}

if ($bool_post === true) {
    // TODO: Input field auf 'readonly' schalten.
    // TODO: Update Button 'disablen'.
}

// Wenn update Button getätigt wurde.
if (isset($_POST['update'])) {
    // TODO: Prüfen, ob Benutzer schon ein Post hat -> sonst readonly -> message, Post löschen
    // TODO: Benutzereingaben serverseitig Validieren
    // TODO: Eingaben in die Datenbank schreiben
    // TODO: Anzeige anpassen
}

// Wenn delete Button getätigt wurde.
if (isset($_POST['delete'])) {
    // TODO: Users Post löschen
    // TODO: Input field auf 'writeable' schalten
    // TODO: Update Button auf 'active' schalten
}


/**
 * SELECT u.username, p.text
 * FROM users u
 * INNER JOIN posts p ON u.id = p.id_user;
 * -- Für alle User --
 */

/**
 * SELECT text FROM posts
 * WHERE id_user = 26;
 * -- users post --
 * $_SESSION['users_post_text']
 */

$query = "SELECT text FROM posts WHERE id_user = ?";
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
    $error .= 'bind_param() failed ' . $mysqli->error . '<br />';
}
// daten auslesen
$result = $stmt->get_result();

if ($result->num_rows) {
    // userdaten lesen
    while ($row = $result->fetch_assoc()) {
        $_SESSION['users_post_text'] = $row['text'];
    }
}
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book</title>

    <? // Bootstrap.
    ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

</head>

<body>
    <div class="container">
        <h1>Book</h1>
        <?php
        // Hier werden mögliche Fehlermeldungen ausgegeben.
        if (!empty($message)) {
            echo "<div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
        } else if (!empty($error)) {
            echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
        }
        ?>
        <div name="all-user-container">
            <h2>Posts</h2>
            <div style="background: #5bc0de;border-color: #46b8da;border-radius: 4px;padding: 2px;">
                <table style="border-collapse:unset;border-spacing:10px;">
                    <tbody>
                        <tr onMouseOver="style.background='#BDC3C7', style.color='#fff'" onMouseOut="style.background='#5bc0de', style.color='#333'">
                            <td style="padding:3px">AllPosts
                                <!-- TODO: <?php foreach ($variable as $key => $value) {
                                                # code...
                                            } ?> -->
                            </td>
                            <td style="color: #fff;background: #000;padding:1px 1px 1px 5px;width:100%;">Lorem ipsum sit amet</td>
                        </tr>
                        <tr onMouseOver="style.background='#BDC3C7', style.color='#fff'" onMouseOut="style.background='#5bc0de', style.color='#333'">
                            <td style="padding:3px">Marius</td>
                            <td style="color: #fff;background: #000;padding:1px 1px 1px 5px;width:100%;">Lorem ipsum sit amet</td>
                        </tr>
                        <tr onMouseOver="style.background='#BDC3C7', style.color='#fff'" onMouseOut="style.background='#5bc0de', style.color='#333'">
                            <td style="padding:3px">Marius</td>
                            <td style="color: #fff;background: #000;padding:1px 1px 1px 5px;width:100%;">Lorem ipsum sit amet</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br>
            <form action="" method="POST">
                <button type="submit" name="reload" value="send" class="btn btn-info">Reload</button>
            </form>
        </div>
        <div name="user-container">
            <h2><?php echo $_SESSION['username'] ?>'s Post</h2>

            <div name="user-post" style="background-color: #dff0d8;border-color: #d6e9c6;border-radius: 4px;padding:1px 1px 1px 5px;">
                <table style="border-collapse:unset;border-spacing:10px;width:100%;">
                    <tbody>
                        <tr>
                            <td style="color: #3c763d;background-color: #dff0d8;width:100%;">
                                <?php echo $_SESSION['users_post_text'] ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <form action="" method="POST">
                <input <?php echo $readonly ?> style="margin: 5px 0px;" type="text" value="<?php echo $users_post ?>" name="users-post" class="form-control">
                <button <?php echo $de_activate ?> type="submit" name="update" value="update" class="btn btn-info">Update</button>
                <button type="" name="delete" value="reset" class="btn btn-warning">Delete</button>
                <br>
                <br>
                <h2>Logout / Profile</h2>
                <button type="submit" name="logout" value="logout" class="btn btn-info">Logout</button>
                <button type="submit" name="profile" value="profile" class="btn btn-info">Profile</button>
            </form>
        </div>
    </div>
    <? // jQuery (necessary for Bootstrap's JavaScript plugins).
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <? // Include all compiled plugins (below), or include individual files as needed.
    ?>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>

</html>