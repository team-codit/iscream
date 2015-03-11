function view_menu() {
	$.each(chaines, function(index, value){
		$('.chaines_tele .chaines').append('<div class="col-xs-4 col-sm-2 col-md-2 col-lg-2 data_chaine"><a href="#" data-chaine="' + (index + 1) + '"><img src="' + this + '"></a></div>');
	});
}

function view_programme(val){
	var row = $('.template.flux > div > .item');
	row.attr('style', "background-image: url('" + decodeURIComponent(val.image) + "');");
	row.find("h2").empty().append(val.title).append($('<img>').attr({src: "grafics/chaines/" + val.channel + ".png", alt: val.channel}));
}

function view_best_words(data) {
	calc_h = (($(window).height() - $('.important').height()) / 5) - 20;
	$.each(data, function(i, mot){
		var template = $('.template.word > li').clone();
		if (i == 0)
			$('.template.flux .top_tweets ul').empty();
		setTimeout(function(){
			$(template).append(mot);
			$('.template.flux .top_tweets ul').prepend(template);$('.top_tweets li').css({'height': tend_h, 'line-height': tend_h + 'px'});
		}, 1000 * i/3);
	});
}

function view_best_tweet(data) {
	$('.best_tweet').slideDown();
	$('.best_tweet .name').html(data['user_name']);
	$('.best_tweet .user').html(helper_link(data['user_screen_name']));
	$('.best_tweet .tweet').html(helper_link(data['tweet']));
	$('.best_tweet .time').html(helper_link(data['time']));
	$('.best_tweet .retweet').html(data['retweet_count']);
	$('.best_tweet .star').html(data['favorite_count']);
	$('.best_tweet .link').attr('href', data['url']);
}