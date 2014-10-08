<!DOCTYPE html>

<!--
William Smyth May
2013-05-08
Section: AM

This is the log in page for Don't Forget the Cow.
-->
<html>
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
		include 'common.php';
		heading();
		?>

		<div id="main">
			<p>
				The best way to manage your tasks. <br />
				Never forget the cow (or anything else) again!
			</p>

			<p>
				Log in now to manage your to-do list. <br />
				If you do not have an account, one will be created for you.
			</p>

			<form id="loginform" action="login.php" method="post">
				<div><input name="name" type="text" size="8" autofocus="autofocus" /> <strong>User Name</strong></div>
				<div><input name="password" type="password" size="8" /> <strong>Password</strong></div>
				<div><input type="submit" value="Log in" /></div>
			</form>

			<p>
				<em>(last login from this computer was <?= $_COOKIE['loginTime'] ?>)</em>
			</p>
		</div>
		<?php
		footer();
		?>
	</body>
</html>
