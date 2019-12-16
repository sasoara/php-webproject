<?php

/**
 * @author Sarah Bettinger | Tobias Schläpfer
 * @version 0.1
 * @internal Skript, welches die Startseite abbildet.
 */

$error = '';

// Wurden Daten mit "POST" gesendet?
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  // Ausgabe des gesamten $_POST Arrays
  echo "<pre>";
  print_r($_POST);
  echo "</pre>";

  if ($_POST['signup']) {
    header("Location: registering.php");
  } elseif ($_POST['signin']) {
    header("Location: login.php");
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IWASHERE</title>

  <? // Bootstrap.
  ?>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

</head>

<body>
  <div class="container">
    <h1>Welcome</h1>
    <p>
      Please select <b>SignUp</b> to register or <b>SignIn</b> to login.
    </p>
    <?php
    // Hier werden mögliche Fehlermeldungen ausgegeben.
    if (strlen($error)) {
      echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
    } ?>
    <div>
      <? // Buttons, die via POST auf die entsprechende Seite weiterleiten.
      ?>
      <form action="" method="post">
        <button type="submit" name="signup" value="submit" class="btn btn-info">SignUp</button>
        <button type="submit" name="signin" value="submit" class="btn btn-info">SignIn</button>
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