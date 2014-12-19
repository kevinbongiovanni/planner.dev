<!DOCTYPE html>

<?php

$array = [];


function savefile ($filename, $array) {
	$handle = fopen($filename, 'w');
		foreach ($array as $item) {
			fwrite($handle, $item . "\n");
		}
		fclose($handle);
		echo "The save was successful.\n";
}

// $filename = 'todo.txt';
// 	$handle = fopen($filename, 'r');
// 	$contents = fread($handle, filesize($filename))
// 	$array = explode("\n", $contents);
// 	fclose($handle);

function openfile($filename) {
	$handle = fopen($filename, 'r');
	$contents = trim(fread($handle, filesize($filename)));
	$array = explode("\n", $contents);
	fclose($handle);
	return $array;
}
	$array = openfile('todo.txt');
	

	if(isset($_POST['todo'])) {
		
	$array[] = $_POST['todo'];
	savefile('todo.txt', $array);
	}

	if(isset($_GET['remove'])) {
		
		$id = $_GET['remove'];
		unset($array[$id]);

	savefile('todo.txt', $array);
	}

?>
<html>
<head>
<title> To Do List</title>
</head>

<style>
body {background-color: #FF0000}
{color: #FFFFFF}
</style>






<body>

	<!-- <?php var_dump ($array) ?> -->

<h2>	What to do today? </h2>
<p>
<ul>
	<?php
		foreach ($array as $key => $value) {
			echo "<li>{$value} | <a href= \"/todo_list.php?remove={$key}\">X</a></li>";
		}
	?>
</ul>
</p>

<h3>	What to add to the list? </h3>

	<form method="POST" action="todo_list.php">
  		<p>
        	<label for="todo">What else do i need to do?</label>
        	<input id="todo" name="todo" type="text" placeholder="Add your task">
  		</p>

  		<button type="submit">Submit</button>
  


	</form>

</body>









