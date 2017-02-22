	<div class="secondary-nav" style="background-image: url('{AVATARIMAGE}{LOOK}&direction=2&head_direction=2&gesture=sml'); background-repeat: no-repeat; background-position: 21% 30%;">
		<div class="container">
			<div class="row">
				<div class="col-md-6" style="margin-top: 17px;margin-left: 6%;">
					<p style="color: #FFF; line-height: 1;"><b>Última conexión:</b> {LASTC}</p>
				</div>
			</div>
		</div>
	</div>



<hr class="invisible">

    <div class="container">
        <div class="row">
<div class="col-md-12">
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-6">
                        <h3>Resultados de su busqueda</h3>
                        <p>{ERROR}</p>
                    </div>
                    <div class="col-md-6">
                        <h3><i class="fa fa-search"></i>&nbsp;&nbsp;Hacer otra búsqueda</h3>
<form action="/functions.php" method="POST" id="search_form">
						<input class="form-control navbar-search-input" ng-model="search" placeholder="Buscar usuario en {SHORTNAME}&hellip;" name="search" type="text">
					</form>                   
					</div>
                </div>

                <h3 class="box-title search-users">Usuarios</h3>
                <div class="box-content">
                                        <div class="box-inner-footer no-more">
                            {ERROR}
                        </div>
                                                                    </div>
                        </div>
                                                                            </div>
            </div>
