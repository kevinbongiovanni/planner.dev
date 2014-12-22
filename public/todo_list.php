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

if (count($_FILES) > 0 && $_FILES['file1']['error'] == UPLOAD_ERR_OK) {
    // Set the destination directory for uploads
    $uploadDir = '/vagrant/sites/planner.dev/public/uploads/';

    // Grab the filename from the uploaded file by using basename
    $filename = basename($_FILES['file1']['name']);

    // Create the saved filename using the file's original name and our upload directory
    $savedFilename = $uploadDir . $filename;

    // Move the file from the temp location to our uploads directory
    move_uploaded_file($_FILES['file1']['tmp_name'], $savedFilename);
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

		 <?php if (isset($savedFilename)) {
        // If we did, show a link to the uploaded file
        echo "<p>You can download your file <a href='/uploads/{$filename}'>here</a>.</p>";
    }
    ?>

<!-- <h3>	What to add to the list? </h3>

	<form method="POST" action="todo_list.php">
  		<p>
        	<label for="todo">What else do i need to do?</label>
        	<input id="todo" name="todo" type="text" placeholder="Add your task">
  		</p>

  		<button type="submit">Submit</button>
<br>
<br>


	</form> -->

	 <form method="POST" enctype="multipart/form-data">
        <p>
            <label for="file1">File to upload: </label>
            <input type="file" id="file1" name="file1">
        </p>
        <p>
            <input type="submit" value="Upload">
        </p>
    
    </form>


</body>









