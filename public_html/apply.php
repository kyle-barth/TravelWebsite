<?php
	require 'pdo.php';

	echo '
		<div class="content">
			<h1 id="search">
	';

	if (!isset($applyFeedback)) {
		body($commentsTable, "", $pdo);
	}
	else {
		body($commentsTable, $applyFeedback, $pdo);
	}

	// Apply
	if(isset($_POST['apply'])) {
			$comment = [
				'article_id' => $_GET['article_id'],
				'author' => $_POST['name'],
				'content' => $_POST['comment'],
			];
			$commentsTable->insert($comment);
			header("Refresh:0");
	}

	require 'foot.php';
?>
