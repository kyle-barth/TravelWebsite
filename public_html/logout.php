<?php
	session_start();
	unset($_SESSION['loggedin']);

	require 'logcheck.php';

	echo '
		<div class="content">
			<form class="contentlogin" action="login.php" method="POST">
				<h1>You have been logged out.</h1>
			</form>
		</div>
	';

	require 'foot.php';
?>
