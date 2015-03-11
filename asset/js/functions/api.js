function api_googlemap(location) {
	var key = 'key=AIzaSyBUf9ogGNsVH5qmWTxMTvmpkdtMIMFieHc';
	var q = '&q=' + location.replace(/\s?/, '+');
	var url = 'https://www.google.com/maps/embed/v1/place?';
	var src = '' + url + key + q;
	return (src);
}

function api_stampinfo(stamp_id) {
	$.ajax({
		url: 'http://etna.mages.agency/api/GetStampContent.php',
		type: 'GET',
		data: {"stampId":stamp_id},
		error:function() {
			$('.modal').modal('show');
			$('.et_stamp_title').html("Erreur api_stampinfo()");
		},
		success:function(tivi) {
			$('.modal').modal('show');
			$('.et_stamp_title').html(tivi.stampData.title);
			$('.stamp_img').html($('<img>').attr({src: tivi.stampData.image, onError:'this.onerror=null;this.src=./grafics/icone'}));
			$('.stamp_desc').html(tivi.stampData.desc);
		}
	});
}

function api_programm(part) {
	channel = localStorage.getItem('chaine');
	$.ajax({
		url: 'http://etna.mages.agency/api/GetAllContentForPartAndChannel.php',
		type: 'GET',
		data: {"channel":channel, "part": part},
		beforeSend: function (){
			$('.best_tweet').slideUp();
		},
		error:function() {console.log("Erreur api_programm()");},
		success:function(tivi) {
			$('.template.flux .linked ul').empty();
			var now = +new Date();
			if (tivi.programs[0].desc.length <= 140){
				$('.template.flux .infos .description').html(tivi.programs[0].desc);
				$('.template.flux .infos .more_text').empty();
				}
			else {
				$('.template.flux .infos .description').html(tivi.programs[0].desc.slice(0, 140)+"...");
				$('.template.flux .infos .more_text').html(tivi.programs[0].desc);
			}
			$('.et_stamp').empty();
			view_programme(tivi.programs[0]);
			if (part == 1) {
				$('.template.flux .info_horaire span').html("Commence à : " + get_time(tivi.programs[0].startTime));
				$('.template.flux .progress-bar').attr('style', 'width:100%;');
			}
			if (part == 0) {
				$('.template.flux .info_horaire span').html(get_time(tivi.programs[0].startTime) + " à "+ get_time(tivi.programs[0].endTime));
				$('.template.flux .progress-bar').attr('style', 'width:'+ get_timepercent(tivi.programs[0].startTime, tivi.programs[0].endTime)+'%;');
				for (i = 0; tivi.stamps[i]; i++){
					if (parseInt(tivi.stamps[i].timestamp) <= now)
						helper_check_url(tivi.stamps[i]);
				}
				api_twitter(tivi.programs[0].title, tivi.programs[0].channel);
				api_best_tweet(tivi.programs[0].title, tivi.programs[0].channel);
			}
		}
	});
}

function api_twitter(name, chaine) {
	$.ajax({
		url: 'http://etna.mages.agency/api/tendances.php',
		type: 'GET',
		data: {"h":name, "c": chaine},
		error:function() {console.log("Erreur api_twitter()");},
		success:function(tweets) {
			tweets = $.parseJSON(tweets);
			if (tweets == null) {
				$('.template.flux .top_tweets ul').empty();
				var template = $('.template.word > li').clone();
				$(template).append('<i class="fa fa-times-circle"></i> Aucune tendance');
				$('.template.flux .top_tweets ul').prepend(template);
				$('.top_tweets li').css({'height': tend_h, 'line-height': tend_h + 'px'});
			}
			else {
				view_best_words(tweets);
			}
		}
	});
}

function api_best_tweet(name, chaine) {
	$.ajax({
		url: 'http://etna.mages.agency/api/best-tweet.php',
		type: 'GET',
		data: {"h":name, "c": chaine},
		error:function() {console.log("Erreur api_best_tweet()");},
		success: function (data) {
			if (data[0][0] != null)
				view_best_tweet(data[0][0]);
		}
	});
}