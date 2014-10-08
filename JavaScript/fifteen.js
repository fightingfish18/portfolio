//William Smyth May
//2013-05-31
//Section AM

//This is the javascript file for the fifteen puzzle

//This is the module style function.
(function () {	
	"use strict";

	var emptyX = 300;
	var emptyY = 300;
	var boxes;
	
	//This begins to establish the puzzle when the window loads.
	window.onload = function() {
		initialize();
		boxes = document.getElementsByClassName("boxes");
		for (var i = 0; i < boxes.length; i++) {
			boxes[i].onclick = move;
			boxes[i].onmouseover = hovered;
		}
		document.getElementById("shufflebutton").onclick = shuffle;
	};
	
	//This function arranges the boxes inside the puzzle area.
	function initialize() {
		var positionX = 0;
		var positionY = 0;
		var backgroundX = 0;
		var backgroundY = 0;
		for (var i = 1; i < 16; i++) {
			var div = document.createElement("div");
			div.classList.add("boxes");
			div.setAttribute("id", i);
			div.innerHTML = i;
			div.style.position = "absolute";
			div.style.left = positionX + "px";
			div.style.top = positionY + "px";
			div.style.backgroundPosition = backgroundX + "px " + backgroundY + "px";
			document.getElementById("puzzlearea").appendChild(div);
			positionX += 100;
			backgroundX -= 100;
			if (i % 4 == 0) {
				positionX = 0;
				positionY += 100;
				backgroundX = 0;
				backgroundY -= 100;
			}
		}
	}

	//This function moves the clicked puzzle piece.
	function move() {
		var newX = parseInt(this.style.left);
		var newY = parseInt(this.style.top);
		if (verifyMove(newX, newY)) {
			this.style.left = emptyX + "px";
			this.style.top = emptyY + "px";
			emptyX = newX;
			emptyY = newY;
		}
	}

	//This function makes sure that a piece is legal to be moved.
	function verifyMove(newX, newY) {
		if ((Math.abs(newX - emptyX) + Math.abs(newY - emptyY)) <= 100) {
			return true;
		}
		return false;
	}

	//This function shuffles the board when the user clicks shuffle.
	//Uses the move() function to make sure that there is always a valid solution.
	function shuffle() {
		var validMove = [];
		var l = 0;
		for (var j = 0; j < 1000; j++) {
			for (var i = 0; i < boxes.length; i++) {
				var newX = parseInt(boxes[i].style.left);
				var newY = parseInt(boxes[i].style.top);
				if (verifyMove(newX, newY)) {
					validMove[l] = boxes[i];
					l++;
				}
			}
			var k = Math.floor(Math.random() * validMove.length);
			validMove[k].click();
		}
	}

	//This function enables the tiles to glow red onhover.
	function hovered() {
		var newX = parseInt(this.style.left);
		var newY = parseInt(this.style.top);
		if (verifyMove(newX, newY)) {
			this.classList.add("hoverValid");
		} else {
			this.classList.remove("hoverValid");
		}
	}
}());
			