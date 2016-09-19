//fade in effect based on http://youmightnotneedjquery.com/
var contact = document.getElementById('contact');

//to display ribbon when after the header
document.addEventListener('scroll', function (event) {
	// check if the scroll has passed header
	if(document.body.scrollTop > window.innerHeight && contact.style.display == 'none' ){
		//show the ribbon with fade effect on icons
		contact.style.display = 'block' ;
	}else if(document.body.scrollTop < window.innerHeight){
		// hide the ribbon
		contact.style.display = 'none' ;
	}

});
