//Wiliam Smyth May
//2013-05-22
//Section: AM

//This file contains the javascript functions for use in the ASCIImations page.

"use strict";

var SELECTION = "";
var SET = 0;
var FRAMES = "";
var TIMER;
var INTERVAL = 250;
var ANIMATION;

//Intialiazes the page and prepares elements for interaction.
window.onload = function() {
	document.getElementById("animation").onchange = animationDisp;
	document.getElementById("start").onclick = animate;
	document.getElementById("size").onchange = sizeChange;
	document.getElementById("stop").onclick = stop;
	document.getElementById("stop").disabled = true;
	var buttons = document.getElementsByName("speed");
	for (var i = 0; i < buttons.length; i++) {
		buttons[i].onclick = setSpeed;
	}
};

//Displays the string chosen whenever an option is selected from the dropdown menu.
function animationDisp() {
	var choice = document.getElementById("animation");
	var display = choice.value;
	SELECTION = ANIMATIONS[display];
	document.getElementById("box").value = SELECTION;
}

//Displays the frames needed for the current step in the animation.
function animationStart() {
	document.getElementById("box").value = FRAMES[SET];	
	SET++;
	if (SET == FRAMES.length) {
		SET = 0;
	}
}

//Adjusts the font size in the textarea.
function sizeChange() {
	var size = document.getElementById("size").value;
	document.getElementById("box").style.fontSize = size + "pt";
}

//Begins the animation when the start button is pushed.
function animate() {
	ANIMATION = document.getElementById("box").value;
	FRAMES = ANIMATION.split("=====\n");
	animationStart();
	TIMER = setInterval(animationStart, INTERVAL);
	document.getElementById("start").disabled = true;
	document.getElementById("stop").disabled = false;
}

//Stops the animation and displays the currently selected option.
function stop() {
	clearInterval(TIMER);
	SET = 0;
	document.getElementById("box").value = ANIMATION;
	document.getElementById("stop").disabled = true;
	document.getElementById("start").disabled = false;
}

//Adjusts the speed of animation.
//Insures that there is no gap in speed changes.
function setSpeed() {
	INTERVAL = this.value;
	if (document.getElementById("start").disabled) {
		clearInterval(TIMER);
		TIMER = setInterval(animationStart, INTERVAL);
	}
}

	
