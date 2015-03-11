function get_time(timestamp) {
	var heures = timestamp.slice(8,10);
	var minutes = timestamp.slice(10,12);
	var horaire = heures + 'h' + minutes;
	return(horaire);
}
function timestamp_convert(time) {
	var aa = parseInt(time.slice(0,4));
	var mm = parseInt(time.slice(4,6)) - 1;
	var jj = parseInt(time.slice(6,8));
	var hh = parseInt(time.slice(8,10));
	var min = parseInt(time.slice(10,12));
	var ss = parseInt(time.slice(12,14));
	var stamp = +new Date(aa, mm, jj, hh, min, ss);
	return (stamp);
}

function get_timepercent(start, end) {
	var st = timestamp_convert(start);
	var en = timestamp_convert(end);
	var now = new Date().getTime();
	var percent = ((now - st) / (en - st)) * 100;
	return (percent);
}