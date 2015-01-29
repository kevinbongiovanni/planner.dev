<?php 

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'todo_list');
define('DB_USER', 'codeup');
define('DB_PASS', 'codeup');

require_once('../db_connect.php');

    // The "forward" link


if (!empty($_POST)) {
    try   {
        foreach($_POST as $key => $value) {
            if($value == '') {
	            throw new Exception("Please fill out section '{$key}'.");
            } 
        }

        $query = "INSERT INTO to_do (activity, date_established, description, priority_id) VALUES (:activity, :date_established, :description, :priority_id)";
        $stmt = $dbc->prepare($query);
        
        $stmt->bindValue(':activity', $_POST['activity'], PDO::PARAM_STR);
        $stmt->bindValue(':date_established', $_POST['date_established'], PDO::PARAM_STR);
        $stmt->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
        $stmt->bindValue(':priority_id', $_POST['priority_id'], PDO::PARAM_INT);

        $stmt->execute();
    } 

    catch (Exception $e) {
        $msg = $e->getMessage() . PHP_EOL;
    } 
}  

if(isset($_GET['remove'])){

    $key = $_GET['remove'];
    // Remove from array
    $query = "DELETE FROM to_do WHERE id=:id;";
    $stmt = $dbc->prepare($query);
    $stmt->bindValue(':id', $key, PDO::PARAM_INT);
    
    $stmt->execute();
}

$limit = 4;

$count = $dbc->query('SELECT count(*) FROM to_do')->fetchColumn();
$numPages = ceil($count / $limit);

$page = isset($_GET['page']) ? $_GET['page'] : 1;

$nextPage = $page + 1;

$prevPage = $page - 1;

$offset = ($page - 1) * 4;
    
$stmt = $dbc->prepare('SELECT id, activity, date_established, description, priority_id FROM to_do LIMIT :limit OFFSET :offset');
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$getItems = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
 
    <title>To Do List</title>

    <script src = "/js.jquery.min.js"></script>

 

  </head>
 
    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">



<? if(isset($msg)) : ?>
    <h3><?= $msg; ?></h3>
<? endif; ?>
    
    <!-- Table -->
<div class="container">
    <h1>To Do List</h1>

    <table class="table table-hover table-bordered" border="1">
    <tr>
      <td>Priority</td>
      <td>Name</td>
      <td>Date Established</td>
      <td>Description</td>

    <tr/>


    <? foreach($getItems as $key => $List_items): ?>
		<tr>
			<td><?= $List_items['priority_id']; ?></td>
			<td><?= $List_items['activity']; ?></td>
			<td><?= $List_items['date_established']; ?></td>
			<td><?= $List_items['description']; ?></td>
			<td class=""><a href="?remove=<?=$List_items['id']?>">&#10003;</a></td>
		</tr>
	<? endforeach; ?>



    </table>

    <!-- Pagination -->
    <ul class="pager">
    	<?if($page == 1): ?>
        	<li class="active"><a href="/to_do_list_sql.php?page=<?= $nextPage; ?>">Next</a></li>
      	<? endif; ?>  
    	
    	<?if ($page < $numPages && $page != 1) : ?>
        	<li class="active"><a href="/to_do_list_sql.php?page=<?= $prevPage; ?>">Previous</a></li>
        	<li class="active"><a href="/to_do_list_sql.php?page=<?= $nextPage; ?>">Next</a></li>
      	<? endif; ?>  
      
      	<? if ($page == $numPages) : ?>
        	<li class="active"><a href="/to_do_list_sql.php?page=<?= $prevPage; ?>">Previous</a></li>
      	<?endif; ?>
    </ul>
</div>


</table>



<form action="/to_do_list_sql.php" method="POST" ecntype="multipart/form-data"/>
	<input type="text" name="activity" placeholder="activity">
	<input type="text" name="date_established" placeholder="Date Established">
	<input type="text" name="description" placeholder="Description">
	<input type="text" name="priority_id" placeholder="Priority">
	<input type="submit" value="Save">
</form>




<table class="table table-hover table-bordered" border="1">
    <tr>
      <td>*Priorities*</td>
      <td>Personal = 1</td>
      <td>School = 2</td>
      <td>Extra = 3</td>

    <tr/>

    

 
</html>


