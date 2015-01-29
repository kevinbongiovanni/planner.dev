<?php 


define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'todo_list');
define('DB_USER', 'codeup');
define('DB_PASS', 'codeup');


require_once('db_connect.php');


$name = 'CREATE TABLE name (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    first VARCHAR(250) NOT NULL,
    last VARCHAR(250) NOT NULL,
    PRIMARY KEY (id)
)';

// $dbc->exec($to_do);
$dbc->exec($name);

?>