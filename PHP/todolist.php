<!DOCTYPE html>

<!--
William Smyth May
2013-05-08
Section: AM

This is the todolist page for the current user on Don't forget the Cow.
-->
<html>
	<?php
	include 'common.php';
	session_start();
	killPage();
	?>
	<head>
		<meta charset="utf-8" />
		<title>Remember the Cow</title>
		<link href="https://webster.cs.washington.edu/css/cow-provided.css" type="text/css" rel="stylesheet" />
		<link href="cow.css" type="text/css" rel="stylesheet" />
		<link href="https://webster.cs.washington.edu/images/todolist/favicon.ico" type="image/ico" rel="shortcut icon" />
		<script src="https://webster.cs.washington.edu/js/todolist/provided.js" type="text/javascript"></script>
	</head>

	<body>
		<?php
		heading();
		$name = $_SESSION['name'];
		exist($name);
		?>

		<div id="main">
			<h2><?= $name ?>'s To-Do List</h2>

			<ul id="todolist">
				<?php //Verifies again that the file exists. Adds items to the todo list page
				if (file_exists ("todo_".$name.".txt")) {
					$items = file ("todo_".$name.".txt");
					$i = 0;
					foreach ($items as $item) {
						addItem($item);
					}
				}
				newItem();
				?>
			</ul>

			<div>
				<a href="logout.php"><strong>Log Out</strong></a>
				<em>(logged in since <?= $_COOKIE['loginTime'] ?>)</em>
			</div>

		</div>
		<?php
		footer();
		?>
	</body>
</html>
