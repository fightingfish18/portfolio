<!--
William Smyth May
2013-05-15
Section: AM
This is the common page where functions used in multiple pages are stored
-->

<?php //The bottom banner and validators for the site.
function footing() { ?>
	<div id="w3c">
		<a href="https://webster.cs.washington.edu/validate-html.php"><img src="https://webster.cs.washington.edu/images/w3c-html.png" alt="Valid HTML5" /></a>
		<a href="https://webster.cs.washington.edu/validate-css.php"><img src="https://webster.cs.washington.edu/images/w3c-css.png" alt="Valid CSS" /></a>
	</div>
<?php } ?>

<?php //The top banner for the site. 
function banner() { ?>
	<div id="banner">
		<a id="floatImage" href="index.php"><img src="https://webster.cs.washington.edu/images/kevinbacon/mymdb.png" alt="banner logo" /></a>
		<span id="bannerText">My Movie Database</span>
	</div>
<?php } ?>

<?php //The search boxes for the site.  Users can enter a name to see movies and movies with Bacon. 
function forms() { ?>
	<!-- form to search for every movie by a given actor -->
	<form action="search-all.php" method="get">
		<fieldset>
			<legend>All movies</legend>
			<div>
				<input name="firstname" type="text" size="12" placeholder="first name" autofocus="autofocus" /> 
				<input name="lastname" type="text" size="12" placeholder="last name" /> 
				<input type="submit" value="go" />
			</div>
		</fieldset>
	</form>

	<!-- form to search for movies where a given actor was with Kevin Bacon -->
	<form action="search-kevin.php" method="get">
		<fieldset>
			<legend>Movies with Kevin Bacon</legend>
			<div>
				<input name="firstname" type="text" size="12" placeholder="first name" /> 
				<input name="lastname" type="text" size="12" placeholder="last name" /> 
				<input type="submit" value="go" />
			</div>
		</fieldset>
	</form>
<?php } ?>

<?php //This is the heading for all files.  <head> tags not included, as the title is different for each page.
function heading() { ?>
	<!-- Links to provided files.  Do not edit or remove these links -->
	<link href="https://webster.cs.washington.edu/images/kevinbacon/favicon.png" type="image/png" rel="shortcut icon" />
	<script src="https://webster.cs.washington.edu/js/kevinbacon/provided.js" type="text/javascript"></script>

	<!-- Link to your CSS file that you should edit -->
	<link href="bacon.css" type="text/css" rel="stylesheet" />
<?php } ?>

<?php //This function fetches all the movies a given actor was in.
function actorMovie($idNum, $firstName, $lastName, $firstName2, $lastName2) {
	$db = new PDO("mysql:dbname=imdb;host=localhost", "wsmay1", "SYQS9hiDQDjFy");
	$idNum = $db->quote($idNum);
	$query = "SELECT name, year FROM movies m JOIN roles r ON r.movie_id = m.id 
			JOIN actors a ON a.id = r.actor_id WHERE a.id = $idNum ORDER BY year DESC, name ASC;";
	$rows = $db->query($query);
	$k = 0;
	if($rows->rowCount() == 0) {
     $k = -1;
	}
	tables($rows, $firstName, $lastName, $firstName2, $lastName2, $k);
} ?>

<?php //This function fetches an actor's ID number
function actorId($firstName, $lastName) {
	$db = new PDO("mysql:dbname=imdb;host=localhost", "wsmay1", "SYQS9hiDQDjFy");
	$firstName = $db->quote($firstName.'%');
	$lastName = $db->quote($lastName);
	$query = "SELECT id FROM actors WHERE first_name like $firstName and last_name = $lastName ORDER BY film_count DESC, id ASC LIMIT 1;";
	$idNum = $db->query($query);
	foreach ($idNum as $number) {
		return $number['id'];
	}
 } ?>
 
 <?php //This function makes a query to get the results with Kevin Bacon
 function kevinBacon($idNum, $idNum2, $firstName, $lastName, $firstName2, $lastName2) {
	$db = new PDO("mysql:dbname=imdb;host=localhost", "wsmay1", "SYQS9hiDQDjFy");
	$actorId = $db->quote($idNum);
	$actorId2 = $db->quote($idNum2);
	$query = "SELECT DISTINCT name, year
			  FROM movies m 
			  JOIN roles r ON r.movie_id = m.id 
			  JOIN actors a ON r.actor_id = a.id
			  JOIN roles r1 ON r1.movie_id = m.id
			  JOIN actors a1 ON r1.actor_id = a1.id
			  WHERE a.id = $actorId
			  AND a1.id = $actorId2
			  AND r1.movie_id = m.id
			  AND r.movie_id = m.id
			  ORDER BY m.year DESC, m.name ASC;";
	$k = 0;
	$results = $db->query($query);
	if($results->rowCount() == 0) {
     $k = -1;
	}
	tables($results, $firstName, $lastName, $firstName2, $lastName2, $k);
}
?>

<?php //This function displays the table of results for the actor or the actor with Kevin Bacon
function tables($rows, $firstName, $lastName, $firstName2, $lastName2, $k) {
	$i = 1; ?>
	<div id="tableArea">
		<?php
		if ($k == -1) {
			if ($firstName2 != " " && $lastName2 != " ") {
				errorBacon($firstName, $lastName, $firstName2, $lastName2);
			} else {
				errorActor($firstName, $lastName);
			}
		} else { ?>
			<table>
				<?php 
				if ($firstName2 != " " && $lastName2 != " ") {
					captionBacon($firstName, $lastName, $firstName2, $lastName2);
				} else {
					caption($firstName, $lastName);
				} ?>	
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Year</th>
				</tr>
				<?php foreach ($rows as $row) {
					if ($i % 2 == 0) { ?>
						<tr>
							<td><?= $i.'.' ?></td>
							<td><?= $row['name'] ?></td>
							<td><?= $row['year'] ?></td>
						</tr>
				<?php } else { ?>
						<tr class="striped">
							<td><?= $i.'.' ?></td>
							<td><?= $row['name'] ?></td>
							<td><?= $row['year'] ?></td>
						</tr>
				<?php } 
					$i++;
				} 
				?>	
			</table>
		<?php } ?>
	</div>
<?php } ?>

<?php //Caption for the table of all movies an actor has been in. 
function caption($firstName, $lastName) { ?>
	<caption>All films with <?= $firstName ?> <?= $lastName ?></caption>
<?php } ?>

<?php //Caption for the table for the movies an actor has been in with Kevin Bacon. 
function captionBacon($firstName, $lastName, $firstName2, $lastName2) { ?>
	<caption>Movies with <?= $firstName ?> <?= $lastName?> and <?= $firstName2 ?> <?= $lastName2 ?></caption>
<?php } ?>

<?php //Error message if an actor was in no movies with Kevin Bacon.
function errorBacon($firstName, $lastName, $firstName2, $lastName2) { ?>
	<p><?= $firstName ?> <?= $lastName ?> was not in any movies with <?= $firstName2 ?> <?= $lastName2 ?></p>
<?php } ?>

<?php //Error message if an actor is not found in the database.
function errorActor() { ?>
	<p>Actor not found</p>
<?php } ?>