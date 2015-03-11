function events() {
    $('body').on('click', '[data-produit]', function() {
        var code = $(this).attr('data-produit');
        var type = $(this).attr('data-type');
        load_film(code, type);
    });

    $('body').on('click', '[data-genre]', function() {
	    number = 1;
        genre = $(this).attr('data-genre');
        genre_a = (genre == '') ? 'Tous' : genre;
        $('.genre_active').html(genre_a);
        $('.prev_affiches').empty();
        load_affiches(page, number, genre, limit, sort);
    });
    $('body').on('click', '.load_more', function() {
        if (number < max_number && can_go == 1) {
            number++;
            $('.affiches').clone().removeClass('affiches').appendTo('.prev_affiches');
            load_affiches(page, number, genre, limit, sort);
        }
    });

    $('body').on('click', '.activator', function() {
        $(this).parent().children('.active').removeClass('active');
        $(this).addClass('active');
    });

    $('#modal_film').on('click', '[data-trailer_url]', function() {
        var url = $(this).attr('data-trailer_url');
        $('.url_trailer').attr('src', url);
        $('#modal_trailer').modal('show');
    });

    $('#modal_trailer').on('hidden.bs.modal ', function() {
        $('.url_trailer').attr('src', '');
    });

    $('.events_search').on('focusout', '#search', function() {
        $('.suggestions').fadeOut();
    });

    $('#search').delayKeyup(function() {
        var q = $('#search').val();
        if (q.length > 2) {
            $('.suggestions').show();
            load_suggest(q);
        } else {
            $('.suggestions').hide();
        }
    }, 300);

    $(window).scroll(function() {
        if ($(window).scrollTop() == $(document).height() - $(window).height() && number < max_number && can_go == 1) {
            number++;
            $('.affiches').clone().removeClass('affiches').appendTo('.prev_affiches');
            load_affiches(page, number, genre, limit, sort);
        }
        
		if ($(window).scrollTop() > 81 && now_scroll < $(window).scrollTop()) {
			$('.navbar, .events_search').stop().fadeOut();
		}
		else {
			$('.navbar, .events_search').stop().fadeIn();
		}
        now_scroll = $(window).scrollTop();
        
    });


    $('body').on('click', '[data-sort]', function() {
        sort = $(this).attr('data-sort');
        $('.sort_active').html($(this).html());
        $('.prev_affiches').empty();
        load_affiches(page, number, genre, limit, sort);
    });

}