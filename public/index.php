<?php

//Defines

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'address_book');
define('DB_USER', 'codeup');
define('DB_PASS', 'codeup');

require_once '../db_connect.php';

$limit = 10;


// Inserting 


if (!empty($_POST)) {
    try   {
        foreach($_POST as $key => $value) {
            if($value == '') {
                throw new Exception("Please fill out section '{$key}'.");
            } 
        }

        $query = "INSERT INTO people (first_name, last_name, phone_number, email) VALUES (:first_name, :last_name, :phone_number, :email)";
        $stmt = $dbc->prepare($query);
        
        $stmt->bindValue(':first_name', $_POST['first_name'], PDO::PARAM_STR);
        $stmt->bindValue(':last_name', $_POST['last_name'], PDO::PARAM_STR);
        $stmt->bindValue(':phone_number', $_POST['phone_number'], PDO::PARAM_STR);
        $stmt->bindValue(':email', $_POST['email'], PDO::PARAM_INT);

        $stmt->execute();
    } 

    catch (Exception $e) {
        $msg = $e->getMessage() . PHP_EOL;
    } 
}  

// Page Number

if (!isset($_GET['page'])) {
    $offsetNum = 0;
    $page = 1; 

} else {
    $page = $_GET['page'];
    $offsetNum = ($page != 1) ? ($page - 1) * $limit: 0;
}

// Remove

if(isset($_GET['remove'])){

    $key = $_GET['remove'];
    // Remove from array
    $query = "DELETE FROM people WHERE id=:id;";
    $stmt = $dbc->prepare($query);
    $stmt->bindValue(':id', $key, PDO::PARAM_INT);
    
    $stmt->execute();
}



// Address Query
$addressStmt = $dbc->prepare(
    'SELECT * FROM addresses
     LIMIT :limit OFFSET :offsetNum'
);

$addressStmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$addressStmt->bindValue(':offsetNum', $offsetNum, PDO::PARAM_INT);
$addressStmt->execute();



// People Query
$personStmt = $dbc->prepare(
    'SELECT * FROM people ORDER BY last_name
     LIMIT :limit OFFSET :offsetNum'
);

$personStmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$personStmt->bindValue(':offsetNum', $offsetNum, PDO::PARAM_INT);
$personStmt->execute();


// Trying to Join Tables
$joinedQuery = 'SELECT first_name, last_name, street, city, state, zip
    FROM addresses AS a
    LEFT JOIN people AS p
    ON p.id = a.person_id';

$joinedStmt = $dbc->query($joinedQuery);


$count = $dbc->query('SELECT count(*) FROM people')->fetchColumn();
$numPages = ceil($count / $limit);

$page = isset($_GET['page']) ? $_GET['page'] : 1;

$nextPage = $page + 1;

$prevPage = $page - 1;

$offset = ($page - 1) * 4;


?>

<!-- heading -->
<?
// require_once '../inc/header.php';
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



  <div class="container">
  <div class="jumbotron">
    <h1 align =center >Address Book!</h1>
    <p align =center >Save your contact information here!</p> 
  </div>


    <div class="container">
        <!-- Display table -->
        <h1 id="headline">Address Book</h1>

        <table border="1" align=center class="table table-hover">
            <th>Person</th>
            <th>Address</th>
        <?php



        while ($row = $personStmt->fetch(PDO::FETCH_ASSOC)) :
        ?>
            <tr><td valign="top"><strong><?=$row['first_name']." ".$row['last_name']?></strong><br>

            <?=$row['phone_number']?><br>

            <?=$row['email']?><br>


            <a class="btn btn-sm btn-primary" href="edit_person.php?id=<?=$row['id']?>">Edit</a>&nbsp;<br>
            <a href="?remove=<?=$row['id']?>">Remove</a>
            </td>
            <td valign="top">
            <table width="100%" class="inner-table">
            <?php
            $sql="SELECT * FROM addresses WHERE person_id=".$row['id']."";
            $addresses = $dbc->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            foreach ($addresses as $address) {
                echo "<tr><td>".$address['street']."<br>".$address['city']." ".$address['state']." ".$address['zip']."<br>";
            ?>
            </td>
            <td width="20"></td>
            <td align="right">
                <a class="btn btn-primary btn-sm" href="edit_address.php?id=<?=$address['id']?>">Edit</a>&nbsp;
                <td class=""><a href="?remove=<?=$address['id']?>">Remove</a></td>
            </td></tr>
        
            <?php
            }
            ?>
            </table>
                <a class="btn btn-primary btn-sm" href="add_address.php?id=<?=$row['id']?>">New Address</a>&nbsp;
            </td></tr>
        <?php
        endwhile;
        ?>
        </table>
    </div>

<!-- form to enter a new person -->


    <div class="container">
         <h1 align=center id="headline">Add a person!</h1>

        <form class="form-inline" id="item-form" method="POST" action="index.php">
        </form>
    </div>

    <form align=center action="/index.php" method="POST" ecntype="multipart/form-data"/>
        <input type="text" name="first_name" placeholder="First Name"><br>
        <input type="text" name="last_name" placeholder="Last Name"><br>
        <input type="text" name="phone_number" placeholder="Phone Number"><br>
        <input type="text" name="email" placeholder="Email"><br>

        <input type="submit" value="Save">
    </form>

    
    <ul align=center class="pager">
        <?if($page !== 1): ?>
            <a href="/index.php?page=<?= $prevPage; ?>"> <--  </a> 
        <? endif; ?>  
        
        <?if ($page < $numPages && $page != 1) : ?>
            <a href="/index.php?page=<?= $prevPage; ?>">  <--  </a>
            <a href="/index.php?page=<?= $nextPage; ?>">  -->  </a>
        <? endif; ?>  
      
        <? if ($page !== $numPages) : ?>
            <a href="/index.php?page=<?= $nextPage; ?>"> --> </a>
        <?endif; ?>
    </ul>

</html>