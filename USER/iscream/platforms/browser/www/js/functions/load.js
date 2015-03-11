function load_film(code, type) {
	api('cards', {code: code, type: type}, function(film) {
		$('.template_film').render(film, film_directives);
		$('#modal_film').modal('show');
	}, true);
}

function load_affiches(page, number, genre, limit, sort) {
	loading = (number > 1) ? true : false;
	loading = (genre.length > 0) ? true : false;
	api('products/' + page, {page: number, limit: limit, sort: sort, genres: genre}, function(affiches) {
		console.log(affiches);
		if (affiches.list.length > 1)
			$('.affiches').render(affiches.list, affiches_directives);
		else
		{
			number++;
			load_affiches(page, number, genre, limit, sort);
		}
	}, loading);
}

function load_suggest(query) {
	api('search/', {limit: "3", q: query}, function(suggest) {
		$('.suggestions').render(suggest, suggest_directives);
	}, false);
}

function load_genres() {
	$('.genres').render(genres, genres_directives);
}