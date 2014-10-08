<!--
William Smyth May
2013-05-08
Section: AM
-->

<?php //This is the logout page for Don't Forget the Cow.
session_start();
session_destroy();
session_regenerate_id(TRUE);
header ('Location: start.php');
?>