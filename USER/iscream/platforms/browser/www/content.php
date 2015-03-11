<div class="container-fluid" id="content">
	<div class="prev_affiches">
		
	</div>
	<div class="affiches">
		<a href="#" class="produit code">
			<img src="" class="affiche poster"/>
			<p class="titre title"></p>
			<p class="date release_date"></p>
		</a>
	</div>
	<a href="#" class="load_more"></a>
</div>


<div class="modal fade template_film" id="modal_film">
	<div class="modal-dialog desc_dialog wallpaper">
		<div class="modal-content desc_content">
			<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
			<div class="modal-body desc_body">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xs-offset-2 col-xs-8 col-sm-offset-1 col-sm-3">
							<img src="" class="img-responsive pull-right desc_affiche poster">	
						</div>
						<div class="col-xs-offset-2 col-xs-8 col-sm-offset-0 col-sm-7">
							<h1 class="desc_titre title"></h1>
							<span class="desc_date release_date"></span>
							<i class="fa fa-circle"></i>
							<span class="desc_duree runtime"></span>
							<i class="fa fa-circle"></i>
							<span class="desc_genre genres_string"></span>
							<i class="fa fa-circle"></i>
							<span class="desc_note">
								<div class="progress">
									<div class="progress-bar rating" role="progressbar" style="width: 75%;"></div>
								</div>
							</span>
							<p class="desc_description synopsis"></p>
							<p class="desc_casting">Acteurs: <span class="actors"></span></p>

							<table class="table offers">
								<tr>
									<th>VOD</th>
								</tr>
								<tr>
									<td>Acheter</td>
									<td>xx.xx €</td>
									<td><img src="img/buy.svg" alt="Buy" class="user_icon"/></td>
								</tr>
								<tr>
									<td>Louer</td>
									<td>xx.xx €</td>
									<td><img src="img/rent.svg" alt="Rent" class="user_icon"/></td>
								</tr>
								
								<tr>
									<th>DVD/BluRay</th>
								</tr>
								<tr>
									<td>Acheter</td>
									<td>xx.xx €</td>
									<td><img src="img/buy.svg" alt="Buy" class="user_icon"/></td>
								</tr>
								<tr>
									<td>Louer</td>
									<td>xx.xx €</td>
									<td><img src="img/rent.svg" alt="Rent" class="user_icon"/></td>
								</tr>
								
								<tr>
									<th>Cinéma</th>
								</tr>
								<tr>
									<td>Acheter</td>
									<td>xx.xx €</td>
									<td><img src="img/ticket.svg" alt="Ticket" class="user_icon"/></td>
								</tr>
							</table>
							
							
							<a href="#" class="col-xs-12 div_trailer trailer" data-trailer_url="">
								<i class="fa fa-play-circle"></i><span>Voir trailer</span>
							</a>
						</div>
					</div>
				</div>	
			</div>
		</div>
	</div>
</div>


<div class="modal fade template_movie" id="modal_trailer">
	<div class="modal-dialog trailer_dialog">
		<div class="modal-content trailer_content">
			<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
			<div class="modal-body trailer_body">
				<div class="embed-responsive embed-responsive-16by9 trailer">
			    	<iframe class="embed-responsive-item url_trailer" src="" frameborder="0" allowfullscreen="" style="height: 80%; width: 100%;"></iframe>
			    </div>
			</div>
		</div>
	</div>
</div>
<div class="modal" id="chargement">
	<div class="modal-dialog spinner">
		
	</div>
</div>