<!--
William Smyth May
2013-05-08
Section AM

This page adds new tasks, as well as deletes old tasks from the given user's todo list.
-->

<?php
include 'common.php';
session_start();
killPage(); //redirects user if not logged in.
$name = $_SESSION['name'];

//adds a new item to the user's todolist file.
if ($_POST["action"] == "add") {
	$item = $_POST['item'];
	file_put_contents ("todo_".$name.".txt", $item."\n", FILE_APPEND);
//Deletes the selected item from the user's todo list file.
} elseif ($_POST["action"] == "delete") {
	$toDie = file ("todo_".$name.".txt");
	$item = $_POST["index"];
	for ($k = 0; $k < count ($toDie); $k++) {
		if (trim($toDie[$k]) === trim($item)) {
			unset ($toDie[$k]);
		}
	}
	file_put_contents ("todo_".$name.".txt", $toDie);
}
header ('Location: todolist.php');
?>