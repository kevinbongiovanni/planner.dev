<?php



require_once '../inc/address_data_store.php';

$address_book = new AddressDataStore("address_book.csv");

$addressBook = $address_book->read();

if (count($_FILES) > 0 && $_FILES['file1']['error'] == UPLOAD_ERR_OK) {

    var_dump($_FILES);
    
    // Set the destination directory for uploads
    $uploadDir = '/vagrant/sites/planner.dev/public/uploads/';

    // Grab the filename from the uploaded file by using basename
    $filename = basename($_FILES['file1']['name']);

    // Create the saved filename using the file's original name and our upload directory
    $savedFilename = $uploadDir . $filename;

    // Move the file from the temp location to our uploads directory
    move_uploaded_file($_FILES['file1']['tmp_name'], $savedFilename);

    $newAddressObject = new AddressDataStore($savedFilename);

    $newArray = $newAddressObject->read();
    // var_dump($newArray);
    $addressBook = array_merge($addressBook, $newArray);
    // var_dump($addressBook);
    $address_book->write($addressBook);

}

if (!empty($_POST)) {

    var_dump($_POST);

    try {

        if (strlen($_POST["name"]) > 25) {

            throw new Exception("Your name is way too long!");
        }
        if (strlen($_POST["address"]) > 125) {
        
            throw new Exception("Enter a real address!");
        }
        if (strlen($_POST["city"]) > 50) {

            throw new Exception("Enter a real city!");
        }
        if (strlen($_POST["state"]) > 2) {

            throw new Exception("Put in the 2 letter abbreivation!");
        }
        if (strlen($_POST["zip"]) > 5) {

            throw new Exception("Enter a real zip code!");
        }

        $addressBook[] = $_POST;
    
        $address_book->write($addressBook);
    
    }

    catch (Exception $e) {

        // echo "You have one or more of the fields wrong!";
        echo $e->getMessage();
        
    }
}


if(isset($_GET['remove'])) {
        
    $id = $_GET['remove'];
    unset($addressBook[$id]);

  $address_book->write($addressBook);
}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
 
    <title>Address Book</title>
 
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
        <h1>Address Book</h1>
      </div>
    </div>
 
    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-12">
          <h2>Header 2</h2>
          <table class="table table-striped">
                <th>Name</th>
                <th>Address</th>
                <th>City</th>
                <th>State</th>
                <th>Zip</th>

						<? foreach($addressBook as $key => $address): ?>
							<tr>
								<? foreach($address as $info): ?>
									<td><?= $info ?></td>
								<? endforeach; ?>
									<td class="delete"><a href="?remove=<?=$key?>">X</a></td>
							</tr>
						<? endforeach; ?>
					</table>
 
					<form action="/address_book.php" method="POST">
						<input type="text" name="name" placeholder="Name">
						<input type="text" name="address" placeholder="Address">
						<input type="text" name="city" placeholder="City">
						<input type="text" name="state" placeholder="State">
						<input type="text" name="zip" placeholder="Zip">
						<input type="submit" value="Save">
					</form>
 
        </div>
      </div>
 
        <form action="address_book.php" method="post" enctype="multipart/form-data">
            <!-- Select file to upload: -->
            <p>
                <label for="file1">File to upload: </label>
                <br>
                <input type="file" name="file1" id="file1">
            </p>
        <br>
        <br>
            <!-- <input type="submit" value="" name="submit"> -->
            <button type="submit">Upload</button>
        </form>

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