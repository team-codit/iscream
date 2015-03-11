function helper_strip_accent(my_string) {
	var string = my_string.replace(/[èéêëēėę]/g, 'e').replace(/[äâáàãæåā]/g, 'a').replace(/[îïíìįī]/g, 'i')
							.replace(/[ôöòóøõœō]/g, 'o').replace(/[ûüùúū]/g, 'u').replace(/[çćč]/g, 'c')
							.replace(/[ñń]/g, 'n').replace(/ł/g, 'l');
	string = string.toLowerCase();
	return (string);
}

function helper_clean(name) {
	var hashtag = name;
	for (var key in hashtags){
		if (hashtags[key] == hashtag){
			var hashtag = key;
		}
	}
	if (hashtag == name) {
		var hashtag = "" + name.replace(/\s?\W?/g, '');
	}
	return (hashtag);
}

function helper_check_url(stamp) {
	var template = $('.template.magique > li').clone();
	calc_h = (($(window).height() - $('.important').height()) / 5) - 20;
	$(template).find('.item').html(stamp.name).attr('data-id', stamp.stampId);
	$(template).find('.item').css('background-image', 'url(' + stamp.image + ')').html(stamp.name).attr('data-id', stamp.stampId);
/*
	$.ajax({
		url: stamp.image,
		type: 'GET',
		data: {},
		success:function() {
		}
	});	
*/
	$('.linked ul').prepend(template);
	$('.linked li').css({'height': lien_h, 'line-height': lien_h + 'px'});
}

function helper_link(text) {
    var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/i;
    text = text.replace(exp, '<a href="$1" target="_blank">$1</a>');
    exp = /(^|\s)#(\w+)/g;
    text = text.replace(exp, '$1<a href="http://twitter.com/search?q=%23$2" target="_blank">#$2</a>');
    exp = /(^|\s)@(\w+)/g;
    text = text.replace(exp, '$1<a href="http://www.twitter.com/$2" target="_blank">@$2</a>');
    return text;
}