//to display ribbon when after the header
document.addEventListener('scroll', function (event) {
	console.log(document.body.scrollTop > window.innerHeight);

	if(document.body.scrollTop > window.innerHeight){
		document.getElementById('contact').style.display = 'block';
	}

});
