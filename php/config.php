<?php
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'biblio';
	
	$options = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	);
    
    $sql_connection = new PDO('mysql:host='.$host.';dbname='.$dbname, $username, $password, $options);
?>