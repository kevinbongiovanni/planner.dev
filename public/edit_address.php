<?php


define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'address_book');
define('DB_USER', 'codeup');
define('DB_PASS', 'codeup');

require_once('../db_connect.php');

if (empty($_GET['id']) AND empty($_POST)) {
	header('Location: index.php');
}


// updating

if (!empty($_POST)) {

	$query='UPDATE addresses SET 
	street=:street, 
	city=:city, 
	state=:state, 
	zip=:zip 
	WHERE id=:id';


	$stmt = $dbc->prepare($query);

	$stmt->bindValue(':id', $_POST['id'], PDO::PARAM_STR);
	$stmt->bindValue(':street', $_POST['street'], PDO::PARAM_STR);
	$stmt->bindValue(':city', $_POST['city'], PDO::PARAM_STR);
	$stmt->bindValue(':state', $_POST['state'], PDO::PARAM_STR);
	$stmt->bindValue(':zip', $_POST['zip'], PDO::PARAM_STR);

	$stmt->execute();

	$id=$_POST['id'];
}
else {
	// Set the id from $_GET.
	$id=$_GET['id'];
}

$sql="SELECT * FROM addresses WHERE ID=".$id."";
$address = $dbc->query($sql)->fetch(PDO::FETCH_ASSOC);
?>

<?
require_once '../inc/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Editing Address</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<body>
<center>
<h2>Edit Address Information</h2>
<form action="edit_address.php" method="post">
<input type="hidden" name="id" value="<?=$address['id']?>">
	<table border="0">
		<tr>
			<td align="right"><strong>Address:</strong></td>
			<td><input type="text" name="street" value="<?=$address['street']?>" size="45"></td>
		</tr>
		<tr>
			<td align="right"><strong>City:</strong></td>
			<td><input type="text" name="city" value="<?=$address['city']?>" size="45"></td>
		</tr>
		<tr>
			<td align="right"><strong>State:</strong></td>
			<td><input type="text" name="state" value="<?=$address['state']?>" size="45"></td>
		</tr>
		<tr>
			<td align="right"><strong>Zip:</strong></td>
			<td><input type="text" name="zip" value="<?=$address['zip']?>" size="45"></td>
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