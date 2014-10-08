<?php
	//This file is the php code that allows users to submit a review on The Dawg House.
	//Composed by William Smyth May.
	$apartmentName = $_POST['aptName'];
	$apartmentData = json_decode(file_get_contents('http://students.washington.edu/wsmay1/info343/final/js/apartments.json'));
	
	//Iterates over the json object to find the requested apartment name
	$scores = array();
	foreach ($apartmentData as $apt) {
		if ($apt -> name == $apartmentName) {
			$found = true; //boolean that specifies that the apartment was found.
			$reviews = $apt -> reviews;
			array_push($reviews, $_POST);
			$index = $apt -> index;
			$apartmentData[$apt -> index] -> reviews = $reviews; //adds the new review to the actual JSON object
			
			//Calculates the average score of the apartment with the new review.
			foreach($reviews as $review) {
				array_push($scores, $review -> rating);
			}
			$avg = round((array_sum($scores) + $_POST['rating']) / count($scores), 1);
			$apartmentData[$apt -> index] -> avg = $avg; //assigning the average score to the JSON object.
			
			$json = json_encode($apartmentData); //The version of php on our hosting does NOT support JSON_PRETTY_PRINT, so it is encoded on one line.
			file_put_contents('../js/apartments.json', $json); //rewrites the JSON object to the JSON file.
			header('Location: http://students.washington.edu/wsmay1/info343/final/success.html'); //redirect users to a page notifying them of their successful review
			die();
		}
	}
	
	//If the apartment name specified by the user is not found, the user is redirected and alerted of the error
	if(!$found) {
		header('Location: http://students.washington.edu/wsmay1/info343/final/failure.html');
		die();
	}
?>