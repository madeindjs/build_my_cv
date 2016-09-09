//fade in effect based on http://youmightnotneedjquery.com/
function fadeIn(el) {
	el.style.opacity = 0;
	el.style.display = 'block';

	var tick = function() {
		el.style.opacity = +el.style.opacity + 0.01;

		if (+el.style.opacity < 1) {
			(window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick, .01)
		}
	};

	tick();
}

var contact = document.getElementById('contact');

//to display ribbon when after the header
document.addEventListener('scroll', function (event) {
	// check if the scroll has passed header
	if(document.body.scrollTop+150 > window.innerHeight && contact.style.display == 'none'){
		//show the ribbon with fade effect on icons
		contact.style.display = 'block' ;
		var contact_icons = document.getElementById('contact_icons');
		fadeIn(contact_icons);
	}else if(document.body.scrollTop < window.innerHeight){
		// hide the ribbon
		contact.style.display = 'none' ;
	}

});
