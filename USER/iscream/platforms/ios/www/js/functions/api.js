function api(request, data, func, loading) {
	$.ajax({
		type: "GET",
		url: base_url + request,
		data: data,
		beforeSend: function() {
			if (loading == true)
			{
				$('#chargement').fadeIn();
			}
			console.log(base_url + request + '?' + $.param(data) );
		},
		success: function(data)
		{
			if (loading == true){
				$('#chargement').hide();
			}
			func(data);
		}
	});
}