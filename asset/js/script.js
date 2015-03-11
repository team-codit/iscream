$(document).ready(function() {
	events_start();
	view_menu();
	control_from_keyboard();
	start();
});

function start() {
	if (localStorage.getItem('chaine'))
		control_chaine(localStorage.getItem('chaine'));
	else
		control_chaine(1);
	setInterval(api_programm(0), 20000);
}