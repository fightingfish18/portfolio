<!DOCTYPE html>

<!--WIlliam Smyth May, Assignment 3, 2013-04-24-->
<!--This is the RancidTomato review page for various movies-->

<!--Gets the film that is being displayed from the URL-->
<?php
	$movie = $_GET["film"];
?>
<html>
	<head>
		<title>Rancid Tomatoes</title>
		<meta charset="utf-8" />
		<link href="movie.css" type="text/css" rel="stylesheet" />
	</head>

	<body>				
		<?php
			banner();
			$title = file("$movie/info.txt", FILE_IGNORE_NEW_LINES);
		?>
		
		<h1 class="central" id="title"><?= $title[0] ?> (<?= $title[1] ?>)</h1>
		
		<div id="main">
			<!--decides which image to display for the rating banner-->
			<?php 
			if ($title[2] < 60) {
				$rating = "rottenlarge";
			} else {
				$rating = "freshlarge";
			  }
			?>
				<div class="rotten">
						<img src="https://webster.cs.washington.edu/images/<?=$rating?>.png" alt="Rotten" />
					<span class="rottenText"><?= $title[2] ?>%</span>
				</div>
			<div id="textImage" class="sidebg">
				<img src="<?=$movie?>/overview.png" alt="general overview" />
				<!--Gets the file for the side bar info-->
				<?php
					$generalInfo = file("$movie/overview.txt");
				?>
				<div id="sidetext">
					<dl>
					<!--Displays the information needed on the sidebar-->
					<?php for ($i = 0; $i < count($generalInfo); $i++) {
							   $sideTitle = explode(":", $generalInfo[$i]); ?>
					
						<dt><?= $sideTitle[0] ?></dt>
						<dd><?= $sideTitle[1] ?></dd>
					<?php } ?>
					</dl>
				</div>
			</div>

		
		<div id="reviewBlock">
			<div id="review">
					
				<div id="codeForReview">
					<!--Gets all of the review files, and keeps count of the number of reviews.-->
					<?php
						$reviewFiles = glob("$movie/review*.txt"); 
						$reviewCount = 0;
					?>
					<!--Increments the number of reviews, and displays the file for the FIRST half of the reviews-->
					<?php for ($i = 0; $i < count($reviewFiles) / 2; $i++) { 
							$reviewCount++;
							$review = file($reviewFiles[$i], FILE_IGNORE_NEW_LINES); 
					?>
					<div class="reviewText">
						<p class="texts">
							<img class="revImg" src="https://webster.cs.washington.edu/images/<?= strtolower($review[1])?>.gif" alt="<?= $review[1] ?>" />	
							<q><?= $review[0] ?></q>
						</p>
					</div>
					
					<p class="reviewer">
						<img class="critic" src="https://webster.cs.washington.edu/images/critic.gif" alt="Critic" />
						<?= $review[2] ?><br />
						<span class="publication"><?= $review[3] ?></span>
					</p>
					<?php } ?>
				</div>
			</div>

			<div id="review2">
				<!--Keeps incrementing the number of reviews, and displays the SECOND half of the reviews-->
				<?php for ($i = count($reviewFiles) / 2; $i < count($reviewFiles); $i++) {
						if (count($reviewFiles) % 2 == 1 && $i == count($reviewFiles) / 2) {
							$i++;
						}
						$reviewCount++;
						$review = file($reviewFiles[$i], FILE_IGNORE_NEW_LINES);
				?>
						
					<div class="reviewText">
						<p class="texts">
							<img class="revImg" src="https://webster.cs.washington.edu/images/<?= strtolower($review[1]) ?>.gif" alt="<?= $review[1] ?>" />		
							<q><?= $review[0] ?></q>
						</p>
					</div>
					
					
					<p class="reviewer">
						<img class="critic" src="https://webster.cs.washington.edu/images/critic.gif" alt="Critic" />
						<?= $review[2] ?><br />
						<span class="publication"><?= $review[3] ?></span>
					</p>
					<?php } ?>
			</div>
		</div>
			<p id="numbers" class="sidebg">(1-<?= $reviewCount ?>) of <?= $reviewCount ?></p>
		
			<div class="rotten">
					<img src="https://webster.cs.washington.edu/images/<?=$rating?>.png" alt="Rotten" />
					<span class="rottenText"><?= $title[2] ?>%</span>
			</div>
		</div>
		<div id="validate">
			<a href="https://webster.cs.washington.edu/validate-html.php"><img src="https://webster.cs.washington.edu/images/w3c-html.png" alt="Valid HTML5" /></a><br />
			<a href="https://webster.cs.washington.edu/validate-css.php"><img src="https://webster.cs.washington.edu/images/w3c-css.png" alt="Valid CSS" /></a>
		</div>
		<?php banner(); ?>
	</body>
</html>

<!--The function for displaying the banner across the top of the page.  Is able to be a function because it does NOT rely on localized variables-->
<?php function banner() { ?>
	<div class="banner">
		<img src="https://webster.cs.washington.edu/images/rancidbanner.png" alt="Rancid Tomatoes" />
	</div>
<?php } ?>