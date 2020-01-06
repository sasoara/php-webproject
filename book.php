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
$error_post = '';
$message = '';
$users_post = '';
$bool_post = false;
$bool_update_button = false;
// (Condition)?(thing's to do if condition true):(thing's to do if condition false);
$readonly = $bool_post === false ? '' : 'readonly';
$de_activate = $bool_update_button === false ? '' : 'disabled';

// Wenn kein Benutzer in der Session gespeichert wurde.
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
} else {
    $message .= "Welcome " . $_SESSION['username'] . ", you are now logged in!";
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

/**
 * --Serverseitige Validierung--
 * Funktion, die prüft, ob die Eingaben den Vorgaben entsprechen.
 * Sie trimmt Leerzeichen, encodet Html-Charakter
 * Bei Fehlern wird eine entsprechende Rückmeldung gegeben.
 */
function cleanUpInput($input)
{
    return trim(htmlspecialchars($input));
}
function setField(&$field, $fieldSelector, $regex, &$error)
{
    if (isset($_POST[$fieldSelector])) {
        $inputField = cleanUpInput($_POST[$fieldSelector]);
        if (preg_match($regex, $inputField)) {
            $field = $inputField;
        } else {
            $error .= "Your post does not meet the requirements.";
        }
    } else {
        $error .= "Please leave a comment.";
    }
}

// Wenn update Button getätigt wurde.
if (isset($_POST['update'])) {
    // Benutzereingaben serverseitig Validieren
    setField($users_post, 'users-post', "/^[a-zA-Z0-9-_!?,.\/\s\&\*\`\$\|\£]{15,140}$/", $error);

    if (empty($error)) {
        $query = "INSERT INTO posts (text, id_user) VALUES (?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("si", $users_post, $_SESSION['userId']);
        $stmt->execute();
        $stmt->close();
    }
}

// Wenn delete Button getätigt wurde.
if (isset($_POST['delete'])) {
    if (empty($error)) {
        $query = "DELETE FROM posts WHERE id_user = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $_SESSION['userId']);
        $stmt->execute();
        $stmt->close();
    }
}

/**
 * Für den einen User-Post
 */
$query = "SELECT text FROM posts WHERE id_user = ?";
$stmt = $mysqli->prepare($query);

// query vorbereiten
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
// results herausschreiben
$results = $stmt->get_result();

// daten auslesen
if ($results->num_rows == 1) {
    // userdaten (post) lesen
    while ($row = $results->fetch_assoc()) {
        $_SESSION['users_post_text'] = $row['text'];
        $bool_post = true;
        $bool_update_button = true;
        $readonly = $bool_post === false ? '' : 'readonly';
        $de_activate = $bool_update_button === false ? '' : 'disabled';
    }
} elseif ($results->num_rows == 0) {
    $error_post .= "You don't have a post yet.";
    $_SESSION['users_post_text'] = '<b>⊙﹏⊙ . . no post</b>';
} else {
    $error_post .= "You already have a contribution!";
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
        // Hier werden Statements ausgegeben.
        if (!empty($message)) {
            echo "<div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
        }
        // Hier werden mögliche Fehlermeldungen ausgegeben.
        if (!empty($error)) {
            echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
        }
        if (!empty($error_post)) {
            echo "<div style=\"background-color: #f0e6d8;border-color: #e9dac6; color:#765f3c\" class=\"alert alert-danger\" role=\"alert\">" . $error_post . "</div>";
        }
        ?>
        <div name="all-user-container">
            <h2>Posts</h2>
            <div style="background: #5bc0de;border-color: #46b8da;border-radius: 4px;padding: 2px;">
                <table style="border-collapse:unset;border-spacing:10px;">
                    <tbody>
                        <?php
                        /**
                         * Für alle User
                         */
                        $query = "SELECT DISTINCT u.username, p.text FROM users u INNER JOIN posts p ON u.id = p.id_user";
                        $stmt = $mysqli->prepare($query);
                        $stmt->execute();
                        // results herausschreiben
                        $post_results = $stmt->get_result();
                        while ($row = $post_results->fetch_assoc()) {
                        ?>
                            <tr onMouseOver="style.background='#BDC3C7', style.color='#fff'" onMouseOut="style.background='#5bc0de', style.color='#333'">
                                <td style="padding:3px"><?php echo $row['username'] ?></td>
                                <td style="color: #fff;background: #000;padding:1px 1px 1px 5px;width:100%;"><?php echo $row['text'] ?></td>
                            </tr>
                        <?php }
                                                                                                            $stmt->close();
                        ?>
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
                <input <?php echo $readonly ?> style="margin: 5px 0px;" type="text" name="users-post" class="form-control" placeholder="Enter a comment." minlength="15" maxlength="140" pattern="/^[a-zA-Z0-9-_!?,.\/\s\&\*\`\$\|\£]{15,140}$/">
                <p>Write a comment with at <u>least</u> <b>15</b> and a <u>maximum</u> of <b>140</b> characters!</p>
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