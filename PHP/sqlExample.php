<?php
//William Smyth May
//2014-04-14
//Programming Assignment 1

//This function queries the database for the given name
//returns the results
function query($name) {
	$pdo = new PDO('mysql:host=info344ass1db.cddyfslrrxki.us-west-2.rds.amazonaws.com;dbname=nbastats', '<INSERT UN>', '<INSERT PW>');
	$name = "%".$name."%";
	$stmt = $pdo->prepare('SELECT * FROM Players WHERE playerName LIKE :name');
	$stmt->execute(array('name' => $name));
	$results = $stmt->fetchAll();
	return $results;
}

//This function builds the table for the results to be displayed in.
function buildTable($results) {
	foreach ($results as $result) {
		echo "<tr>";
			echo "<td>".$result['PlayerName']."</td>";
			echo "<td>".$result['GP']."</td>";
			echo "<td>".$result['FGP']."</td>";
			echo "<td>".$result['TPP']."</td>";
			echo "<td>".$result['FTP']."</td>";
			echo "<td>".$result['PPG']."</td>";
		echo "<tr>";
	}
}