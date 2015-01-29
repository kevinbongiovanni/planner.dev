<?php 


define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'todo_list');
define('DB_USER', 'codeup');
define('DB_PASS', 'codeup');


require_once('db_connect.php');

$to_do = [
	[
	'activity' => 'Wash Car',
	'date_established' => '2015-01-10',
	'description' => 'The car is dirty, time to wash it!',
	'priority' => '1'
	],
	[
	'activity' => 'Buy Beer',
	'date_established' => '2015-01-05',
	'description' => 'I have no more beer!',
	'priority' => '2'
	],
	[
	'activity' => 'Do Laundry',
	'date_established' => '2015-01-15',
	'description' => 'Have not done laundry in a week, time to do it!',
	'priority' => '3'
	],
	[
	'activity' => 'Buy Food',
	'date_established' => '2015-01-20',
	'description' => 'Ran out of food!',
	'priority' => '4'
	],
	[
	'activity' => 'Go to gym',
	'date_established' => '2015-01-22',
	'description' => 'I need to work off all the food I eat!',
	'priority' => '5'
	]
];

// $priorities = [
// 	[
// 	'priority' => '1',
// 	'importance' => 'Personal'
// 	],
// 	[
// 	'priority' => '2',
// 	'importance' => 'School'
// 	],
// 	[
// 	'priority' => '3',
// 	'importance' => 'Extra Stuff'
// 	]
// ];






$stmt = $dbc->prepare('INSERT INTO to_do (activity, date_established, description, priority) VALUES (:activity, :date_established, :description, :priority)');

foreach ($to_do as $value) {

	// var_dump($value);
	// echo $value['activity'] . PHP_EOL;

	$stmt->bindValue(':activity', $value['activity'], PDO::PARAM_STR);

	$stmt->bindValue(':date_established', $value['date_established'], PDO::PARAM_STR);

	$stmt->bindValue(':description', $value['description'], PDO::PARAM_STR);

	$stmt->bindValue(':priority', $value['priority'], PDO::PARAM_STR);
	
	
	$stmt->execute();

// $stmt = $dbc->prepare('INSERT INTO priorities (priority, importance) VALUES (:priority, :importance)');

// foreach ($priorities as $value) {

// 	$stmt->bindValue(':priority', $value['priority'], PDO::PARAM_STR);

// 	$stmt->bindValue(':importance', $value['importance'], PDO::PARAM_STR);

// 	$stmt->execute();




// 	echo "Inserted ID: " . $dbc->lastInsertId() . PHP_EOL;

}
	