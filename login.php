<?php

/**
 * @author Sarah Bettinger | Tobias Schläpfer
 * @version 0.1
 * @internal Skript, welches den User einloggen lässt.
 */

// Datenbankverbindung
include('db_connector.inc.php');

$error = '';
$message = '';

include('post_method_login.inc.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>

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
		<h1>Login</h1>
		<p>
			Please log in with your username and password.
		</p>
		<?php
		// Hier werden mögliche Fehlermeldungen ausgegeben.
		if (!empty($message)) {
			echo "<div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
		} else if (!empty($error)) {
			echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
		}
		?>
		<form action="" method="POST">
			<div class="form-group">
				<? // Benutzernameneingabe.
				?>
				<label for="username">Username *</label>
				<input type="text" name="username" class="form-control" id="username" value="" placeholder="Upper- and lowercase letters, min 6 characters." pattern="(?=.*[a-z])(?=.*[A-Z])[a-zA-Z]{6,}" title="Gross- und Keinbuchstaben, min 6 Zeichen." maxlength="30" required="true">
			</div>
			<? // Passworteingabe.
			?>
			<div class="form-group">
				<label for="password">Password *</label>
				<input type="password" name="password" class="form-control" id="password" placeholder="Upper- and lowercase letters, numbers, special characters, min. 8 characters, no umlauts." pattern="(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="mindestens einen Gross-, einen Kleinbuchstaben, eine Zahl und ein Sonderzeichen, mindestens 8 Zeichen lang,keine Umlaute." maxlength="255" required="true">
			</div>
			<button type="submit" name="button" value="submit" class="btn btn-info">Senden</button>
			<button type="reset" name="button" value="reset" class="btn btn-warning">Löschen</button>
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