<!--
William Smyth May
2013-05-08
This is the common.php page for Don't Forget the Cow.
-->

<?php //This function displays the banner at the top of the page.
function heading() { ?>
	<div class="headfoot">
		<h1>
			<img src="https://webster.cs.washington.edu/images/todolist/logo.gif" alt="logo" />
			Remember<br />the Cow
		</h1>
	</div>
<?php } ?>


<?php //This function displays the banner at the bottom of the page.
function footer() { ?>
	<div class="headfoot">
		<p>
			"Remember The Cow is nice, but it's a total copy of another site." - PCWorld<br />
			All pages and content &copy; Copyright CowPie Inc.
		</p>

		<div id="w3c">
			<a href="https://webster.cs.washington.edu/validate-html.php">
				<img src="https://webster.cs.washington.edu/images/w3c-html.png" alt="Valid HTML" /></a>
			<a href="https://webster.cs.washington.edu/validate-css.php">
				<img src="https://webster.cs.washington.edu/images/w3c-css.png" alt="Valid CSS" /></a>
		</div>
	</div>
<?php } ?>

<?php
function addItem($item) { ?>
	<li>
		<form action="submit.php" method="post">
			<input type="hidden" name="action" value="delete" />
			<input type="hidden" name="index" value="<?= htmlentities($item) ?>" />
			<input type="submit" value="Delete" />
		</form>
		<?= htmlentities($item) ?>
	</li>
<?php } ?>

<?php //This function allows users to add new items to their To-Do list
function newItem() { ?>
	<li>
		<form action="submit.php" method="post">
			<input type="hidden" name="action" value="add" />
			<input name="item" type="text" size="25" autofocus="autofocus" />
			<input type="submit" value="Add" />
		</form>
	</li>
<?php } ?>

<?php //This function kills the page if there is no one logged in.
//Keeps php from crashing.
function killPage() {
	if (!isset ($_SESSION['name'])) {
		header ('Location: start.php');
		die();
	}
}
?>

<?php //This function looks to see if a to-do list exists for the current user.
//If not, creates a new file for the user.
function exist($name) {
	if (!file_exists ("todo_".$name.".txt")) {
		file_put_contents("todo_".$name.".txt", "", FILE_APPEND);
	}
}
?>
