<?php

/**
 * @author Sarah Bettinger | Tobias Schläpfer
 * @version 0.1
 * @internal Skript, welches die Benutzerinteraktion mit dem Gipfelbuch darstellt.
 */

$error = '';
$message = '';

if (!isset($_SESSION['username']) || session_id() == '') {
    $message .= "Sie sind nun erfolgreich ausgeloggt!";
} else {
    $error .= "Da isch was falsch gloffe :O";
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logout</title>

    <? // Bootstrap.
    ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

</head>

<body>
    <div class="container">
        <h1>Logout</h1>
        <?php
        // Hier werden mögliche Fehlermeldungen ausgegeben.
        if (!empty($message)) {
            echo "<div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
        } else if (!empty($error)) {
            echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
        }
        ?>
        <form action="" method="POST">
            <button type="submit" name="button" value="login" class="btn btn-info">Login</button>
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