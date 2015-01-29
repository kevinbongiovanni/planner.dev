<?php


define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'address_book');
define('DB_USER', 'codeup');
define('DB_PASS', 'codeup');

require_once('../db_connect.php');

// Send back user if they dont add any new information

if (empty($_GET['id']) AND empty($_POST)) {
	header('Location: index.php');
}

// i determine what person id im using 
if (!empty($_GET)) {
	$person_id=$_GET['id'];
	$sql="SELECT * FROM people WHERE ID=".$person_id."";
	$person = $dbc->query($sql)->fetch(PDO::FETCH_ASSOC);
}
// updating information

if (!empty($_POST)) {

	$query='INSERT INTO addresses (street,city,state,zip,person_id)
VALUES (:street,:city,:state,:zip,:person_id);';


	$stmt = $dbc->prepare($query);

	$stmt->bindValue(':person_id', $_POST['person_id'], PDO::PARAM_STR);
	$stmt->bindValue(':street', $_POST['street'], PDO::PARAM_STR);
	$stmt->bindValue(':city', $_POST['city'], PDO::PARAM_STR);
	$stmt->bindValue(':state', $_POST['state'], PDO::PARAM_STR);
	$stmt->bindValue(':zip', $_POST['zip'], PDO::PARAM_STR);

	$stmt->execute();
	$message = "Address created!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	header('Location: index.php');

}

?>

<?
require_once '../inc/header.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Create New Address</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>

<body>
<center>

<h2>New Address for <?=$person['first_name']." ".$person['last_name']?></h2>
<form action="add_address.php" method="post">
<input type="hidden" name="person_id" value="<?=$person['id']?>">
	<table border="0">
		<tr>
			<td align="right"><strong>Street:</strong></td>
			<td><input type="text" name="street" size="45"></td>
		</tr>
		<tr>
			<td align="right"><strong>City:</strong></td>
			<td><input type="text" name="city" size="45"></td>
		</tr>
		<tr>
			<td align="right"><strong>State:</strong></td>
			<td><input type="text" name="state" size="45"></td>
		</tr>
		<tr>
			<td align="right"><strong>Zip:</strong></td>
			<td><input type="text" name="zip" size="45"></td>
		</tr>
	</table>
<br>
<input type="submit">
</form>
</center>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>