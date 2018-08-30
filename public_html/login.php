<?php
	include 'pdo.php';

	function navbar3() {
		echo '
			<div class="jobsNavigation">
				<ul class="nav">
					<li><a href="sadf7887sdfhjasd7896.php?">Continue</a></li>
				</ul>
			</div>
		';
	}

	if (isset($_POST['submit'])) {
		$stmt = $pdo->prepare("SELECT * FROM WebAssignment2.user WHERE username =
													:username AND password = :password");

		$criteria = [
 			'username' => $_POST['username'],
 			'password' => $_POST['password']
		];

		$stmt->execute($criteria);

		if ($stmt->rowCount() > 0) {
 			$user = $stmt->fetch();
 			$_SESSION['loggedin'] = true;
			echo 'Welcome back ' . $_POST['username'] . '.';
			navbar3();
		}
		else {
 			echo 'Sorry, your username and password could not be found';
		}

	}
	//The submit button was not pressed, show the log-in form
	else {
		// require 'logcheck.php';

		echo '
			<div class="content">
				<form class="contentlogin" action="login.php" method="POST">
					<h1>Login</h1>
					<label>Username: </label>
					<input type="text" name="username" />
					<label>Password: </label>
					<input type="password" name="password" />
					<input type="submit" name="submit" value="Log In" />
				</form>
			</div>
		';
	}
?>
