function control_from_keyboard() {
	$(document).on('keydown', function(event){
	    var key = event.which;
	    if (key >= 96 && key <= 105) {
	    	nombre = key - 96;
			control_chaine(nombre);
		}
		if (key >= 49 && key <= 57) {
	    	nombre = key - 48;
			control_chaine(nombre);
		}
		if (key == 38 || key == 39) 
			control_chaine(chaine_plus);
		if (key == 40 || key == 37) 
			control_chaine(chaine_moins);
	});
}

function control_menu() {
	$('.chaines_tele').fadeIn();
}

function control_flux(){
	$('.active').fadeOut(function() {
		$(this).removeClass('active');
		api_programm(0);
		$('.flux').fadeIn(200, function() {
			$(this).addClass('active');
		});
	});
}

function control_chaine(chaine) {
	$('.chaines_tele').fadeOut();
	localStorage.setItem('chaine', chaine);
	if ((parseInt(chaine) + 1) > 36)
		chaine_plus = 1;
	else
		chaine_plus = (parseInt(chaine) + 1);
	if ((parseInt(chaine) - 1) < 1)
		chaine_moins = 36;
	else
		chaine_moins = (parseInt(chaine) - 1);
	
	$('.controls_chanel a.left').attr('data-chaine', chaine_moins);
	$('.controls_chanel a.right').attr('data-chaine', chaine_plus);
	$('.top_tweets ul, .linked ul').empty();
	control_flux();
}