<?php


define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'address_book');
define('DB_USER', 'codeup');
define('DB_PASS', 'codeup');

require_once('../db_connect.php');

// send back if empty
if (empty($_GET['id']) AND empty($_POST)) {
	header('Location: index.php');
}

// updating

if (!empty($_POST)) {

	$query='UPDATE people 
	SET first_name=:first_name, last_name=:last_name, phone_number=:phone_number, email=:email
	WHERE id=:id';

	$stmt = $dbc->prepare($query);
	$stmt->bindValue(':id', $_POST['id'], PDO::PARAM_STR);
	$stmt->bindValue(':first_name', $_POST['first_name'], PDO::PARAM_STR);
	$stmt->bindValue(':last_name', $_POST['last_name'], PDO::PARAM_STR);
	$stmt->bindValue(':phone_number', $_POST['phone_number'], PDO::PARAM_STR);
	$stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);

	$stmt->execute();
	$message = "Person successfully updated!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	header('Location: index.php');

}
else {
	// Set the id from $_GET.
	$id=$_GET['id'];
}

$sql="SELECT * FROM people WHERE ID=".$id."";
$person = $dbc->query($sql)->fetch(PDO::FETCH_ASSOC);
?>

<?
require_once '../inc/header.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
   <head>
  <title>Edit Contact Info</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<center>

<h2>Edit Person Information</h2>
<form action="edit_person.php" method="post">
<input type="hidden" name="id" value="<?=$person['id']?>">
	<table border="0">
		<tr>
			<td align="right"><strong>First Name:</strong></td>
			<td><input type="text" name="first_name" value="<?=$person['first_name']?>" size="45"></td>
		</tr>
		<tr>
			<td align="right"><strong>Last Name:</strong></td>
			<td><input type="text" name="last_name" value="<?=$person['last_name']?>" size="45"></td>
		</tr>
		<tr>
			<td align="right"><strong>Phone Number:</strong></td>
			<td><input type="text" name="phone_number" value="<?=$person['phone_number']?>" size="45"></td>
		</tr>
		<tr>
			<td align="right"><strong>Email:</strong></td>
			<td><input type="text" name="email" value="<?=$person['email']?>" size="45"></td>
		</tr>
	</table>
<br>
<input type="submit">
</form>
</center>


     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
 
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>