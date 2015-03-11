base_url = "http://api.iscream.mages.agency/";
page = 'movies';
number = 1;
max_number = 21;
genre = '';
sort = 'toprank';
limit = 50;
can_go = 1;
now_scroll = 0;

genres = [
	{genre: 'Tous'},
	{genre: 'Action'},
	{genre: 'Animation'},
	{genre: 'Aventure'},
	{genre: 'Comédie'},
	{genre: 'Comédie dramatique'},
	{genre: 'Documentaire'},
	{genre: 'Drame'},
	{genre: 'Epouvante-horreur'},
	{genre: 'Famille'},
	{genre: 'Fantastique'},
	{genre: 'Historique'},
	{genre: 'Policier'},
	{genre: 'Romance'},
	{genre: 'Science fiction'},
	{genre: 'Thriller'},
	{genre: 'Western'}
];

film_directives = {
	poster: {src: function() {return this.poster;}},
	wallpaper: {style: function() {return "background-image: url('" + this.wallpaper + "')";}, html: function() {return '';}},
	rating: {style: function() {return 'width: ' + this.rating + '%;';}, html: function() {return '';}},
	trailer: {'data-trailer_url': function() {return this.trailer;}, html: function() {return '';}},
	name: {href: function() {return 'http://www.google.fr/movies?hl=fr&q=' + this.title;}, html: function() {return '';}}
};

links_vod_directives = {
	min_url: {href: function() {return this.min_url;}, html: function() {return '';}},
	img: {src: function() {return this.img;}}
	
};

links_dvd_directives = {
	url: {href: function() {return this.url;}, html: function() {return '';}},
};

affiches_directives = {
	poster: {src: function() {return "http://api.iscream.mages.agency/img/" + this.code + "_thumb.jpg";}},
	code: {
		'data-produit': function() {return this.code;},
		'data-type': function() {return page;},
		html: function() {return '';}
	}
};

suggest_directives = {
	poster: {src: function() {
		if (this.poster == "")
			return "img/no-affiche.png";
		else
			return this.poster;
	}, style: function() {return "background-image: url('" + this.poster + "')";}},
	code: {
		'data-produit': function() {return this.code;}, html: function() {return '';}
	},
	type: {
		'data-type': function() {return this.type + 's';}
	}
};
genres_directives = {
	genre: {
		'data-genre': function() {
			if (this.genre == "Tous")
				return "";
			else
				return this.genre;
		}
	},
	li: {
		'class': function() {
			if (this.genre == "Tous")
				return "active";
		}
	}
};

(function ($) {
    $.fn.delayKeyup = function(callback, ms){
        var timer = 0;
        $(this).keyup(function(){                   
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        });
        return $(this);
    };
})(jQuery);