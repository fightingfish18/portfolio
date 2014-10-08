//William Smyth May
//2013-06-07
//Section: AM

//This is the javascript for the babynames page

//This function is the modular function for the script.
(function() {
	"use strict";
	
	//This function initializes the page;
	window.onload = function() {
		document.getElementById("search").onclick = prep;
		initialize();
	};
	
	//This function initializes the page by loading the possible names into the box.
	function initialize() {
		var ajax = new XMLHttpRequest();
		ajax.onload = selectBox;
		ajax.open("GET", "https://webster.cs.washington.edu/cse154/babynames.php?type=list", true);
		ajax.send();
		ajax.onerror = error;
	}
	
	//This function fills the select box for possible names.
	function selectBox() {
		if (this.status == 200) {
			var response = this.responseText.split("\n");
			var menu = document.getElementById("allnames");
			for (var i = 0; i < response.length; i++) {
				var option = document.createElement("option");
				option.innerHTML = response[i];
				menu.appendChild(option);
			}
			menu.disabled = false;
			document.getElementById("loadingnames").classList.add("hidden");
		} else {
			errorMessage(this.status);
		}
	}
	
	//this function searches for the data associated with the specified name.
	function search() {
		var name = document.getElementById("allnames").value;
		if (name != "") {
			if (document.getElementById("genderm").checked) {
				var gender = "m";
			} else {
				var gender = "f";
			}
			var meaningRequest = new XMLHttpRequest();
			meaningRequest.onload = displayMeaning;
			meaningRequest.onerror = error;
			meaningRequest.open("GET", "https://webster.cs.washington.edu/cse154/babynames.php?type=meaning&name=".concat(name), true);
			meaningRequest.send();
			var rankRequest = new XMLHttpRequest();
			rankRequest.open("GET", "Https://webster.cs.washington.edu/cse154/babynames.php?type=rank&name=".concat(name).concat("&gender=").concat(gender), true);
			rankRequest.send();
			rankRequest.onload = displayRank;
			rankRequest.onerror = error;
			document.getElementById("resultsarea").style.display = "block";
			var celebs = new XMLHttpRequest();
			celebs.open("GET", "https://webster.cs.washington.edu/cse154/babynames.php?type=celebs&name=".concat(name).concat("&gender=").concat(gender), true);
			celebs.send();
			celebs.onload = displayCelebs;
			celebs.onerror = error;
		}
	}
	
	//This function displays the meaning of a given name.
	//Displays error message if not found.
	function displayMeaning() {
		if (this.status == 200) {
			var meaning = document.createElement("div");
			meaning.innerHTML = this.responseText;
			document.getElementById("meaning").appendChild(meaning);
			document.getElementById("loadingmeaning").classList.add("hidden");
		} else {
			errorMessage(this.status);
		}
	}
	
	//This function displays the rank for a given name and gender combination.
	//If ranking data is not found (error: 410), alerts user.
	//If other error is present, displays relevant message;
	function displayRank() {
		if (this.status == 200 || this.status == 410) {
			var response = this.responseXML;
			if (!response) {
			rankError();
			} else {
				var ranks = response.getElementsByTagName("rank");
				var row = document.createElement("tr");
				for (var i = 0; i < ranks.length; i++) {
					var year = ranks[i].getAttribute("year");
					var header = document.createElement("th");
					header.innerHTML = year;
					row.appendChild(header);
				}
				var row2 = document.createElement("tr");
				row2.setAttribute("id", "tallRow");
				for (var i = 0; i < ranks.length; i++) {
					var newTd = document.createElement("td");
					var rank = ranks[i].textContent;
					var div = document.createElement("div");
					div.classList.add("bar");
					if (rank > 0) {
						div.style.height = parseInt((1000 - rank) * 0.25) + "px";
					} else {
						div.style.height = 0;
					}
					div.innerHTML = rank;
					if (rank <= 10 && rank > 0) {
						div.classList.add("redText");
					}
					newTd.appendChild(div);
					row2.appendChild(newTd);
				}
				document.getElementById("graph").appendChild(row);
				document.getElementById("graph").appendChild(row2);
			}
			document.getElementById("loadinggraph").classList.add("hidden");
		} else {
			rankError(this.status);
		}
	}
	
	//Displays celeberties with the same first name and gender as the specified name/gender.
	//If no celeberties are found, displays nothing.
	//If other error is found, explains what went wrong.
	function displayCelebs() {
		if (this.status == 200) {
			var foundCelebs = JSON.parse(this.responseText);
			var refined = foundCelebs.actors;
			for (var i = 0; i < refined.length; i++) {
				var item = document.createElement("li");
				item.innerHTML = refined[i].firstName + " " + refined[i].lastName + " (" + refined[i].filmCount + " films)";
				document.getElementById("celebs").appendChild(item);
			}
			document.getElementById("loadingcelebs").classList.add("hidden");
		} else {
			errorMessage(this.status);
		}
	}
	
	//Clears the results area
	function clear() {
		document.getElementById("graph").innerHTML = "";
		document.getElementById("meaning").innerHTML = "";
		document.getElementById("loadingmeaning").classList.remove("hidden");
		document.getElementById("loadingcelebs").classList.remove("hidden");
		document.getElementById("loadinggraph").classList.remove("hidden");
		document.getElementById("celebs").innerHTML = "";
		document.getElementById("resultsarea").style.display = "none";
		document.getElementById("norankdata").style.display = "none";
	}
	
	//preps the form to be searched, as well as clearing it for subsequent queries.
	function prep() {
		clear();
		search();
	}
	
	//Calls the errorMessage
	function error() {
		errorMessage(this.status);
	}
	
	//Displays an associated error code and message for a given error.
	function errorMessage(status) {
		clear();
		var div = document.createElement("div");
		div.setAttribute("id", "error");
		if (status == 404) {
			div.innerHTML = "Your request produced a 404 error.  That means the page you tried to access does not exist.";
		} else if (status == 403) {
			div.innerHTML = "Your request produced a 403 error.  This means that you don't have access to the page.";
		} else if (status == 400) {
			div.innerHTML = "Your request produced a 400 error.  This means that your syntax is bad.  Please double check it and try again.";
		} else {
			div.innerHTML = "Your request produced a " + status + " error.  Please verify that your queries are correct and that you have access to all resources.";
		}
		document.getElementById("namearea").appendChild(div);
	}
	
	//If no ranking data is found, prepared div is visible.
	function rankError() {
		document.getElementById("norankdata").style.display = "block";
	}
}());
