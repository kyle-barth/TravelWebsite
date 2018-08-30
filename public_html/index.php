<?php
	require 'pdo.php';

	echo '
		<div class="content">
			<h1 id="search">Search Articles:</h1>
			<div class="jobsNavigation">';
	navbar($pdo);
	echo '
		</div>
		<div id="centerSearchPage">
			<form method="post" action="" id="searchform">
				<label> Search </label>
				<input  type="text" name="query">
				<input  type="submit" name="search" value="search">
			</form>
		</div>
		<div id="centerSearchPage">
			<form method="post" action="" id="searchform">
				<label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;Subscribe to see when an article is posted! </label>
				<input  type="text" name="emailentry">
				<input  type="submit" name="email" value="email">
			</form>
		</div>
	';

	$row = '';
	$skipper = 0;

	if(isset($_POST['search'])){
		$stmt=$articlesTable->search('WHERE CONCAT(title, author) LIKE "%' . $_POST['query'] . '%"', '');
		$skipper = 1;
	}else
		$stmt=$articlesTable->search('', '');

	if ($skipper==0){
		if(isset($_GET['category'])){
			$stmt=$articlesTable->search('WHERE category LIKE "'. $_GET['category'] .'%"', '');
		}
	}

	if(isset($_POST['emailentry'])){
		$subscriber = [
			'email' => $_POST['emailentry'],
		];
		$subscriptionsTable->insert($subscriber);
	}

	desc($stmt, $row);

	require 'foot.php';
?>
