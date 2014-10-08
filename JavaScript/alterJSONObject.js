//This file is a test script, and should not be considering in grading our project.
//This file is here specifically for archival purposes, and should, under no circumstances, ever be run without the explicit permission of William May.

var url = "js/apartments.json";
var apartmentData = {};

$(function() {
	//giveCoordinates();
	giveIndex();
});

function giveCoordinates() {
	var geocoder = new google.maps.Geocoder();
	var i = 0;
	$.getJSON(url, function(apartmentData) {
		var setTime = setInterval(function() {
			geocoder.geocode({address: apartmentData[i].address + ' ' + apartmentData[i].city}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					apartmentData[i].lat = results[0].geometry.location.lat();
					apartmentData[i].lng = results[0].geometry.location.lng();
				} else {
					console.log(status);
				}
				i++
			});
			if (i == apartmentData.length - 1) {
				clearInterval(setTime);
				postData(apartmentData);
			}
		}, 2000);
	});
}

function giveIndex() {
	$.getJSON(url, function(apartmentData) {
		for (var i = 0; i < apartmentData.length; i++) {
			apartmentData[i].index = i;
		}
		postData(apartmentData);
	});
}

function postData(apartmentData) {
	$('.data').val(JSON.stringify(apartmentData));
	$('.sub').submit();
}