function load_film(code, type) {
	$('.vod_dvd').hide();
	$('.chargement').show();
	api('cards', {code: code, type: type}, function(film) {
		$('.template_film').render(film, film_directives);
		$('#modal_film').modal('show');
		
		api('links', {code: code, name: film.title}, function(links) {
			
			$('.vod_panel, .dvd_panel').hide();
			if (links.vod.length > 1)
			{
				$('.services_vod').render(links.vod, links_vod_directives);	
				$('.vod_panel').show();
			}
			if (links.dvd.length > 1)
			{
				$('.services_dvd').render(links.dvd, links_dvd_directives);	
				$('.dvd_panel').show();
			}
		}, false);
	}, true);
		
	$('.chargement').hide();
	$('.vod_dvd').fadeIn();

}

function load_affiches(page, number, genre, limit, sort) {
	api('products/' + page, {page: number, limit: limit, sort: sort, genres: genre}, function(affiches) {
		console.log(affiches);
		if (affiches.list.length > 1)
			$('.affiches').render(affiches.list, affiches_directives);
		else
		{
			number++;
			load_affiches(page, number, genre, limit, sort);
		}
	}, true);
}

function load_suggest(query) {
	api('search/', {limit: "3", q: query}, function(suggest) {
		$('.suggestions').render(suggest, suggest_directives);
	}, false);
}

function load_genres() {
	$('.genres').render(genres, genres_directives);
}