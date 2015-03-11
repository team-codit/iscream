function events_start() {
	$('.back_pro').hide();
	$('.template.flux .infos .more_text').hide();
	$('a.read_less').hide();
	$('body').on('click', '.go_to_chaines_tele', function(){
		control_menu();
	});
	
	$('body').on('click', '[data-chaine]', function(){
		control_chaine($(this).attr('data-chaine'));
	});
	$('body').on('click', '[data-id]', function(){
		stamp_id = $(this).attr('data-id');
		api_stampinfo(stamp_id);
	});
	
	tend_h = (($(window).height() - $('.important').height()) / tendances_h) - 20;
	lien_h = (($(window).height() - $('.important').height()) / liens_h) - 20;
	
	$('.top_tweets li').css({'height': tend_h, 'line-height': tend_h + 'px'});
	$('.linked li').css({'height': lien_h, 'line-height': lien_h + 'px'});
	
	$(window).on('resize', function() {
		tend_h = (($(window).height() - $('.important').height()) / tendances_h) - 20;
		lien_h = (($(window).height() - $('.important').height()) / liens_h) - 20;
		
		$('.top_tweets li').css({'height': tend_h, 'line-height': tend_h + 'px'});
		$('.linked li').css({'height': lien_h, 'line-height': lien_h + 'px'});
	});
	$('a.read_more').click(function(){
		$('.template.flux .infos .description').hide();
		$('.read_more').hide();
        $('.more_text').show();
        $('a.read_less').show();
    });	
    $('a.read_less').click(function(){
	    $('.template.flux .infos .description').show();
		$('.read_more').show();
        $('.more_text').hide();
        $('a.read_less').hide();
    });
    $('.back_pro').click(function(){
		api_programm(0);
		$('.back_pro').hide();
		$('.next_pro').show();
    });	

    $('.next_pro').click(function(){
		api_programm(1);
		$('.back_pro').show();
		$('.next_pro').hide();
    });	

    
}