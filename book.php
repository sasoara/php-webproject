<?php

/**
 * @author Sarah Bettinger | Tobias Schläpfer
 * @version 0.1
 * @internal Skript, welches die Benutzerinteraktion mit dem Gipfelbuch darstellt.
 */

session_start();
session_regenerate_id(true);

$error = '';
$message = '';


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
} else {
    $message .= "Willkommen " . $_SESSION['username'] . " Sie sind nun eingeloggt";
}

// Richtig?
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    session_unset();
    session_destroy();
    ob_end_flush();
    header("Location: logout.php");
}
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
        <form action="" method="POST">
            <button type="submit" name="button" value="logout" class="btn btn-info">Logout</button>
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