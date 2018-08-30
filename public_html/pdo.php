<?php
	// start session
	session_start();

	// includes
	include 'DatabaseTable.php';

	// defining pdo and the schema
	$pdo = new PDO('mysql:dbname=WebAssignment2;host=192.168.56.2', 'student', 'student');
	$schema = 'WebAssignment2.';

	// defining the needed objects
	$commentsTable = new DatabaseTable($pdo, $schema . 'comments');
	$articlesTable = new DatabaseTable($pdo, $schema . 'articles');
	$categoriesTable = new DatabaseTable($pdo, $schema . 'categories');
	$usersTable = new DatabaseTable($pdo, $schema . 'user');
	$subscriptionsTable = new DatabaseTable($pdo, $schema . 'subscriptions');

	// requires
	require 'logcheck.php';
	require 'functions.php';
?>
