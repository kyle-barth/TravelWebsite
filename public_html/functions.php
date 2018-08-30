<?php
  // index.php
  function navbar($pdo) {
    // defining $row & $results
  	$results = '';
  	$row = '';

    echo '
      <ul class="nav">
        <li id="searchBy">Search by category: </li>
        <li><a href="?category=%">All Articles</a></li>
    ';

    $stmt = $pdo->prepare('SELECT DISTINCT a.category, c.name FROM WebAssignment2.articles
        a INNER JOIN WebAssignment2.categories c ON a.category = c.name');

    $stmt->execute();

    foreach ($stmt as $row) {
      echo '<li><a href=?category=' . $row["category"] . '>' . $row["name"] . '</a></li>';
    }

    echo '
      </ul>
    ';
  }

  // index.php & reply.php
  function desc($results, $row) {
    foreach ($results as $row) {
      echo '
        <div class="linkStyle" id="centerSearchPage">
          <a href="apply.php?article_id=' . $row['article_id'] . '">
      ';
      if (isset($row["title"])){
        echo "<p class='searchResults'>" . $row["title"] . "</p>";
        echo '<p>Date: ' . $row["date"] . "</p>";
        echo '<p id="searchRight">Click to read full article</p></a>';
      }
      echo "<p class='searchResults2'>" . 'Author: ' . $row["author"] . '.<br>' . 'Content: ' . $row["content"] . '.<br></p>';
      echo '<a
              href="http://www.facebook.com/sharer.php?u=192.168.56.2/apply.php?
                article_id=' . $row['article_id'] . '"
              target="_blank"
              title="Click to share">Share on Facebook
            </a>
        </div>
      ';
    }
  }

  // apply.php
  function body($commentsTable, $applyFeedback) {
		echo '
				</h1>
				<h1 id="applyFeedback">' . $applyFeedback . '</h1>
			</div>';

		$row = '';
		$stmt=$commentsTable->search('WHERE article_id =', $_GET['article_id']);
		desc($stmt, $row);

		echo	'
			<div id="centerSearchPage">
				<form class="contentApply" method="post" enctype="multipart/form-data">
					<label>Name: </label>
					<input type="text" name="name" />
					<p><br></p>
					<label>Comment: </label>
					<p></p>
					<input type="text" name="comment" id="cvrLetter" />
					<p><br></p>
					<input type="submit" name="apply" value="Apply"/>
				</form>
			</div>
		';
	}

  // admin
  function sendMail($updated) {
    $loop=$subscriptionsTable->search('','');

    foreach($loop as $val) {
      $msg = $updated ." was updated.";
      $msg = wordwrap($msg,70);
      mail($val['email'], $updatedType . " Updated.", $msg);
    }
  }

	function navbar1($val1, $val2, $val3, $val4, $val5) {
		echo '
			<div class="jobsNavigation">
				<ul class="nav">
					<li id="searchBy">' . $val1 . ' </li>
					<li><a href="sadf7887sdfhjasd7896.php' . $val2 . '</a></li>
					<li><a href="sadf7887sdfhjasd7896.php' . $val3 . '</a></li>
					<li><a href="sadf7887sdfhjasd7896.php' . $val4 . '</a></li>
					<li><a href="sadf7887sdfhjasd7896.php' . $val5 . '</a></li>
				</ul>
			</div>
		';
	}

	function navbar2($function, $userChoice) {
		echo '
			<ul class="nav">
				<li id="searchBy">Search by category: </li>
		';

    $row = '';
		$stmt = $categoriesTable->search('', '');

		foreach ($stmt as $row) {
			echo '<li><a href='. $function .'.php?' . $userChoice . '&category_id=' . $row["category_id"] .
						'>' . $row["name"] . '</a></li>';
		}

		echo '
			</ul>
		';
	}

  function dropCreator($pdo, $tablename, $selectname, $loop) {
    echo '
      <div id="centerSearchPage">
        <form class="contentApply" method="get">
    ';
    dropDownGen($pdo, $tablename, $selectname, $loop, '*');
    echo '
          <input type="hidden" name="userChoice" value="'.$_GET['userChoice'].'">
          <input type="submit" name="dropsubmit" value="Submit"/>
        </form>
      </div>
    ';
  }

  function dropDownGen($pdo, $tablename, $selectname, $loop, $selector) {
    $stmt1 = $pdo->prepare('SELECT ' . $selector . ' FROM ' . $tablename);
    $stmt1->execute();
    echo '<select name="'. $selectname .'">';
    foreach ($stmt1 as $val)
      echo '<option value="' . $val[$loop] . '"'. $val[$loop] .'">' . ($val[$loop]) . '</option>';
    echo '</select><p>';
  }

  // Generates the form in which the admin enters ad submits variables
  function formGen($pdo, $tablename){
    $stmt = $pdo->prepare('SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = :tablename AND table_schema = "WebAssignment2" AND ordinal_position > 1');
    $criteria = [
      'tablename' => $tablename
    ];
    $stmt->execute($criteria);

    echo '
      <div id="centerSearchPage">
        <form class="contentApply" method="post">
    ';
    foreach ($stmt as $row) {
      echo '<label>' . ($row['COLUMN_NAME']) . ':</label>';
      if ($row['COLUMN_NAME'] == 'category') {
        dropDownGen($pdo, 'categories', 'category', 'name', '*');
      }
      else
      {
        echo '
            <input type="text" name="' . $row["COLUMN_NAME"] . '" />
            <p></p>
        ';
      }
    }
    echo '
          <input type="submit" name="submit" value="Submit"/>
        </form>
      </div>
    ';
  }

  // 1 ) 	Inputs the variables into "navbar" and also changes "userChoice" depending
	// 			on what option the user has selected.
	// 2 )	Displays the relevant content depending on the value stores in "userChoice".
	function pageBuilder($pdo, $commentsTable, $articlesTable, $categoriesTable, $usersTable) {
	  navbar1('Manage: ','?userChoice=1">Articles', '?userChoice=5">Comments',
					'?userChoice=7">Categories', '?userChoice=11">Admin');
    if (isset($_GET['userChoice'])) {
      switch ($_GET['userChoice']) {
		    case 1: // articles navbar 1
		      navbar1('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;','?userChoice=2">Add', '?userChoice=3">Delete' ,
									'?userChoice=4">Edit', '');
		      break;
		    case 2: // add article
          titleGen('Add an article');
          formGen($pdo, 'articles');

          if(isset($_POST['submit'])) {
            $article = [
              'title' => $_POST['title'],
              'author' => $_POST['author'],
              'date' => $_POST['date'],
              'content' => $_POST['content'],
              'category' => $_POST['category'],
            ];
            $articlesTable->insert($article);
          }
		      break;
		    case 3: // delete article
          titleGen('Delete an article');
          dropCreator($pdo, 'articles', 'article', 'title', '*');
          if(isset($_GET['article'])) {
            $articlesTable->delete('title', $_GET['article']);
            header("Location: http://192.168.56.2/sadf7887sdfhjasd7896.php?userChoice=3");
            header("Refresh:0");
          }
		      break;
				case 4: // edit article
          titleGen('Edit an article');
          dropCreator($pdo, 'articles', 'article', 'title', '*');

          if(isset($_GET['article'])) {
            formGen($pdo, 'articles');
            $pk = $_GET['article'];
          }

          if(isset($_POST['submit'])) {
            $article = [
              'title' => $_POST['title'],
              'author' => $_POST['author'],
              'date' => $_POST['date'],
              'content' => $_POST['content'],
              'category' => $_POST['category'],
            ];
            $articlesTable->update($article, $pk);
          }
		      break;

				case 5: // comment navbar 1
          navbar1('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  &nbsp;&nbsp;&nbsp;','?userChoice=6">Delete', '?userChoice=">' ,
                  '?userChoice=">', '');
					break;
				case 6: // delete comment
          titleGen('Delete a comment');
          dropCreator($pdo, 'comments', 'comment', 'content');
          if(isset($_GET['comment'])) {
            $commentsTable->delete('content', $_GET['comment']);
            header("Location: http://192.168.56.2/sadf7887sdfhjasd7896.php?userChoice=6");
            header("Refresh:0");
          }

		      break;

				case 7: // category navbar 1
          navbar1('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;','?userChoice=8">Add', '?userChoice=9">Delete' ,
                '?userChoice=10">Edit', '');
		      break;
				case 8: // add category
          titleGen('Add a category');
          formGen($pdo, 'categories');

          if(isset($_POST['submit'])) {
            $category = [
              'name' => $_POST['name'],
            ];
            $categoriesTable->insert($category);
          }
					break;
				case 9: // delete category
          titleGen('Delete a category');
          dropCreator($pdo, 'WebAssignment2.categories WHERE name NOT IN ( SELECT category FROM WebAssignment2.articles)', 'category', 'name', 'name', 'name');
          if(isset($_GET['category'])) {
            $categoriesTable->delete('name', $_GET['category']);
            header("Location: http://192.168.56.2/sadf7887sdfhjasd7896.php?userChoice=9");
            header("Refresh:0");
          }

					break;
				case 10: // edit category
          titleGen('Edit a category');
          dropCreator($pdo, 'WebAssignment2.categories WHERE name NOT IN ( SELECT category FROM WebAssignment2.articles)', 'category', 'name', 'name', 'name');

          if(isset($_GET['category'])) {
            formGen($pdo, 'categories');
            $pk = $_GET['category'];
          }

          if(isset($_POST['submit'])) {
            $category = [
              'name' => $_POST['name']
            ];
            $categoriesTable->update($category, $pk);
          }

          break;

        case 11: // admin navbar 1
          navbar1('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;','?userChoice=12">Add', '?userChoice=13">Delete' ,
                '?userChoice=">', '');
		      break;
        case 12: // add admin
          titleGen('Add an admin');
          formGen($pdo, 'user');

          if(isset($_POST['submit'])) {
            $user = [
              'username' => $_POST['username'],
              'password' => $_POST['password'],
            ];
            $usersTable->insert($user);
          }
  	      break;
        case 13: // delete admin
          titleGen('Delete an admin');
          dropCreator($pdo, 'WebAssignment2.user where username != "itcadmin"', 'user', 'username', 'username', 'username');
          if(isset($_GET['user'])) {
            $usersTable->delete('username', $_GET['user']);
            header("Location: http://192.168.56.2/sadf7887sdfhjasd7896.php?userChoice=13");
            header("Refresh:0");
          }

          break;

			}
		}
	}

	// Generates the title for the page
	function titleGen($var) {
		echo '
			<div class="content">
				<h1 id="search">' . $var . '</h1>
			</div>
		';
	}

?>
