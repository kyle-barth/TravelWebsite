<?php
	// If the user is trying to access the admin side and is not logged in,
	// redirect them to the homepage.
	if (!isset($_SESSION['loggedin']) && (stripos($_SERVER['REQUEST_URI'], 'sadf7887sdfhjasd7896.php') ||
		(stripos($_SERVER['REQUEST_URI'], 'delete.php')))) {
			header('Location: index.php');
	}

	// If user is logged in as admin, have a "Logout" button display where "Login" was,
	// and add an admin page to the navbar accross all pages.
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
		head('Home', '<a href="logout.php">Logout</a>', '<li><a href="sadf7887sdfhjasd7896.php">Admin</a></li>');
	}
	// Else, button still says "Login", and "$admin" doesn't pass the variable to add an admin
	// page to the navbar accross all pages.
	else {
		head('Home', '<a href="login.php">Login</a>', '');
	}

	function head($heading, $logstat, $admin){
		require 'head.php';
	}
?>
