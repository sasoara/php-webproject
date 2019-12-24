<?php

/**
 * @author Sarah Bettinger | Tobias Schläpfer
 * @version 0.1
 * @internal Skript, welches den User registrieren lässt.
 */

// Initialisierung
include('db_connector.inc.php');

$error = '';
$firstname = $lastname = $email = $username = '';

include('registering.inc.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register</title>

  <? // Bootstrap.
  ?>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

</head>

<body>
  <div class="container">
    <div>
      </br>
      <form action="" method="POST">
        <button type="submit" name="home" value="submit" class="btn btn-info">Home</button>
      </form>
      </br>
    </div>
    <h1>Register</h1>
    <p>
      Please register so that you can use this service.
    </p>
    <?php
    // Hier werden mögliche Fehlermeldungen ausgegeben.
    if (strlen($error)) {
      echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
    }
    ?>
    <form action="" method="post">
      <? // Clientseitige Validierung: Vorname    | Yi / Sarah / Björn
      ?>
      <div class="form-group">
        <label for="firstname">Firstname *</label>
        <input type="text" name="firstname" class="form-control" id="firstname" value="<?php echo $firstname ?>" placeholder="Enter your first name." required="true" minlength="2" maxlength="30" pattern="^[A-ZÄÖÜ]{1,1}[a-zA-ZäÄöÖüÜß]{1,30}$">
      </div>
      <? // Clientseitige Validierung: Nachname     | Bettinger / ONeil / VanLauch / Ömeric
      ?>
      <div class="form-group">
        <label for="lastname">Lastname *</label>
        <input type="text" name="lastname" class="form-control" id="lastname" value="<?php echo $lastname ?>" placeholder="Enter your last name." required="true" minlength="2" maxlength="30" pattern="^[A-ZÄÖÜ]{1,1}[a-zäÄöÖüÜß]{0,}[A-ZÄÖÜ]{0,1}[a-zäÄöÖüÜß]{1,30}$">
      </div>
      <? // Clientseitige Validierung: Email
      ?>
      <div class="form-group">
        <label for="email">Email *</label>
        <input type="email" name="email" class="form-control" id="email" value="<?php echo $email ?>" placeholder="Enter your email address." required="true" maxlength="100" pattern="^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$">
      </div>
      <? // Clientseitige Validierung: Benutzername     | Tralala
      ?>
      <div class="form-group">
        <label for="username">Userername *</label>
        <input type="text" name="username" class="form-control" id="username" value="<?php echo $username ?>" placeholder="Upper- and lowercase letters, min 6 characters." required="true" minlength="6" pattern="^[a-zA-Z]+[a-zA-Z0-9]{5,30}$" maxlength="30">

      </div>
      <? // Clientseitige Validierung: Passwort
      ?>
      <div class="form-group">
        <label for="password">Password *</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="Upper- and lowercase letters, numbers, special characters, min. 8 characters, no umlauts." required="true" maxlength="255" pattern="(?=^.{8,255}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
      </div>
      <button type="submit" name="button" value="submit" class="btn btn-info">Send</button>
      <button type="reset" name="button" value="reset" class="btn btn-warning">Delete</button>
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