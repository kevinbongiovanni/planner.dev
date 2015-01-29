<?



require_once '../inc/todo_data_store.php';

$to_do_list = new ToDoDataStore("todo.txt");

$List = $to_do_list->read();

var_dump($to_do_list);

if (count($_FILES) > 0 && $_FILES['file1']['error'] == UPLOAD_ERR_OK) {
    
    // Set the destination directory for uploads
    $uploadDir = '/vagrant/sites/planner.dev/public/uploads/';

    // Grab the filename from the uploaded file by using basename
    $filename = basename($_FILES['file1']['name']);

    // Create the saved filename using the file's original name and our upload directory
    $savedFilename = $uploadDir . $filename;

    // Move the file from the temp location to our uploads directory
    move_uploaded_file($_FILES['file1']['tmp_name'], $savedFilename);

        $newList = new ToDoDataStore($savedFilename);
        $newArray = $newList->read();
        // var_dump($newArray);
        $List = array_merge($List, $newArray);
        // var_dump($List);
        $to_do_list->write($List);
}

if (!empty($_POST)) {
    
  var_dump($_POST);

    try {

        if (strlen($_POST["todo"]) > 30) {

        throw new CustomException("Your task is too long, try to make is shorter!");
        }

        $List[] = $_POST['todo'];

        $to_do_list->write($List);
  
    }

    catch (CustomException $e) {

        echo $e->getMessage();
  
    }

} 

 

if(isset($_GET['remove'])) {
		
	$id = $_GET['remove'];
	unset($List[$id]);

  $to_do_list->write($List);

}



?>
<html>
<head>
<title> To Do List</title>
</head>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
 
    <title>To Do List</title>
 
    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
 
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
 
  <body>
 

    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <!-- <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> -->
            <!-- <span class="sr-only">Toggle navigation</span> -->
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!-- <a class="navbar-brand" href="#">Addresses</a> -->
        </div>
        
      </div>
    </nav>
 
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>What do i need to do?</h1>
      </div>
    </div>
 
  <div class="container">
      <!-- Example row of columns -->
     <div class="row">
     	<div class="col-md-12">
 
				
			<form method="POST" action="todo_list.php">
  				<p>
        			<label for="todo">What else do i need to do?</label>
        			<input id="todo" name="todo" type="text" placeholder="Add your task">
  				</p>
		
			<button type="submit">Submit</button>
<br>
<br>
			</form>

	<table class="table table-striped">
            <th>List</th>

				<? foreach($List as $key => $value): ?>
					<tr>
							<td><?= $value ?></td>
							<td class="delete"><a href="?remove=<?=$key?>">X</td>
					</tr>
				<? endforeach; ?>
	</table>

			<form action="todo_list.php" method="post" enctype="multipart/form-data">
			    <p>
    				<label for="file1">File to upload: </label>
    				<br>
    				<input type="file" name="file1" id="file1">
    			</p>
				<br>
				<br>
   				<input type="submit" value="Upload File" name="submit">
			</form>
    	</div>
      </div> 

    <hr>
 
    <footer>
        <p>&copy; Company 2014</p>
    </footer>
    </div> <!-- /container -->
 
 
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
  </body>
</html>
