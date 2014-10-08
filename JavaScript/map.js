//This is the main JS file for creating and populating the map.
//Map and marker functions by William May

var url = "js/apartments.json";
var apartmentData = {};
var map;

//Document ready function, renders and populates tha map.
$(function() {
	makeMap();
});

//This function creates the Google map featured on the page.
function makeMap() {
		map = new google.maps.Map($('.map-container')[0], {
		center: new google.maps.LatLng(47.662757, -122.314059),
		zoom: 15,
		minZoom: 15
	});
	addMarkers(); //Add markers to the map of apartment locations.
}

//Creates and places a marker on the map for each apartment. Registers an info window that appears above each marker when it is clicked.
function addMarkers() {
	$.getJSON(url, function(apartmentData) {
		for (var i = 0; i < apartmentData.length; i++) {
			var apartment = apartmentData[i];
			if (!apartment.avg) {
				apartment.avg = 'unrated';
			}
			var iwContent = '<div id="info-window"><h1>' + apartment.name + '</h1>' + '<ul><li>' + apartment.address + '</li><li>score: ' + apartment.avg + '</li><li><a href="review.shtml?name=' + apartment.name + '">Write a Review</a></li></ul></div>';
			if (apartment.address) { //Insures that the apartment has a location on the map
				var marker = new google.maps.Marker({
				map: map,
				position: new google.maps.LatLng(apartment.lat, apartment.lng),
				title: apartment.name
				});
			}
			var infoWindow = new google.maps.InfoWindow({ //Creates an Info Window for each marker.
				content: iwContent
			});
			//Calls function to register the Info Window.
			registerInfoWindow(marker, infoWindow, apartment);
			apartmentData[i].marker = marker;
		}
	});
}

//Called by the addMarkers() function to register the click event on each marker.  When a marker is clicked an info window 
//appears above it and more information about the apartment and its reviews appear in the detail window to the right of the map
function registerInfoWindow(marker, infoWindow, apartment) {
	google.maps.event.addListener(marker, 'click', function() {
		if (apartmentData.iw) {
			apartmentData.iw.close();
		}
		apartmentData.iw = infoWindow;
		infoWindow.open(map,marker);
		map.panTo(this.getPosition());
		fillDetailBox(apartment);
	});
}

//Centers the map on the corrdinates provided from the parameter "apartment"
function panWindow(apartment) {
	map.panTo(new google.maps.LatLng(apartment.lat, apartment.lng));
	map.setZoom(2);
}