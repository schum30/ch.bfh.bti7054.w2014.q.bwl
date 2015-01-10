function addScrollListener() {
	var navigation = document.getElementById('navigation');
	var basket = document.getElementById('basket');
	var body = document.getElementsByTagName("body")[0];	

	var isFixed = false;
	document.addEventListener(
		'scroll',
		function() {
			var headerHeight = parseInt(getCssProperty('header', 'height'));
			var navHeight = parseInt(getCssProperty('navigation', 'height'));
			var scrollTop = document.documentElement.scrollTop;
			var shouldBeFixed = scrollTop > headerHeight;
			
			if (shouldBeFixed && !isFixed) {
				addClass(body, 'fixed');
				
				isFixed = true;

			}	else if (!shouldBeFixed && isFixed) {

				removeClass(body, 'fixed');
				
				isFixed = false;
			}
		},
		false
	)
};	

function getCssProperty(elmId, property){
	var elem = document.getElementById(elmId);
	return window.getComputedStyle(elem,null).getPropertyValue(property);
};

function getYPos(obj) {
	var curtop = 0;
	if (obj && obj.offsetParent) {
		do {
			curtop += obj.offsetTop;
		} while (obj = obj.offsetParent);
	}
	return curtop;
};

function addClass(element, className) {
	element.className += ' ' + className;
}

function removeClass(element, className) {
	var i;
	var j;
	var newClassName = "";
    var classes = element.className.split(" ");
	var classesToRemove = className.split(" ");
    for(i = 0; i < classes.length; i++) {
		var classToRemove = false;
		for(j = 0; j < classesToRemove.length; j++) {
			if(classes[i] == classesToRemove[j]) {
				classToRemove = true;
			}
		}
		if(!classToRemove) {
			newClassName += classes[i] + " ";
		}
    }
    element.className = newClassName;
}

function showPopUpAlert(title, text) {
	var popupElement = document.getElementById('input-blocker');
	var titleElement = document.getElementById('alert-pop-up-title');
	var textElement = document.getElementById('alert-pop-up-text');

	titleElement.innerHTML = title;
	textElement.innerHTML = text;
	addClass(popupElement, 'visible alert');
};

function hidePopUpAlert() {
	var popupElement = document.getElementById('input-blocker');
	removeClass(popupElement, 'visible alert');
};

function showPopUpLogin() {
	var popupElement = document.getElementById('input-blocker');
	addClass(popupElement, 'visible login');
};

function hidePopUpLogin() {
	var popupElement = document.getElementById('input-blocker');
	removeClass(popupElement, 'visible login');
};

window.onload = addScrollListener;