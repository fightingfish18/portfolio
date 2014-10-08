<?php
//Similar to killPage(), however, at this point, session has not been set.
if (!isset ($_POST['name'])) {
	header ('Location: start.php');
	die();
}
$users = file("users.txt", FILE_IGNORE_NEW_LINES);
$validName = '/^[a-z][a-z0-9]{2,7}$/';
$validPassword = '/^\d.{4,10}[^0-9a-zA-Z]/';
$verify = false;
$name = $_POST['name'];
$password = $_POST['password'];

//Checks to see if the user exists in the users.txt file
foreach ($users as $user) {
	$data = explode (':', $user);
	$trueUser = $data[0];
	$truePass = $data[1];
	if ($trueUser === $name && $truePass === $password) {
		$verify = true;
		break;
	} else if ($trueUser === $name && $truePass != $password) {
		header('Location: start.php');
		die();
	}
}

//If the user exists, verifies that the proper password was used.
//If the user does not exist, verifies that the provided username and password meet the expectations.
if(!preg_match ($validName, $name) | !preg_match ($validPassword, $password)) {
	header('Location: start.php');
	die();
//If a new acount meets standards, creates the new account.
} elseif ($verify == false && preg_match ($validName, $name) && preg_match ($validPassword, $password)) {
	file_put_contents('users.txt', $name.':'.$password."\n", FILE_APPEND);
	$verify = true;
}
//Redirects users to todolist.php
//Begins the current login session, as well as setting the "lastLogin" time.
if ($verify == true) {
	print ('hit this first');
	session_start();
	$_SESSION['name'] = $name;
	setcookie ('loginTime', date ("D y M d, g:i:s a"), time() + (60 * 60 * 24 * 7));
	header('Location: todolist.php');
}
?>